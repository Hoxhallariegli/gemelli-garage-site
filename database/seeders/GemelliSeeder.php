<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\Service;
use App\Models\Material;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GemelliSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'email' => 'admin@gemelli.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $brands = [
            ['name' => 'BMW'],
            ['name' => 'Mercedes-Benz'],
            ['name' => 'Audi'],
            ['name' => 'Porsche'],
        ];

        foreach ($brands as $brand) {
            $b = VehicleBrand::create($brand);

            VehicleModel::create(['brand_id' => $b->id, 'name' => 'Series 3', 'body_type' => 'Sedan', 'wrap_meters_needed' => 15]);
            VehicleModel::create(['brand_id' => $b->id, 'name' => 'Series 5', 'body_type' => 'Sedan', 'wrap_meters_needed' => 18]);
            VehicleModel::create(['brand_id' => $b->id, 'name' => 'X5', 'body_type' => 'SUV', 'wrap_meters_needed' => 22]);
        }

        Service::create(['name' => 'Oscuramento Vetri', 'base_price' => 100, 'active' => true]);
        Service::create(['name' => 'Lucidatura Auto', 'base_price' => 150, 'active' => true]);
        Service::create(['name' => 'Wrapping Totale', 'base_price' => 500, 'active' => true]);

        Material::create(['name' => 'Satin Black', 'brand' => '3M', 'purchase_price' => 15, 'sell_price' => 25, 'stock_meters' => 100]);
        Material::create(['name' => 'Gloss White', 'brand' => 'Avery', 'purchase_price' => 12, 'sell_price' => 20, 'stock_meters' => 100]);

        Client::create(['name' => 'Filan Fisteku', 'phone' => '0691234567', 'email' => 'filan@example.com']);
    }
}
