<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Part;
use Illuminate\Http\Request;
use App\Domain\Part\Queries\PartListQuery;
use App\Domain\Part\DTOs\PartDTO;
use App\Domain\Part\Actions\CreatePartAction;
use App\Domain\Part\Actions\UpdatePartAction;
use App\Domain\Part\Actions\DeletePartAction;


class PartController extends Controller
{
    
    public function index(Request $request, PartListQuery $query)
    {
        abort_if_cannot('view_parts');
        $items = $query->execute($request);
        $items->getCollection()->transform(fn($i) => $this->transformItem($i));
        return response()->json($items);
    }
    
    public function store(Request $request, CreatePartAction $action)
    {
        abort_if_cannot('add_parts');
        $data = $this->prepareData($request);
        $dto = PartDTO::fromArray($data);
        $item = $action->execute($dto);
        return response()->json(['success' => true, 'data' => $this->transformItem($item)]);
    }
    
    public function update(Request $request, $id, UpdatePartAction $action)
    {
        abort_if_cannot('edit_parts');
        $item = Part::findOrFail($id);
        $data = $this->prepareData($request);
        $dto = PartDTO::fromArray($data);
        $item = $action->execute($item, $dto);
        return response()->json(['success' => true, 'data' => $this->transformItem($item)]);
    }

    
    public function destroy($id, DeletePartAction $action)
    {
        abort_if_cannot('delete_parts');
        try {
            $item = Part::findOrFail($id);
            $action->execute($item);
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Ky rekord është i lidhur me të dhëna të tjera.'], 400);
        }
    }

    private function transformItem($item) {
        foreach (array (
) as $f) {
            $val = $item->getRawOriginal($f);
            $item->setAttribute("{$f}_raw", is_string($val) && str_starts_with($val, '{') ? json_decode($val, true) : $val);
        }
        return $item;
    }

    private function prepareData(Request $request) {
        $data = $request->all();
        foreach (array (
) as $f) {
            if (isset($data[$f]) && is_string($data[$f]) && str_starts_with($data[$f], '{')) $data[$f] = json_decode($data[$f], true);
        }
        // Mos e prek fushen e fotos/imazhit nese s'ka file te ri ne kete kerkese
        foreach (array (
  0 => 'image',
) as $f) {
            if (!$request->hasFile($f)) {
                unset($data[$f]);
            }
        }
        return $data;
    }
}