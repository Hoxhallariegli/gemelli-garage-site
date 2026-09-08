<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\VehicleModel;
use Illuminate\Http\Request;

class VehicleModelController extends Controller
{
    public function index()
    {
        abort_if_cannot('view_vehicle_models');
        $items = VehicleModel::with(['brand', 'bodyType'])->orderBy('name')->paginate(50);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        abort_if_cannot('add_vehicle_models');
        $data = $request->validate([
            'brand_id' => 'required|integer',
            'body_type_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'wrap_meters_needed' => 'nullable|numeric',
        ]);

        $item = VehicleModel::create($data);
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function update(Request $request, $id)
    {
        abort_if_cannot('edit_vehicle_models');
        $item = VehicleModel::findOrFail($id);
        $data = $request->validate([
            'brand_id' => 'required|integer',
            'body_type_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'wrap_meters_needed' => 'nullable|numeric',
        ]);

        $item->update($data);
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function destroy($id)
    {
        abort_if_cannot('delete_vehicle_models');
        try {
            $item = VehicleModel::findOrFail($id);
            $item->delete();
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Ky rekord është i lidhur me të dhëna të tjera.'], 400);
        }
    }
}
