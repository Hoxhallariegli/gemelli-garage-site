<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Domain\Purchase\DTOs\PurchaseDTO;
use App\Domain\Purchase\Actions\CreatePurchaseAction;
use App\Domain\Purchase\Actions\UpdatePurchaseAction;


class PurchaseController extends Controller
{
    public function index() { abort_if_cannot('view_purchases'); $items = Purchase::query()->with(array (
  0 => 'supplier',
))->latest()->paginate(50); $items->getCollection()->transform(fn($i) => $this->transformItem($i)); return response()->json($items); }
        public function store(Request $request, CreatePurchaseAction $action) { abort_if_cannot('add_purchases'); $data = $this->prepareData($request); $dto = PurchaseDTO::fromArray($data); $item = $action->execute($dto); return response()->json(['success' => true, 'data' => $this->transformItem($item)]); }
        public function update(Request $request, $id, UpdatePurchaseAction $action) { abort_if_cannot('edit_purchases'); $item = Purchase::findOrFail($id); $data = $this->prepareData($request); $dto = PurchaseDTO::fromArray($data); $item = $action->execute($item, $dto); return response()->json(['success' => true, 'data' => $this->transformItem($item)]); }
    public function destroy($id) { abort_if_cannot('delete_purchases'); try { $item = Purchase::findOrFail($id); $item->delete(); return response()->json(['success' => true]); } catch (\Throwable $e) { return response()->json(['success' => false, 'message' => 'Ky rekord është i lidhur me të dhëna të tjera.'], 400); } }
    private function transformItem($item) { foreach (array (
) as $f) { $val = $item->getRawOriginal($f); $item->setAttribute("{$f}_raw", is_string($val) && str_starts_with($val, '{') ? json_decode($val, true) : $val); } return $item; }
    private function prepareData(Request $request) { $data = $request->all(); foreach (array (
) as $f) { if (isset($data[$f]) && is_string($data[$f]) && str_starts_with($data[$f], '{')) $data[$f] = json_decode($data[$f], true); } return $data; }
}