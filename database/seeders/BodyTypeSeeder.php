<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BodyType;
use Illuminate\Support\Facades\DB;

class BodyTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['id' => 1, 'name' => 'Sedan', 'wrap_meters' => 15, 'image' => 'body_types/sedan_reference.webp'],
            ['id' => 2, 'name' => 'SUV / Crossover', 'wrap_meters' => 20, 'image' => 'body_types/small_suv.webp'],
            ['id' => 3, 'name' => 'Hatchback', 'wrap_meters' => 13, 'image' => 'body_types/hatchback.webp'],
            ['id' => 4, 'name' => 'Coupe / Sports Car', 'wrap_meters' => 14, 'image' => 'body_types/coupe.webp'],
            ['id' => 5, 'name' => 'Convertible (Cabrio)', 'wrap_meters' => 13, 'image' => 'body_types/convertible.webp'],
            ['id' => 6, 'name' => 'Station Wagon', 'wrap_meters' => 17, 'image' => 'body_types/large_suv_sedan.webp'],
            ['id' => 7, 'name' => 'Pickup Truck', 'wrap_meters' => 20, 'image' => 'body_types/pickup_truck.webp'],
            ['id' => 8, 'name' => 'MPV / Minivan', 'wrap_meters' => 22, 'image' => 'body_types/mpv.webp'],
            ['id' => 9, 'name' => 'Microcar / City Car', 'wrap_meters' => 10, 'image' => 'body_types/micro.webp'],
            ['id' => 10, 'name' => 'Small Van', 'wrap_meters' => 22, 'image' => 'body_types/small_van.webp'],
            ['id' => 11, 'name' => 'Large Van', 'wrap_meters' => 25, 'image' => 'body_types/large_van.webp'],
            ['id' => 12, 'name' => 'Truck / Commercial', 'wrap_meters' => 30, 'image' => 'body_types/truck_cab.webp'],
        ];

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::table('body_types')->where('id', '>', 12)->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } catch (\Throwable $e) {}

        foreach ($types as $t) {
            BodyType::updateOrCreate(
                ['id' => $t['id']],
                [
                    'name' => $t['name'],
                    'wrap_meters' => $t['wrap_meters'],
                    'image' => $t['image'],
                    'tenant_id' => null,
                ]
            );
        }
    }
}
