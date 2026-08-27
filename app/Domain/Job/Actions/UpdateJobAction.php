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

class UpdateJobAction
{
    public function execute(Job $model, JobDTO $dto): Job
    {
        return DB::transaction(function () use ($model, $dto) {
            // Restore old stock
            foreach($model->materials as $oldM) {
                Material::where('id', $oldM->material_id)->increment('stock_meters', $oldM->quantity);
            }
            foreach($model->parts as $oldP) {
                Part::where('id', $oldP->part_id)->increment('stock_quantity', $oldP->quantity);
            }

            $model->services()->delete();
            $model->materials()->delete();
            $model->parts()->delete();

            $model->fill($dto->toArray());
            $model->save();

            foreach ($dto->services as $s) {
                JobService::create([
                    'job_id' => $model->id,
                    'service_id' => $s['id'],
                    'price' => $s['sell_price'],
                ]);
            }

            foreach ($dto->materials as $m) {
                JobMaterial::create([
                    'job_id' => $model->id,
                    'material_id' => $m['id'],
                    'quantity' => $m['quantity'],
                    'cost_price' => $m['cost_price'],
                    'sell_price' => $m['sell_price'],
                ]);
                Material::where('id', $m['id'])->decrement('stock_meters', $m['quantity']);
            }

            foreach ($dto->parts as $p) {
                JobPart::create([
                    'job_id' => $model->id,
                    'part_id' => $p['id'],
                    'quantity' => $p['quantity'],
                    'cost_price' => $p['cost_price'],
                    'sell_price' => $p['sell_price'],
                ]);
                Part::where('id', $p['id'])->decrement('stock_quantity', $p['quantity']);
            }

            AuditTrail::log($model, 'update', 'Jobs');
            return $model->fresh();
        });
    }
}
