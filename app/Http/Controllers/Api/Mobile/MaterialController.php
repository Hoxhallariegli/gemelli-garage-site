<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        abort_if_cannot('view_materials');
        return response()->json(Material::with('materialBrand')->latest()->paginate(50));
    }

    public function store(Request $request)
    {
        abort_if_cannot('add_materials');
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'material_brand_id' => 'required|integer',
            'purchase_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'stock_meters' => 'required|numeric',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $name);
            $data['image'] = 'uploads/' . $name;
        }

        $item = Material::create($data);
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function update(Request $request, $id)
    {
        abort_if_cannot('edit_materials');
        $item = Material::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'material_brand_id' => 'required|integer',
            'purchase_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'stock_meters' => 'required|numeric',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($item->image && file_exists(public_path($item->image))) @unlink(public_path($item->image));
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $name);
            $data['image'] = 'uploads/' . $name;
        } else {
            unset($data['image']); // FIX: Mba imazhin e vjeter
        }

        $item->update($data);
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function destroy($id)
    {
        abort_if_cannot('delete_materials');
        $item = Material::findOrFail($id);
        if ($item->image && file_exists(public_path($item->image))) @unlink(public_path($item->image));
        $item->delete();
        return response()->json(['success' => true]);
    }
}
