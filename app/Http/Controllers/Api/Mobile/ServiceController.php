<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        abort_if_cannot('view_services');
        $items = Service::latest()->paginate(50);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        abort_if_cannot('add_services');
        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $name);
            $data['image'] = 'uploads/' . $name;
        }

        $item = Service::create($data);
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function update(Request $request, $id)
    {
        abort_if_cannot('edit_services');
        $item = Service::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($item->image && file_exists(public_path($item->image))) @unlink(public_path($item->image));
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $name);
            $data['image'] = 'uploads/' . $name;
        } else {
            // Mos e prek imazhin nese nuk vjen file i ri
            unset($data['image']);
        }

        $item->update($data);
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function destroy($id)
    {
        abort_if_cannot('delete_services');
        $item = Service::findOrFail($id);
        if ($item->image && file_exists(public_path($item->image))) @unlink(public_path($item->image));
        $item->delete();
        return response()->json(['success' => true]);
    }
}
