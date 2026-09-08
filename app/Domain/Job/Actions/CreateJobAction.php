<?php

namespace App\Domain\Job\Actions;

use App\Models\Job;
use App\Models\JobService;
use App\Models\JobMaterial;
use App\Models\JobPart;
use App\Models\Material;
use App\Models\Part;
use App\Domain\Job\DTOs\JobDTO;
use App\Models\AuditTrail;
use Illuminate\Support\Facades\DB;

class CreateJobAction
{
    public function execute(JobDTO $dto): Job
    {
        return DB::transaction(function () use ($dto) {
            $item = Job::create($dto->toArray());

            // If we have single service_id from mobile
            if ($dto->service_id) {
                JobService::create([
                    'job_id' => $item->id,
                    'service_id' => $dto->service_id,
                    'price' => $dto->final_price,
                ]);
            }

            foreach ($dto->services as $s) {
                JobService::create([
                    'job_id' => $item->id,
                    'service_id' => $s['id'],
                    'price' => $s['sell_price'] ?? 0,
                ]);
            }

            foreach ($dto->materials as $m) {
                JobMaterial::create([
                    'job_id' => $item->id,
                    'material_id' => $m['id'],
                    'quantity' => $m['quantity'],
                    'cost_price' => $m['cost_price'] ?? 0,
                    'sell_price' => $m['sell_price'] ?? 0,
                ]);
                Material::where('id', $m['id'])->decrement('stock_meters', $m['quantity']);
            }

            foreach ($dto->parts as $p) {
                JobPart::create([
                    'job_id' => $item->id,
                    'part_id' => $p['id'],
                    'quantity' => $p['quantity'],
                    'cost_price' => $p['cost_price'] ?? 0,
                    'sell_price' => $p['sell_price'] ?? 0,
                ]);
                Part::where('id', $p['id'])->decrement('stock_quantity', $p['quantity']);
            }

            AuditTrail::log($item, 'create', 'Jobs');
            return $item;
        });
    }
}
