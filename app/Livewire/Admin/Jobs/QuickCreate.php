<?php

namespace App\Livewire\Admin\Jobs;

use App\Models\Job;
use App\Domain\Job\DTOs\JobDTO;
use App\Domain\Job\Actions\CreateJobAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

class QuickCreate extends Component
{
        use WithPagination;
     public $car_id = '';
    public $service_id = '';
    public $material_id = '';
    public $meters_used = '';
    public $final_price = '';
    public $status = '';
    public $job_date = '';
    public $notes = '';

    #[On('car-created')]
    public function refreshCars($id) { $this->car_id = $id; $this->updatedCarId($id); }

    #[On('service-created')]
    public function refreshServices($id) { $this->service_id = $id; $this->updatedServiceId($id); }

    #[On('material-created')]
    public function refreshMaterials($id) { $this->material_id = $id; $this->updatedMaterialId($id); }

    public function updatedCarId($value)
    {
        if (!$value) return;
        $related = \App\Models\Car::with('model.bodyType')->find($value);
        if (!$related) return;

        if ($this->material_id) {
            $this->meters_used = (string)($related->model?->wrap_meters_needed ?? ($related->model?->bodyType?->wrap_meters ?? 1));
        }

        if (isset($related->service_id)) { $this->service_id = $related->service_id; }
        if (isset($related->material_id)) { $this->material_id = $related->material_id; }
    }

    public function updatedServiceId($value)
    {
        if (!$value) return;
        $related = \App\Models\Service::find($value);
        if (!$related) return;
        if (isset($related->car_id)) { $this->car_id = $related->car_id; }
        if (isset($related->material_id)) { $this->material_id = $related->material_id; }
    }

    public function updatedMaterialId($value)
    {
        if (!$value) return;
        $related = \App\Models\Material::find($value);
        if (!$related) return;

        if ($this->car_id) {
            $car = \App\Models\Car::with('model.bodyType')->find($this->car_id);
            if ($car) {
                $this->meters_used = (string)($car->model?->wrap_meters_needed ?? ($car->model?->bodyType?->wrap_meters ?? 1));
            }
        }

        if (isset($related->car_id)) { $this->car_id = $related->car_id; }
        if (isset($related->service_id)) { $this->service_id = $related->service_id; }
    }

    protected function getcarsList() {
        return \App\Models\Car::pluck('license_plate', 'id')->toArray();
    }

    protected function getservicesList() {
        return \App\Models\Service::pluck('name', 'id')->toArray();
    }

    protected function getmaterialsList() {
        return \App\Models\Material::pluck('name', 'id')->toArray();
    }

    public bool $created = false;
    public ?int $createdId = null;
    public string $createdLabel = '';

    public function render() { return view('livewire.admin.jobs.quick-create', [
            'cars' => $this->getcarsList(),
            'services' => $this->getservicesList(),
            'materials' => $this->getmaterialsList(),
        ]); }

    public function store(CreateJobAction $action)
    {
        $this->validate();
        $dto = JobDTO::fromArray([
            'car_id' => $this->car_id,
            'service_id' => $this->service_id,
            'material_id' => $this->material_id,
            'meters_used' => $this->meters_used,
            'final_price' => $this->final_price,
            'status' => $this->status,
            'job_date' => $this->job_date,
            'notes' => $this->notes,
        ]);
        $item = $action->execute($dto);
        $this->dispatch('job-created', id: $item->id);
        $this->js("Livewire.dispatch('job-created', { id: {$item->id} })");
        $this->dispatch('toast', message: __('jobs.created'), type: 'success');
        $this->created = true;
        $this->createdId = $item->id;
        $this->createdLabel = (string) ($item->id ?? $item->id);
        $this->reset(['car_id', 'service_id', 'material_id', 'meters_used', 'final_price', 'status', 'job_date', 'notes']);
    }

    public function addAnother()
    {
        $this->created = false;
        $this->createdId = null;
        $this->createdLabel = '';
    }

    protected function rules(): array { return Job::rules(); }
}
