<?php

namespace App\Livewire\Admin\JobRequests;

use App\Models\JobRequest;
use App\Domain\JobRequest\DTOs\JobRequestDTO;
use App\Domain\JobRequest\Actions\CreateJobRequestAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('Add JobRequest')]
class Create extends Component
{
        use WithPagination;
     public $name = '';
    public $email = '';
    public $phone = '';
    public $brand = '';
    public $model = '';
    public $body_type_id = '';
    public $service_id = '';
    public $material_id = '';
    public $estimated_price = '';
    public $message = '';
    public $status = '';
 
    #[On('body-type-created')] 
    public function refreshBodyTypes($id) { $this->body_type_id = $id; $this->updatedBodyTypeId($id); }

    #[On('service-created')] 
    public function refreshServices($id) { $this->service_id = $id; $this->updatedServiceId($id); }

    #[On('material-created')] 
    public function refreshMaterials($id) { $this->material_id = $id; $this->updatedMaterialId($id); }
 
    public function updatedBodyTypeId($value)
    {
        if (!$value) return;
        $related = \App\Models\BodyType::find($value);
        if (!$related) return;
        if (isset($related->service_id)) { $this->service_id = $related->service_id; }
        if (isset($related->material_id)) { $this->material_id = $related->material_id; }
    }

    public function updatedServiceId($value)
    {
        if (!$value) return;
        $related = \App\Models\Service::find($value);
        if (!$related) return;
        if (isset($related->body_type_id)) { $this->body_type_id = $related->body_type_id; }
        if (isset($related->material_id)) { $this->material_id = $related->material_id; }
    }

    public function updatedMaterialId($value)
    {
        if (!$value) return;
        $related = \App\Models\Material::find($value);
        if (!$related) return;
        if (isset($related->body_type_id)) { $this->body_type_id = $related->body_type_id; }
        if (isset($related->service_id)) { $this->service_id = $related->service_id; }
    }
 
    protected function getbodyTypesList() {
        return \App\Models\BodyType::pluck('name', 'id')->toArray();
    }

    protected function getservicesList() {
        return \App\Models\Service::pluck('name', 'id')->toArray();
    }

    protected function getmaterialsList() {
        return \App\Models\Material::pluck('name', 'id')->toArray();
    }

    public function render() { abort_if_cannot('add_job_requests'); return view('livewire.admin.job-requests.create', [
            'bodyTypes' => $this->getbodyTypesList(),
            'services' => $this->getservicesList(),
            'materials' => $this->getmaterialsList(),
        ])->layout('components.layouts.app'); }
    public function store(CreateJobRequestAction $action) { $this->validate();  $dto = JobRequestDTO::fromArray([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'brand' => $this->brand,
            'model' => $this->model,
            'body_type_id' => $this->body_type_id,
            'service_id' => $this->service_id,
            'material_id' => $this->material_id,
            'estimated_price' => $this->estimated_price,
            'message' => $this->message,
            'status' => $this->status,
        ]); $action->execute($dto); session()->flash('success', __('job-requests.created')); return to_route('admin.job-requests.index'); }
    protected function rules(): array { return JobRequest::rules(); }
}