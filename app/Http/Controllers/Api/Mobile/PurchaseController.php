<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Domain\Purchase\Queries\PurchaseListQuery;
use App\Domain\Purchase\DTOs\PurchaseDTO;
use App\Domain\Purchase\Actions\CreatePurchaseAction;
use App\Domain\Purchase\Actions\UpdatePurchaseAction;
use App\Domain\Purchase\Actions\DeletePurchaseAction;


class PurchaseController extends Controller
{
    
    public function index(Request $request, PurchaseListQuery $listQuery)
    {
        abort_if_cannot('view_purchases');
        $builder = $listQuery->handle(
            $request->all(),
            $request->get('sort_field', 'id'),
            $request->get('sort_dir', 'asc')
        );
        $items = $builder->paginate($request->get('per_page', 50));
        $items->getCollection()->transform(fn($i) => $this->transformItem($i));
        return response()->json($items);
    }
    
    public function store(Request $request, CreatePurchaseAction $action)
    {
        abort_if_cannot('add_purchases');
        $data = $this->prepareData($request);
        $dto = PurchaseDTO::fromArray($data);
        $item = $action->execute($dto);
        return response()->json(['success' => true, 'data' => $this->transformItem($item)]);
    }
    
    public function update(Request $request, $id, UpdatePurchaseAction $action)
    {
        abort_if_cannot('edit_purchases');
        $item = Purchase::findOrFail($id);
        $data = $this->prepareData($request);
        $dto = PurchaseDTO::fromArray($data);
        $item = $action->execute($item, $dto);
        return response()->json(['success' => true, 'data' => $this->transformItem($item)]);
    }

    
    public function destroy($id, DeletePurchaseAction $action)
    {
        abort_if_cannot('delete_purchases');
        try {
            $item = Purchase::findOrFail($id);
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
) as $f) {
            if (!$request->hasFile($f)) {
                unset($data[$f]);
            }
        }
        return $data;
    }
}