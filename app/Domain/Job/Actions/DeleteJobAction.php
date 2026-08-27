<?php

namespace App\Domain\Job\Actions;

use App\Models\Job;
use App\Models\AuditTrail;
use Illuminate\Support\Facades\DB;

class DeleteJobAction
{
    public function execute(Job $model): bool
    {
        return DB::transaction(function () use ($model) {
            // Restore Inventory for Materials
            foreach ($model->materials as $jobMaterial) {
                if ($jobMaterial->material) {
                    $jobMaterial->material->increment('stock_meters', $jobMaterial->quantity);
                }
            }

            // Restore Inventory for Parts
            foreach ($model->parts as $jobPart) {
                if ($jobPart->part) {
                    $jobPart->part->increment('stock_quantity', $jobPart->quantity);
                }
            }

            AuditTrail::log($model, 'delete', 'Jobs');

            // Delete related records manually if not using cascade on delete in DB
            $model->services()->delete();
            $model->materials()->delete();
            $model->parts()->delete();
            $model->payments()->delete();

            return $model->delete();
        });
    }
}
