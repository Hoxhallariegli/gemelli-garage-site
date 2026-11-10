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
    public $validationError = null;

    public function selectBodyType($id)
    {
        $this->body_type_id = $id;
        $this->validationError = null;
        $this->step = 2;
        $this->dispatch('scroll-to-configurator');
    }

    public function toggleService($id)
    {
        $this->validationError = null;
        if (in_array($id, $this->selected_services)) {
            $this->selected_services = array_diff($this->selected_services, [$id]);
        } else {
            $this->selected_services[] = $id;
        }
    }

    public function addServiceAndScroll($id)
    {
        $this->validationError = null;
        if (!in_array($id, $this->selected_services)) {
            $this->selected_services[] = $id;
        }
        $this->step = 2;
        $this->dispatch('scroll-to-configurator');
    }

    public function selectMaterial($id)
    {
        $this->validationError = null;
        if ($this->material_id == $id) {
            $this->material_id = null;
        } else {
            $this->material_id = $id;
        }
    }

    public function goToStep($step)
    {
        $this->validationError = null;

        // Validation before going to Step 3
        if ($step == 3) {
            if (empty($this->selected_services) && !$this->material_id) {
                $this->validationError = __('front.select_at_least_one');
                $this->dispatch('scroll-to-configurator');
                return;
            }

            if ($this->isWrapSelected && !$this->material_id) {
                $this->validationError = __('front.material_required') ?? 'Ju lutem zgjidhni materialin për Wrapping.';
                $this->dispatch('scroll-to-configurator');
                return;
            }
        }

        if ($step == 2 && !$this->body_type_id) {
            $this->step = 1;
            $this->dispatch('scroll-to-configurator');
            return;
        }

        $this->step = $step;
        $this->dispatch('scroll-to-configurator');
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

    public function getSelectedServicesDataProperty()
    {
        return Service::whereIn('id', $this->selected_services)->get();
    }

    public function getSelectedMaterialDataProperty()
    {
        return $this->material_id ? Material::find($this->material_id) : null;
    }

    public function getSelectedBodyTypeDataProperty()
    {
        return $this->body_type_id ? \App\Models\BodyType::find($this->body_type_id) : null;
    }

    public function getIsWrapSelectedProperty()
    {
        $wrapServices = Service::whereIn('id', $this->selected_services)
            ->where('name', 'LIKE', '%Wrap%')
            ->count();

        return $wrapServices > 0;
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
            'message' => __('front.chosen_services') . ": " . implode(', ', Service::whereIn('id', $this->selected_services)->pluck('name')->toArray()) . "\n\n" . $this->message,
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

        if ($item->phone) {
            try {
                $whatsapp = app(\App\Services\WhatsAppService::class);
                $brandStr = $item->brand ?? '';
                $modelStr = $item->model ?? '';
                $vehicleStr = trim("$brandStr $modelStr");
                $garageName = mb_strtoupper($item->garage?->name ?? 'GEMELLI GARAGE');

                $templateBody = \App\Models\SmsTemplate::getTemplate('booking_confirmation');

                if ($templateBody) {
                    $msg = str_replace(
                        ['{name}', '{vehicle}', '{garage}'],
                        [$item->name, $vehicleStr, $garageName],
                        $templateBody
                    );
                } else {
                    $msg = "--- {$garageName} ---\n\n" .
                           "Përshëndetje *" . $item->name . "*,\n\n" .
                           "Aplikimi juaj për rezervim të mjetit (" . $vehicleStr . ") u realizua me sukses!\n\n" .
                           "Ekipi ynë po e shqyrton kërkesën dhe do t'ju kontaktojë së shpejti për konfirmimin përfundimtar.\n\n" .
                           "Faleminderit!";
                }

                $whatsapp->send(
                    phone: $item->phone,
                    message: $msg,
                    tenantId: $item->tenant_id ?? 1
                );
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('WhatsApp booking notification error: ' . $e->getMessage());
            }
        }

        $this->success = true;
        $this->reset(['name', 'email', 'phone', 'message', 'brand', 'model', 'body_type_id', 'selected_services', 'material_id', 'step']);
    }

    public function render()
    {
        $materialBrands = \App\Models\MaterialBrand::all();

        // Fallback to materials table if material_brands is empty
        if ($materialBrands->isEmpty()) {
            $materialBrands = Material::query()
                ->whereNotNull('brand')
                ->where('brand', '!=', '')
                ->pluck('brand')
                ->unique()
                ->map(fn($name) => (object)['name' => $name, 'image' => null]);
        }

        return view('livewire.public.landing-page', [
            'services' => Service::where('active', true)->get(),
            'materials' => Material::all(),
            'bodyTypes' => \App\Models\BodyType::all(),
            'materialBrands' => $materialBrands,
        ])->layout('components.layouts.guest');
    }
}
