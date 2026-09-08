<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;
use Throwable;

class MakeMobileProCommand extends Command
{
    protected $signature = 'make:mobile-pro
        {name : Emri i Modelit}
        {--model= : FQN e plotë e modelit nëse zbulimi automatik dështon (p.sh. App\\Models\\Fleet\\Vehicle)}
        {--force : Mbishkruaj skedarët pa pyetur}';

    protected $description = 'Gjeneron modulin Mobile Pro duke përdorur DTOs dhe Actions (DDD Architecture)';

    private string $className;
    private string $snakeName;
    private string $pluralSnake;
    private string $pluralKebab;
    private array $meta = [];

    public function handle(): int
    {
        $this->className = Str::studly($this->argument('name'));
        $this->snakeName = Str::snake($this->className);
        $this->pluralSnake = Str::plural($this->snakeName);
        $this->pluralKebab = Str::kebab(Str::plural($this->className));

        $this->info("🚀 Duke përpunuar modulin PREMIUM DDD: {$this->className}");

        if (!$this->resolveMeta()) return self::FAILURE;

        if (!$this->confirmOverwrite()) {
            $this->warn('Anulluar — përdor --force për të mbishkruar pa pyetje.');
            return self::FAILURE;
        }

        try {
            $this->generateController();
            $this->registerRoutes();
            $this->generateDartModel();
            $this->generateFlutterListPage();
            $this->generateFlutterFormPage();

            $this->callSilently('route:clear');
            $this->info("✅ Moduli {$this->className} u përfundua me DTO & Action Support!");
        } catch (Throwable $e) {
            $this->error("❌ Gabim: " . $e->getMessage());
            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    /** Skedarët që ky komandë do të gjenerojë/mbishkruajë. */
    private function targetPaths(): array
    {
        return [
            app_path("Http/Controllers/Api/Mobile/{$this->className}Controller.php"),
            base_path("mobile-gateway/lib/models/{$this->snakeName}.dart"),
            base_path("mobile-gateway/lib/modules/dashboard/{$this->snakeName}_list_page.dart"),
            base_path("mobile-gateway/lib/modules/dashboard/{$this->snakeName}_form_screen.dart"),
        ];
    }

    /** Nëse skedarët ekzistojnë tashmë, kërko --force ose konfirmim interaktiv. */
    private function confirmOverwrite(): bool
    {
        if ($this->option('force')) return true;

        $existing = array_filter($this->targetPaths(), fn($p) => File::exists($p));
        if (empty($existing)) return true;

        $this->warn('Skedarët e mëposhtëm ekzistojnë tashmë:');
        foreach ($existing as $p) $this->line("  - {$p}");

        return $this->confirm('Dëshiron t\'i mbishkruash?', false);
    }

    /**
     * Zbulon FQN-në e modelit.
     * Radha: --model manual → kandidatë të zakonshëm → skanim rekursiv i app/Models.
     * Kjo zëvendëson listën fikse me 3 rrugë, që thyhej sapo modeli ndodhej
     * në një nënfolder tjetër nga BerberApp\.
     */
    private function discoverModelClass(): ?string
    {
        if ($manual = $this->option('model')) {
            $manual = ltrim($manual, '\\');
            return class_exists($manual) ? $manual : null;
        }

        $candidates = [
            "App\\Models\\BerberApp\\{$this->className}",
            "App\\Models\\{$this->className}",
            "App\\{$this->className}",
        ];
        foreach ($candidates as $candidate) {
            if (class_exists($candidate)) return $candidate;
        }

        $modelsPath = app_path('Models');
        if (!File::isDirectory($modelsPath)) return null;

        foreach (File::allFiles($modelsPath) as $file) {
            if ($file->getFilenameWithoutExtension() !== $this->className) continue;
            $relative = str_replace(['/', '.php'], ['\\', ''], $file->getRelativePathname());
            $fqn = "App\\Models\\{$relative}";
            if (class_exists($fqn)) return $fqn;
        }

        return null;
    }

    private function resolveMeta(): bool
    {
        $modelClass = $this->discoverModelClass();

        if (!$modelClass) {
            $this->error("Modeli {$this->className} nuk u gjet automatikisht.");
            $this->line("Provo: php artisan make:mobile-pro {$this->className} --model=App\\Models\\RrugaJote\\{$this->className}");
            return false;
        }

        $model = new $modelClass();

        // Detektojme nese ka DTO, Action, Query dhe Event per kete domain
        // Struktura reale e projektit: App\Domain\{Model}\{DTOs,Actions,Events,Queries}
        // Konventa reale (verifikuar te CallLog): {Model}DTO, Create/Update/Delete{Model}Action, {Model}ListQuery
        $domainPath = "App\\Domain\\{$this->className}";
        $dtoClass = "{$domainPath}\\DTOs\\{$this->className}DTO";
        $createActionClass = "{$domainPath}\\Actions\\Create{$this->className}Action";
        $updateActionClass = "{$domainPath}\\Actions\\Update{$this->className}Action";
        $deleteActionClass = "{$domainPath}\\Actions\\Delete{$this->className}Action";
        $listQueryClass = "{$domainPath}\\Queries\\{$this->className}ListQuery";

        $this->meta = [
            'class' => $this->className,
            'model_fqn' => $modelClass,
            'fields' => array_values(array_filter($model->getFillable(), fn($f) => !in_array($f, ['id', 'created_at', 'updated_at', 'deleted_at']))),
            'json_fields' => array_keys(array_filter($model->getCasts(), fn($c) => in_array($c, ['array', 'json', 'object', 'collection']))),
            'relations' => $this->discoverRelations($modelClass),
            'dto_class' => class_exists($dtoClass) ? $dtoClass : null,
            'create_action' => class_exists($createActionClass) ? $createActionClass : null,
            'update_action' => class_exists($updateActionClass) ? $updateActionClass : null,
            'delete_action' => class_exists($deleteActionClass) ? $deleteActionClass : null,
            'index_query' => class_exists($listQueryClass) ? $listQueryClass : null,
        ];
        return true;
    }

    private function discoverRelations(string $modelClass): array
    {
        $relations = [];
        $methods = (new ReflectionClass($modelClass))->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            if ($method->class !== $modelClass || $method->getNumberOfParameters() > 0) continue;
            try {
                $return = $method->invoke(new $modelClass());
                if ($return instanceof \Illuminate\Database\Eloquent\Relations\BelongsTo) {
                    $relatedShort = class_basename($return->getRelated());
                    $relations[$return->getForeignKeyName()] = [
                        'method' => $method->name,
                        // Endpoint duhet te perputhet me modelin real te lidhur (VehicleBrand -> vehicle-brands),
                        // jo me emrin e metodes se relacionit (brand -> brands) qe mund te mos ekzistoje si rruge.
                        'endpoint' => Str::kebab(Str::plural($relatedShort)),
                        'model' => $relatedShort,
                        'model_snake' => Str::snake($relatedShort),
                    ];
                }
            } catch (Throwable $e) {}
        }
        return $relations;
    }

    private function generateController()
    {
        $path = app_path("Http/Controllers/Api/Mobile/{$this->className}Controller.php");
        File::ensureDirectoryExists(dirname($path));
        $relWith = !empty($this->meta['relations']) ? "->with(" . var_export(collect($this->meta['relations'])->pluck('method')->toArray(), true) . ")" : "";
        $jsonFields = var_export($this->meta['json_fields'], true);
        $searchableFields = var_export(array_values(array_diff($this->meta['fields'], $this->meta['json_fields'])), true);
        $permPrefix = $this->pluralSnake;

        // Fushat qe duken si imazh/foto - keto MOS preken ne update perpos nese vjen file i ri
        $imageFields = array_values(array_filter($this->meta['fields'], function ($f) {
            return preg_match('/^(image|photo|logo|avatar|picture)(_[a-z0-9_]+)?$/i', $f);
        }));
        $imageFieldsExport = var_export($imageFields, true);

        // Logjika per DTO, Actions dhe Query
        $imports = "";
        $storeLogic = "";
        $updateLogic = "";
        $indexLogic = "";

        if ($this->meta['index_query']) {
            $imports .= "use {$this->meta['index_query']};\n";
            $indexLogic = "
    public function index(Request \$request, {$this->className}ListQuery \$listQuery)
    {
        abort_if_cannot('view_{$permPrefix}');
        \$builder = \$listQuery->handle(
            \$request->all(),
            \$request->get('sort_field', 'id'),
            \$request->get('sort_dir', 'asc')
        );
        \$items = \$builder->paginate(\$request->get('per_page', 50));
        \$items->getCollection()->transform(fn(\$i) => \$this->transformItem(\$i));
        return response()->json(\$items);
    }";
        } else {
            $searchableFieldsInline = $searchableFields;
            $indexLogic = "
    public function index(Request \$request)
    {
        abort_if_cannot('view_{$permPrefix}');
        \$searchable = {$searchableFieldsInline};
        \$query = {$this->className}::query(){$relWith};
        if (\$q = \$request->get('q')) {
            \$query->where(function (\$w) use (\$q, \$searchable) {
                foreach (\$searchable as \$field) \$w->orWhere(\$field, 'like', \"%{\$q}%\");
            });
        }
        \$items = \$query->latest()->paginate(50);
        \$items->getCollection()->transform(fn(\$i) => \$this->transformItem(\$i));
        return response()->json(\$items);
    }";
        }

        if ($this->meta['dto_class'] && $this->meta['create_action']) {
            $imports .= "use {$this->meta['dto_class']};\n";
            $imports .= "use {$this->meta['create_action']};\n";
            $storeLogic = "
    public function store(Request \$request, Create{$this->className}Action \$action)
    {
        abort_if_cannot('add_{$permPrefix}');
        \$data = \$this->prepareData(\$request);
        \$dto = {$this->className}DTO::fromArray(\$data);
        \$item = \$action->execute(\$dto);
        return response()->json(['success' => true, 'data' => \$this->transformItem(\$item)]);
    }";
        } else {
            $storeLogic = "
    public function store(Request \$request)
    {
        abort_if_cannot('add_{$permPrefix}');
        \$data = \$this->prepareData(\$request);
        \$rules = method_exists({$this->className}::class, 'rules') ? {$this->className}::rules() : [];
        \$validated = validator(\$data, \$rules ?: ['*'=>'nullable'])->validate();
        \$item = {$this->className}::create(\$validated);
        return response()->json(['success' => true, 'data' => \$this->transformItem(\$item)]);
    }";
        }

        if ($this->meta['dto_class'] && $this->meta['update_action']) {
            if (!str_contains($imports, $this->meta['dto_class'])) $imports .= "use {$this->meta['dto_class']};\n";
            $imports .= "use {$this->meta['update_action']};\n";
            $updateLogic = "
    public function update(Request \$request, \$id, Update{$this->className}Action \$action)
    {
        abort_if_cannot('edit_{$permPrefix}');
        \$item = {$this->className}::findOrFail(\$id);
        \$data = \$this->prepareData(\$request);
        \$dto = {$this->className}DTO::fromArray(\$data);
        \$item = \$action->execute(\$item, \$dto);
        return response()->json(['success' => true, 'data' => \$this->transformItem(\$item)]);
    }";
        } else {
            $updateLogic = "
    public function update(Request \$request, \$id)
    {
        abort_if_cannot('edit_{$permPrefix}');
        \$item = {$this->className}::findOrFail(\$id);
        \$data = \$this->prepareData(\$request);
        \$item->update(\$data);
        return response()->json(['success' => true, 'data' => \$this->transformItem(\$item)]);
    }";
        }

        if ($this->meta['delete_action']) {
            $imports .= "use {$this->meta['delete_action']};\n";
            $destroyLogic = "
    public function destroy(\$id, Delete{$this->className}Action \$action)
    {
        abort_if_cannot('delete_{$permPrefix}');
        try {
            \$item = {$this->className}::findOrFail(\$id);
            \$action->execute(\$item);
            return response()->json(['success' => true]);
        } catch (\Throwable \$e) {
            return response()->json(['success' => false, 'message' => 'Ky rekord është i lidhur me të dhëna të tjera.'], 400);
        }
    }";
        } else {
            $destroyLogic = "
    public function destroy(\$id)
    {
        abort_if_cannot('delete_{$permPrefix}');
        try {
            \$item = {$this->className}::findOrFail(\$id);
            \$item->delete();
            return response()->json(['success' => true]);
        } catch (\Throwable \$e) {
            return response()->json(['success' => false, 'message' => 'Ky rekord është i lidhur me të dhëna të tjera.'], 400);
        }
    }";
        }

        $stub = <<<PHP
<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use {$this->meta['model_fqn']};
use Illuminate\Http\Request;
{$imports}

class {$this->className}Controller extends Controller
{
    {$indexLogic}
    {$storeLogic}
    {$updateLogic}

    {$destroyLogic}

    private function transformItem(\$item) {
        foreach ({$jsonFields} as \$f) {
            \$val = \$item->getRawOriginal(\$f);
            \$item->setAttribute("{\$f}_raw", is_string(\$val) && str_starts_with(\$val, '{') ? json_decode(\$val, true) : \$val);
        }
        return \$item;
    }

    private function prepareData(Request \$request) {
        \$data = \$request->all();
        foreach ({$jsonFields} as \$f) {
            if (isset(\$data[\$f]) && is_string(\$data[\$f]) && str_starts_with(\$data[\$f], '{')) \$data[\$f] = json_decode(\$data[\$f], true);
        }
        // Mos e prek fushen e fotos/imazhit nese s'ka file te ri ne kete kerkese
        foreach ({$imageFieldsExport} as \$f) {
            if (!\$request->hasFile(\$f)) {
                unset(\$data[\$f]);
            }
        }
        return \$data;
    }
}
PHP;
        File::put($path, $stub);
    }

    private function registerRoutes() {
        $path = base_path('routes/api.php');
        $content = File::get($path);
        $route = "    Route::apiResource('{$this->pluralKebab}', \\App\\Http\\Controllers\\Api\\Mobile\\{$this->className}Controller::class);";
        if (!Str::contains($content, "apiResource('{$this->pluralKebab}'")) {
            $marker = "Route::middleware('auth:sanctum')->prefix('mobile')->group(function () {";
            $content = str_replace($marker, $marker . "\n" . $route, $content);
            File::put($path, $content);
        }
    }

    private function generateDartModel() {
        $path = base_path("mobile-gateway/lib/models/{$this->snakeName}.dart");
        File::ensureDirectoryExists(dirname($path));
        $fields = ""; $fromJson = ""; $toJson = "";
        foreach ($this->meta['fields'] as $f) {
            $type = "dynamic";
            if (in_array($f, $this->meta['json_fields'])) $type = "Map<String, dynamic>";
            elseif (Str::endsWith($f, '_id')) $type = "int";
            $camel = Str::camel($f);
            $fields .= "  final $type? $camel;\n";
            $fromJson .= "      $camel: json['" . ($type == "Map<String, dynamic>" ? "{$f}_raw" : $f) . "'],\n";
            $toJson .= "      '$f': $camel,\n";
        }
        $stub = "class {$this->className} {\n  final int? id;\n$fields\n  {$this->className}({this.id, " . collect($this->meta['fields'])->map(fn($f) => "this." . Str::camel($f))->implode(', ') . "});\n\n  factory {$this->className}.fromJson(Map<String, dynamic> json) => {$this->className}(\n      id: json['id'],\n$fromJson  );\n\n  Map<String, dynamic> toJson() => {\n      'id': id,\n$toJson  };\n}";
        File::put($path, $stub);
    }

    private function generateFlutterListPage() {
        $path = base_path("mobile-gateway/lib/modules/dashboard/{$this->snakeName}_list_page.dart");
        $nameLogic = "item['license_plate'] != null && item['license_plate'].toString().isNotEmpty ? item['license_plate'].toString() : (item['name'] is Map ? (item['name']['sq'] ?? item['name']['en'] ?? 'N/A') : (item['name'] ?? item['customer_name'] ?? item['title'] ?? item['type'] ?? 'ID: \${item['id']}'))";
        $imageField = collect($this->meta['fields'])->first(fn($f) => preg_match('/^(image|photo|logo|avatar|picture)(_[a-z0-9_]+)?$/i', $f));
        $imageField = $imageField ?: 'photo';

        $stub = <<<DART
import 'package:flutter/material.dart';
import '../../services/api_service.dart';
import 'dart:convert';
import 'dart:async';
import '{$this->snakeName}_form_screen.dart';

class {$this->className}ListPage extends StatefulWidget {
  const {$this->className}ListPage({super.key});
  @override State<{$this->className}ListPage> createState() => _{$this->className}ListPageState();
}

class _{$this->className}ListPageState extends State<{$this->className}ListPage> {
  final List<dynamic> _items = [];
  final _scrollC = ScrollController();
  final _searchC = TextEditingController();
  Timer? _debounce;
  bool _loading = true; bool _loadingMore = false; bool _hasMore = true;
  int _page = 1; String _query = '';

  @override void initState() {
    super.initState();
    _fetch(reset: true);
    _scrollC.addListener(() {
      if (_scrollC.position.pixels >= _scrollC.position.maxScrollExtent - 200 && !_loadingMore && _hasMore) {
        _fetch();
      }
    });
  }

  @override void dispose() { _scrollC.dispose(); _searchC.dispose(); _debounce?.cancel(); super.dispose(); }

  void _onSearchChanged(String q) {
    if (_debounce?.isActive ?? false) _debounce!.cancel();
    _debounce = Timer(const Duration(milliseconds: 400), () { _query = q; _fetch(reset: true); });
  }

  Future<void> _fetch({bool reset = false}) async {
    if (reset) { setState(() { _loading = true; _page = 1; _hasMore = true; _items.clear(); }); }
    else { setState(() => _loadingMore = true); }

    final qp = _query.isNotEmpty ? '&search=\${Uri.encodeQueryComponent(_query)}' : '';
    final res = await ApiService.get('/{$this->pluralKebab}?page=\$_page\$qp');
    if (res.statusCode == 200) {
      final body = jsonDecode(res.body);
      final data = (body['data'] ?? []) as List<dynamic>;
      final lastPage = body['last_page'] ?? 1;
      setState(() {
        _items.addAll(data);
        _hasMore = _page < lastPage;
        if (_hasMore) _page++;
      });
    }
    setState(() { _loading = false; _loadingMore = false; });
  }

  @override Widget build(BuildContext context) => Scaffold(
    backgroundColor: Colors.white,
    appBar: AppBar(elevation: 0, backgroundColor: Colors.white, title: const Text('{$this->className}', style: TextStyle(color: Colors.black, fontWeight: FontWeight.w900, fontSize: 18)), iconTheme: const IconThemeData(color: Colors.black)),
    floatingActionButton: FloatingActionButton(backgroundColor: Colors.black, mini: true, onPressed: () async { final res = await Navigator.push(context, MaterialPageRoute(builder: (c) => const {$this->className}FormScreen())); if (res == true) _fetch(reset: true); }, child: const Icon(Icons.add, color: Colors.white, size: 20)),
    body: Column(children: [
      Padding(
        padding: const EdgeInsets.fromLTRB(16, 12, 16, 4),
        child: TextField(
          controller: _searchC,
          onChanged: _onSearchChanged,
          style: const TextStyle(fontSize: 13),
          decoration: InputDecoration(hintText: 'Kërko...', prefixIcon: const Icon(Icons.search, size: 18), filled: true, fillColor: Colors.grey[50], contentPadding: const EdgeInsets.symmetric(vertical: 0), border: OutlineInputBorder(borderRadius: BorderRadius.circular(12), borderSide: BorderSide(color: Colors.grey.shade200))),
        ),
      ),
      Expanded(
        child: _loading ? const Center(child: CircularProgressIndicator(color: Colors.black)) : _items.isEmpty
          ? Center(child: Column(mainAxisSize: MainAxisSize.min, children: [
              Icon(Icons.inbox_outlined, size: 40, color: Colors.grey.shade300),
              const SizedBox(height: 8),
              Text('Asnjë rezultat', style: TextStyle(color: Colors.grey.shade500, fontSize: 13)),
            ]))
          : RefreshIndicator(
              onRefresh: () => _fetch(reset: true),
              child: ListView.builder(
                controller: _scrollC,
                padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                itemCount: _items.length + (_hasMore ? 1 : 0),
                itemBuilder: (context, index) {
                  if (index >= _items.length) {
                    return const Padding(padding: EdgeInsets.symmetric(vertical: 16), child: Center(child: SizedBox(width: 20, height: 20, child: CircularProgressIndicator(strokeWidth: 2, color: Colors.black26))));
                  }
                  final item = _items[index];
                  String name = $nameLogic;
                  String? photo = item['{$imageField}'];

                  return Container(
                    margin: const EdgeInsets.only(bottom: 8),
                    decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12), border: Border.all(color: Colors.grey.shade100), boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.01), blurRadius: 4, offset: const Offset(0, 2))]),
                    child: ListTile(
                      contentPadding: const EdgeInsets.symmetric(horizontal: 10, vertical: 0),
                      leading: Container(
                        width: 40, height: 40,
                        decoration: BoxDecoration(color: Colors.grey[50], borderRadius: BorderRadius.circular(10), image: photo != null ? DecorationImage(image: NetworkImage('\${ApiService.serverUrl}/\$photo'), fit: BoxFit.cover) : null),
                        child: photo == null ? Center(child: Text(name.isNotEmpty ? name[0].toUpperCase() : '?', style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 14, color: Colors.black54))) : null,
                      ),
                      title: Text(name, style: const TextStyle(fontWeight: FontWeight.w700, fontSize: 14)),
                      subtitle: Text('ID: \${item['id']}', style: const TextStyle(fontSize: 10, color: Colors.grey)),
                      onTap: () async { final res = await Navigator.push(context, MaterialPageRoute(builder: (c) => {$this->className}FormScreen(item: item))); if (res == true) _fetch(reset: true); },
                    ),
                  );
                },
              ),
            ),
      ),
    ]),
  );
}
DART;
        File::put($path, $stub);
    }

    private function generateFlutterFormPage() {
        $path = base_path("mobile-gateway/lib/modules/dashboard/{$this->snakeName}_form_screen.dart");
        $vars = ""; $init = ""; $widgets = ""; $payload = ""; $loaders = ""; $hasImage = false; $imageFieldName = 'photo'; $quickAddMethods = "";
        $permPrefix = $this->pluralSnake;
        $quickAddImports = [];

        foreach ($this->meta['fields'] as $f) {
            $label = Str::headline($f);
            if (preg_match('/^(image|photo|logo|avatar|picture)(_[a-z0-9_]+)?$/i', $f)) {
                $hasImage = true; $imageFieldName = $f; $vars .= "  String? _imagePath;\n";
                $widgets .= "            _buildSectionTitle('$label'), const SizedBox(height: 4),
            GestureDetector(
              onTap: () async { final p = await ImagePicker().pickImage(source: ImageSource.gallery); if(p != null) setState(()=>_imagePath = p.path); },
              child: Container(height: 160, width: double.infinity, decoration: BoxDecoration(color: Colors.grey[50], borderRadius: BorderRadius.circular(16), border: Border.all(color: Colors.grey.shade200)), child: _imagePath != null ? ClipRRect(borderRadius: BorderRadius.circular(16), child: Image.file(File(_imagePath!), fit: BoxFit.contain)) : (widget.item?['$f'] != null ? ClipRRect(borderRadius: BorderRadius.circular(16), child: Image.network('\${ApiService.serverUrl}/\${widget.item!['$f']}', fit: BoxFit.contain)) : const Icon(Icons.add_a_photo_outlined, color: Colors.grey, size: 30))),
            ), const SizedBox(height: 12),\n";
            } elseif (isset($this->meta['relations'][$f])) {
                $rel = $this->meta['relations'][$f]; $safe = Str::studly($f);
                $relModel = $rel['model']; $relSnake = $rel['model_snake'];
                $quickAddImports[$relSnake] = "import '{$relSnake}_form_screen.dart';";
                $vars .= "  List<dynamic> _{$rel['method']}Options = []; dynamic _selected$safe; String _selected{$safe}Label = 'Zgjidh...';\n";
                $init .= "    _selected$safe = widget.item?['$f'];\n";
                $loaders .= "      final r$safe = await ApiService.get('/{$rel['endpoint']}?per_page=1000'); if(r$safe.statusCode==200) { final list$safe = (jsonDecode(r$safe.body)['data'] ?? jsonDecode(r$safe.body)) as List<dynamic>; setState(() { _{$rel['method']}Options = list$safe; if(_selected$safe != null) { try { var found = list$safe.firstWhere((e) => e['id'].toString() == _selected$safe.toString()); _selected{$safe}Label = _getLabel(found); } catch(_) {} } }); }\n";
                $widgets .= "            _buildSectionTitle('$label'), const SizedBox(height: 4),
            InkWell(
              onTap: () => _showSearchablePicker(context, '$label', _{$rel['method']}Options, (val) {
                setState(() { _selected$safe = val['id']; _selected{$safe}Label = _getLabel(val); });
              }, onQuickAdd: () => _quickAdd$safe()),
              child: Container(padding: const EdgeInsets.all(12), decoration: BoxDecoration(color: Colors.grey[50], borderRadius: BorderRadius.circular(12), border: Border.all(color: Colors.grey.shade200)), child: Row(children: [const Icon(Icons.search, size: 16, color: Colors.grey), const SizedBox(width: 8), Expanded(child: Text(_selected{$safe}Label, style: const TextStyle(fontSize: 13))), const Icon(Icons.arrow_drop_down, size: 18)])),
            ), const SizedBox(height: 12),\n";
                $payload .= "    payload['$f'] = _selected$safe;\n";
                $quickAddMethods .= "
  Future<void> _quickAdd$safe() async {
    final res = await Navigator.push(context, MaterialPageRoute(builder: (c) => const {$relModel}FormScreen()));
    if (res == true) {
      final r = await ApiService.get('/{$rel['endpoint']}?per_page=1000');
      if (r.statusCode == 200) {
        final list = (jsonDecode(r.body)['data'] ?? jsonDecode(r.body)) as List<dynamic>;
        if (list.isNotEmpty) {
          list.sort((a, b) => (int.tryParse(b['id'].toString()) ?? 0).compareTo(int.tryParse(a['id'].toString()) ?? 0));
          final newest = list.first;
          setState(() { _{$rel['method']}Options = list; _selected$safe = newest['id']; _selected{$safe}Label = _getLabel(newest); });
        }
      }
    }
  }
";
            } elseif (Str::contains($f, ['_at', 'date', 'time'])) {
                $vars .= "  final _{$f}C = TextEditingController();\n";
                $init .= "    _{$f}C.text = widget.item?['$f']?.toString() ?? '';\n";
                $widgets .= "            _buildDateTimePicker(_{$f}C, '$label'), const SizedBox(height: 12),\n";
                $payload .= "    payload['$f'] = _{$f}C.text;\n";
            } elseif (in_array($f, $this->meta['json_fields'])) {
                $vars .= "  final _{$f}Sq = TextEditingController(); final _{$f}En = TextEditingController();\n";
                $init .= "    final {$f}D = widget.item?['{$f}_raw']; if({$f}D != null) { _{$f}Sq.text = {$f}D['sq'] ?? ''; _{$f}En.text = {$f}D['en'] ?? ''; }\n";
                $widgets .= "            _buildTextField(_{$f}Sq, '$label (AL)', Icons.language), const SizedBox(height: 8),\n";
                $widgets .= "            _buildTextField(_{$f}En, '$label (EN)', Icons.translate), const SizedBox(height: 12),\n";
                $payload .= "    payload['$f'] = {'sq': _{$f}Sq.text, 'en': _{$f}En.text};\n";
            } else {
                $isNumeric = preg_match('/^(price|cost|amount|total|qty|quantity|year|km|kilometer|kilometra|distance|meter|metra|nr|number)(_[a-z0-9_]+)?$/i', $f);
                $kbType = $isNumeric ? ', keyboardType: TextInputType.number' : '';
                $vars .= "  final _{$f}C = TextEditingController();\n";
                $init .= "    _{$f}C.text = widget.item?['$f']?.toString() ?? '';\n";
                $widgets .= "            _buildTextField(_{$f}C, '$label', Icons.edit_note_outlined{$kbType}), const SizedBox(height: 12),\n";
                $payload .= "    payload['$f'] = _{$f}C.text;\n";
            }
        }

        $saveCall = $hasImage
            ? "await ApiService.postMultipart(widget.item == null ? '/{$this->pluralKebab}' : '/{$this->pluralKebab}/\${widget.item!['id']}', payload, filePath: _imagePath, fieldName: '{$imageFieldName}')"
            : "widget.item == null ? await ApiService.post('/{$this->pluralKebab}', payload) : await ApiService.put('/{$this->pluralKebab}/\${widget.item!['id']}', payload)";

        $quickAddImportsStr = implode("\n", array_values($quickAddImports));
        $moduleLabel = Str::headline($this->className);

        $stub = <<<DART
import 'package:flutter/material.dart';
import '../../services/api_service.dart';
import 'dart:convert';
import 'dart:io';
import 'package:image_picker/image_picker.dart';
import 'package:intl/intl.dart';
{$quickAddImportsStr}

class {$this->className}FormScreen extends StatefulWidget {
  final Map<String, dynamic>? item;
  const {$this->className}FormScreen({super.key, this.item});
  @override State<{$this->className}FormScreen> createState() => _{$this->className}FormState();
}

class _{$this->className}FormState extends State<{$this->className}FormScreen> {
  final _formKey = GlobalKey<FormState>(); bool _isSaving = false; bool _isLoading = true;
  bool _canDelete = false;
$vars
  @override void initState() { super.initState(); _init(); }

  Future<void> _init() async {
    $init
    _canDelete = await ApiService.hasPermission('delete_{$permPrefix}');
    _loadData();
  }

  Future<void> _loadData() async { try { $loaders } catch(_) {} if(mounted) setState(()=>_isLoading=false); }

  // Prioriteti: Targa (license_plate) > name (sq/en) > customer_name > title > type > ID
  String _getLabel(dynamic e) {
    if (e == null) return 'N/A';
    final lp = e['license_plate'];
    if (lp != null && lp.toString().isNotEmpty) return lp.toString();
    final n = e['name'];
    if (n is Map) return (n['sq'] ?? n['en'] ?? 'N/A').toString();
    return (n ?? e['customer_name'] ?? e['title'] ?? e['type'] ?? 'ID: \${e['id']}').toString();
  }
$quickAddMethods
  void _showSearchablePicker(BuildContext context, String title, List<dynamic> options, Function(dynamic) onSelect, {VoidCallback? onQuickAdd}) {
    showModalBottomSheet(context: context, isScrollControlled: true, shape: const RoundedRectangleBorder(borderRadius: BorderRadius.vertical(top: Radius.circular(20))), builder: (context) {
        List<dynamic> filtered = List.from(options);
        return StatefulBuilder(builder: (context, setModalState) {
          return Container(height: MediaQuery.of(context).size.height * 0.6, padding: const EdgeInsets.all(20), child: Column(children: [
              Row(children: [
                Expanded(child: Text('Zgjidh \$title', style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold))),
                if (onQuickAdd != null) TextButton.icon(
                  onPressed: () { Navigator.pop(context); onQuickAdd(); },
                  icon: const Icon(Icons.add_circle_outline, size: 16),
                  label: const Text('Shto të ri', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w700)),
                ),
              ]),
              const SizedBox(height: 8),
              TextField(decoration: InputDecoration(hintText: 'Kërko...', prefixIcon: const Icon(Icons.search, size: 18), filled: true, fillColor: Colors.grey[100], contentPadding: EdgeInsets.zero, border: OutlineInputBorder(borderRadius: BorderRadius.circular(12), borderSide: BorderSide.none)),
              onChanged: (q) { setModalState(() { filtered = options.where((e) => _getLabel(e).toLowerCase().contains(q.toLowerCase())).toList(); }); }),
              const SizedBox(height: 12),
              Expanded(child: ListView.builder(itemCount: filtered.length, itemBuilder: (c, i) {
                  var e = filtered[i];
                  return ListTile(title: Text(_getLabel(e), style: const TextStyle(fontSize: 13)), dense: true, leading: const Icon(Icons.check_circle_outline, size: 18), onTap: () { onSelect(e); Navigator.pop(context); });
              }))
          ]));
        });
    });
  }

  Widget _buildDateTimePicker(TextEditingController controller, String label) {
    return Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
      _buildSectionTitle(label), const SizedBox(height: 4),
      InkWell(onTap: () async {
          DateTime? pDate = await showDatePicker(context: context, initialDate: DateTime.now(), firstDate: DateTime(2000), lastDate: DateTime(2100));
          if (pDate != null) {
            TimeOfDay? pTime = await showTimePicker(context: context, initialTime: TimeOfDay.now());
            if (pTime != null) {
              final dt = DateTime(pDate.year, pDate.month, pDate.day, pTime.hour, pTime.minute);
              setState(() => controller.text = dt.toIso8601String());
            }
          }
        },
        child: Container(padding: const EdgeInsets.all(12), decoration: BoxDecoration(color: Colors.grey[50], borderRadius: BorderRadius.circular(12), border: Border.all(color: Colors.grey.shade200)), child: Row(children: [const Icon(Icons.calendar_month_outlined, size: 16, color: Colors.black54), const SizedBox(width: 8), Expanded(child: Text(controller.text.isEmpty ? 'Zgjidh...' : DateFormat('dd/MM/yyyy HH:mm').format(DateTime.parse(controller.text)), style: const TextStyle(fontSize: 13))), const Icon(Icons.edit_calendar_outlined, size: 16, color: Colors.grey)])),
      )
    ]);
  }

  Widget _buildTextField(TextEditingController controller, String label, IconData icon, {TextInputType? keyboardType}) {
    return Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
      _buildSectionTitle(label), const SizedBox(height: 4),
      TextFormField(controller: controller, keyboardType: keyboardType, style: const TextStyle(fontSize: 13), decoration: InputDecoration(prefixIcon: Icon(icon, size: 16, color: Colors.black54), filled: true, fillColor: Colors.grey[50], border: OutlineInputBorder(borderRadius: BorderRadius.circular(12), borderSide: BorderSide.none), enabledBorder: OutlineInputBorder(borderRadius: BorderRadius.circular(12), borderSide: BorderSide(color: Colors.grey.shade200)), contentPadding: const EdgeInsets.symmetric(horizontal: 12, vertical: 12))),
    ]);
  }

  Widget _buildSectionTitle(String title) { return Text(title, style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Colors.black54)); }

  Future<void> _delete() async {
    final confirm = await showDialog<bool>(context: context, builder: (c) => AlertDialog(title: const Text('Fshi?'), content: const Text('A jeni të sigurt?'), actions: [TextButton(onPressed: () => Navigator.pop(c, false), child: const Text('JO')), TextButton(onPressed: () => Navigator.pop(c, true), child: const Text('PO', style: TextStyle(color: Colors.red)))]));
    if (confirm == true) {
      setState(() => _isSaving = true);
      try {
        final res = await ApiService.delete('/{$this->pluralKebab}/\${widget.item!['id']}');
        if (res.statusCode == 200) { ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('U fshi! ✅'), backgroundColor: Colors.green)); Navigator.pop(context, true); }
        else { ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(ApiService.extractErrorMessage(res)), backgroundColor: Colors.red)); }
      } catch (e) { ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text('Gabim: \$e'))); }
      setState(() => _isSaving = false);
    }
  }

  Future<void> _save() async {
    if (!_formKey.currentState!.validate()) return;
    setState(() => _isSaving = true);
    final payload = <String, dynamic>{}; $payload
    try {
      final res = $saveCall;
      if (res.statusCode >= 200 && res.statusCode < 300) { ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('U ruajt! ✅'), backgroundColor: Colors.green)); Navigator.pop(context, true); }
      else { ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(ApiService.extractErrorMessage(res)))); }
    } catch (e) { ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text('Error: \$e'))); }
    setState(() => _isSaving = false);
  }

  @override Widget build(BuildContext context) => Scaffold(
    backgroundColor: Colors.white,
    appBar: AppBar(elevation: 0, backgroundColor: Colors.white, title: Text(widget.item == null ? 'Shto {$moduleLabel}' : 'Edito {$moduleLabel}', style: const TextStyle(color: Colors.black, fontWeight: FontWeight.w900, fontSize: 16)), iconTheme: const IconThemeData(color: Colors.black)),
    body: _isLoading ? const Center(child: CircularProgressIndicator(color: Colors.black)) : SingleChildScrollView(padding: const EdgeInsets.all(20), child: Form(key: _formKey, child: Column(children: [ $widgets const SizedBox(height: 20),
            Row(children: [
              Expanded(flex: 10, child: SizedBox(height: 48, child: ElevatedButton(style: ElevatedButton.styleFrom(backgroundColor: Colors.black, foregroundColor: Colors.white, elevation: 0, shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12))), onPressed: _isSaving ? null : _save, child: _isSaving ? const SizedBox(width: 20, height: 20, child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2)) : Row(mainAxisAlignment: MainAxisAlignment.center, children: [Icon(Icons.save_outlined, size: 18), SizedBox(width: 8), Text('RUAJ', style: TextStyle(fontWeight: FontWeight.w900, fontSize: 14))])))),
              if(widget.item != null && _canDelete) ...[
                const SizedBox(width: 10),
                Expanded(flex: 2, child: SizedBox(height: 48, child: ElevatedButton(style: ElevatedButton.styleFrom(backgroundColor: Colors.red.withOpacity(0.1), foregroundColor: Colors.red, elevation: 0, padding: EdgeInsets.zero, shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12))), onPressed: _isSaving ? null : _delete, child: const Icon(Icons.delete_outline, size: 24)))),
              ]
            ]),
      ]))),
  );
}
DART;
        File::put($path, $stub);
    }
}