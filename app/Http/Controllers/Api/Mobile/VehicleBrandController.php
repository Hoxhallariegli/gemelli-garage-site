<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\VehicleBrand;
use Illuminate\Http\Request;

class VehicleBrandController extends Controller
{
    public function index()
    {
        abort_if_cannot('view_vehicle_brands');
        return response()->json(VehicleBrand::orderBy('name')->paginate(100));
    }

    public function store(Request $request)
    {
        abort_if_cannot('add_vehicle_brands');
        $data = $request->all();

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $name);
            $data['logo'] = 'uploads/' . $name;
        }

        $item = VehicleBrand::create($data);
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function update(Request $request, $id)
    {
        abort_if_cannot('edit_vehicle_brands');
        $item = VehicleBrand::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($item->logo && file_exists(public_path($item->logo))) @unlink(public_path($item->logo));
            $file = $request->file('logo');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $name);
            $data['logo'] = 'uploads/' . $name;
        } else {
            // Mos e prek logon nese nuk vjen file i ri
            unset($data['logo']);
        }

        $item->update($data);
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function destroy($id)
    {
        abort_if_cannot('delete_vehicle_brands');
        $item = VehicleBrand::findOrFail($id);
        if ($item->logo && file_exists(public_path($item->logo))) @unlink(public_path($item->logo));
        $item->delete();
        return response()->json(['success' => true]);
    }
}
