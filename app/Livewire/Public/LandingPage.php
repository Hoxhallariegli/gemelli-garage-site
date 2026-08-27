<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Service;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\Material;
use App\Models\JobRequest;
use App\Domain\JobRequest\DTOs\JobRequestDTO;
use App\Domain\JobRequest\Actions\CreateJobRequestAction;
use Illuminate\Support\Facades\Mail;
use App\Mail\Public\JobRequestConfirmation;

class LandingPage extends Component
{
    // Form Data
    public $brand;
    public $model;
    public $body_type_id;
    public $selected_services = [];
    public $material_id;
    public $name, $email, $phone, $message;

    // UI State
    public $step = 1; // 1: Vehicle, 2: Configurator, 3: Contact
    public $success = false;

    public function selectBodyType($id)
    {
        $this->body_type_id = $id;
        $this->step = 2;
    }

    public function toggleService($id)
    {
        if (in_array($id, $this->selected_services)) {
            $this->selected_services = array_diff($this->selected_services, [$id]);
        } else {
            $this->selected_services[] = $id;
        }
    }

    public function selectMaterial($id)
    {
        if ($this->material_id == $id) {
            $this->material_id = null;
        } else {
            $this->material_id = $id;
        }
    }

    public function goToStep($step)
    {
        $this->step = $step;
        if ($step == 3) {
            $this->dispatch('scroll-to-contact');
        }
    }

    public function getEstimatedPriceProperty()
    {
        $total = 0;

        foreach ($this->selected_services as $sId) {
            $service = Service::find($sId);
            if ($service) {
                $total += (float) $service->base_price;
            }
        }

        if ($this->material_id && $this->body_type_id) {
            $bodyType = \App\Models\BodyType::find($this->body_type_id);
            $material = Material::find($this->material_id);
            if ($bodyType && $material) {
                $total += ($bodyType->wrap_meters * $material->sell_price);
            }
        }

        return $total;
    }

    public function submitAppointment(CreateJobRequestAction $action)
    {
        $this->validate([
            'name' => 'required|min:3',
            'phone' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'body_type_id' => 'required',
        ]);

        $serviceIds = empty($this->selected_services) ? null : $this->selected_services[0];

        $dto = JobRequestDTO::fromArray([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'brand' => $this->brand,
            'model' => $this->model,
            'body_type_id' => $this->body_type_id,
            'service_id' => $serviceIds,
            'material_id' => $this->material_id,
            'estimated_price' => $this->estimatedPrice,
            'message' => "Servizi Scelti: " . implode(', ', Service::whereIn('id', $this->selected_services)->pluck('name')->toArray()) . "\n\n" . $this->message,
            'status' => 'pending',
        ]);

        $item = $action->execute($dto);

        if ($this->email) {
            try {
                Mail::to($this->email)->send(new JobRequestConfirmation($item));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Mail failed: ' . $e->getMessage());
            }
        }

        $this->success = true;
        $this->reset(['name', 'email', 'phone', 'message', 'brand', 'model', 'body_type_id', 'selected_services', 'material_id', 'step']);
    }

    public function render()
    {
        return view('livewire.public.landing-page', [
            'services' => Service::where('active', true)->get(),
            'materials' => Material::all(),
            'bodyTypes' => \App\Models\BodyType::all(),
        ])->layout('components.layouts.guest');
    }
}

