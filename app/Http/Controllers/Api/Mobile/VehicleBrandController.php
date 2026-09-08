<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\VehicleBrand;
use Illuminate\Http\Request;
use App\Domain\VehicleBrand\Queries\VehicleBrandListQuery;
use App\Domain\VehicleBrand\DTOs\VehicleBrandDTO;
use App\Domain\VehicleBrand\Actions\CreateVehicleBrandAction;
use App\Domain\VehicleBrand\Actions\UpdateVehicleBrandAction;
use App\Domain\VehicleBrand\Actions\DeleteVehicleBrandAction;


class VehicleBrandController extends Controller
{
    
    public function index(Request $request, VehicleBrandListQuery $listQuery)
    {
        abort_if_cannot('view_vehicle_brands');
        $builder = $listQuery->handle(
            $request->all(),
            $request->get('sort_field', 'id'),
            $request->get('sort_dir', 'asc')
        );
        $items = $builder->paginate($request->get('per_page', 50));
        $items->getCollection()->transform(fn($i) => $this->transformItem($i));
        return response()->json($items);
    }
    
    public function store(Request $request, CreateVehicleBrandAction $action)
    {
        abort_if_cannot('add_vehicle_brands');
        $data = $this->prepareData($request);
        $dto = VehicleBrandDTO::fromArray($data);
        $item = $action->execute($dto);
        return response()->json(['success' => true, 'data' => $this->transformItem($item)]);
    }
    
    public function update(Request $request, $id, UpdateVehicleBrandAction $action)
    {
        abort_if_cannot('edit_vehicle_brands');
        $item = VehicleBrand::findOrFail($id);
        $data = $this->prepareData($request);
        $dto = VehicleBrandDTO::fromArray($data);
        $item = $action->execute($item, $dto);
        return response()->json(['success' => true, 'data' => $this->transformItem($item)]);
    }

    
    public function destroy($id, DeleteVehicleBrandAction $action)
    {
        abort_if_cannot('delete_vehicle_brands');
        try {
            $item = VehicleBrand::findOrFail($id);
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
  0 => 'logo',
) as $f) {
            if (!$request->hasFile($f)) {
                unset($data[$f]);
            }
        }
        return $data;
    }
}