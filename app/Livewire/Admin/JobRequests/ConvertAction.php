<?php

namespace App\Livewire\Admin\JobRequests;

use App\Models\Car;
use App\Models\Client;
use App\Models\Job;
use App\Models\JobRequest;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Domain\Job\DTOs\JobDTO;
use App\Domain\Job\Actions\CreateJobAction;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class ConvertAction extends Component
{
    public JobRequest $jobRequest;

    // Client Info
    public $client_name;
    public $client_email;
    public $client_phone;

    // Car Info
    public $license_plate = '';
    public $brand_id = '';
    public $model_id = '';

    // Pricing
    public $final_price;

    public function mount(JobRequest $jobRequest)
    {
        $this->jobRequest = $jobRequest;
        $this->client_name = $jobRequest->name;
        $this->client_email = $jobRequest->email;
        $this->client_phone = $jobRequest->phone;
        $this->final_price = $jobRequest->estimated_price;

        // Smart match brand
        $brandStr = trim($jobRequest->brand);
        $brand = VehicleBrand::where('name', 'like', '%' . $brandStr . '%')
            ->orWhereRaw('? LIKE "%" || name || "%"', [$brandStr])
            ->first();

        // If not found, try the first word (e.g. "Reno Clio" -> "Reno")
        if (!$brand && str_contains($brandStr, ' ')) {
            $firstWord = explode(' ', $brandStr)[0];
            if (strlen($firstWord) > 2) {
                $brand = VehicleBrand::where('name', 'like', '%' . $firstWord . '%')
                    ->orWhereRaw('? LIKE "%" || name || "%"', [$firstWord])
                    ->first();
            }
        }

        if ($brand) {
            $this->brand_id = $brand->id;

            // Smart match model
            $modelStr = trim($jobRequest->model);
            $model = VehicleModel::where('brand_id', $this->brand_id)
                ->where(function($q) use ($modelStr) {
                    $q->where('name', 'like', '%' . $modelStr . '%')
                      ->orWhereRaw('? LIKE "%" || name || "%"', [$modelStr]);
                })->first();

            if ($model) {
                $this->model_id = $model->id;
            }
        }
    }

    #[On('vehicle-brand-created')]
    public function refreshBrands($id) { $this->brand_id = $id; }

    #[On('vehicle-model-created')]
    public function refreshModels($id) { $this->model_id = $id; }

    public function updatedBrandId()
    {
        $this->model_id = '';
    }

    public function convert(CreateJobAction $action)
    {
        $this->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:255',
            'client_email' => 'nullable|email|max:255',
            'brand_id' => 'required|integer',
            'model_id' => 'required|integer',
            'license_plate' => 'required|string|max:255',
            'final_price' => 'required|numeric',
        ]);

        return DB::transaction(function () use ($action) {
            // 1. Find or Create Client
            $client = Client::where('phone', $this->client_phone)
                ->when($this->client_email, fn($q) => $q->orWhere('email', $this->client_email))
                ->first();

            if (!$client) {
                $client = Client::create([
                    'name' => $this->client_name,
                    'email' => $this->client_email,
                    'phone' => $this->client_phone,
                ]);
            }

            // 2. Find or Create Car
            $car = Car::where('client_id', $client->id)
                ->where('license_plate', $this->license_plate)
                ->first();

            if (!$car) {
                $car = Car::create([
                    'client_id' => $client->id,
                    'brand_id' => $this->brand_id,
                    'model_id' => $this->model_id,
                    'license_plate' => $this->license_plate,
                ]);
            }

            // 3. Prepare DTO
            $services = [];
            if ($this->jobRequest->service_id) {
                $services[] = [
                    'id' => $this->jobRequest->service_id,
                    'sell_price' => $this->jobRequest->service?->base_price ?? 0,
                ];
            }

            $materials = [];
            if ($this->jobRequest->material_id) {
                $materials[] = [
                    'id' => $this->jobRequest->material_id,
                    'quantity' => 1,
                    'cost_price' => $this->jobRequest->material?->purchase_price ?? 0,
                    'sell_price' => $this->jobRequest->material?->sell_price ?? 0,
                ];
            }

            $dto = JobDTO::fromArray([
                'car_id' => $car->id,
                'status' => 'pending',
                'job_date' => now(),
                'final_price' => $this->final_price,
                'services' => $services,
                'materials' => $materials,
            ]);

            // 4. Create Job via Action
            $action->execute($dto);

            // 5. Update JobRequest
            $this->jobRequest->update(['status' => 'converted']);

            session()->flash('success', 'Job request converted successfully.');
            return redirect()->route('admin.jobs.index');
        });
    }

    public function render()
    {
        return view('livewire.admin.job-requests.convert-action', [
            'brands' => VehicleBrand::orderBy('name')->pluck('name', 'id')->toArray(),
            'models' => $this->brand_id ? VehicleModel::where('brand_id', $this->brand_id)->orderBy('name')->pluck('name', 'id')->toArray() : [],
        ]);
    }
}
