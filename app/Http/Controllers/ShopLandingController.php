<?php

namespace App\Http\Controllers;

use App\Models\Garage;
use App\Models\Service;
use App\Models\Material;
use Illuminate\Http\Request;

class ShopLandingController extends Controller
{
    public function show(string $slug)
    {
        $garage = Garage::where('slug', $slug)->first();

        if (!$garage) {
            abort(404, 'Garazhi nuk u gjet.');
        }

        $services = Service::withoutGlobalScope('garage_access')
            ->where(function($q) use ($garage) {
                $q->where('tenant_id', $garage->id)
                  ->orWhereNull('tenant_id')
                  ->orWhere('tenant_id', 0);
            })
            ->where('active', true)
            ->get();

        $materials = Material::withoutGlobalScope('garage_access')
            ->where(function($q) use ($garage) {
                $q->where('tenant_id', $garage->id)
                  ->orWhereNull('tenant_id')
                  ->orWhere('tenant_id', 0);
            })
            ->get();

        return view('shop-landing', [
            'garage' => $garage,
            'services' => $services,
            'materials' => $materials,
        ]);
    }
}
