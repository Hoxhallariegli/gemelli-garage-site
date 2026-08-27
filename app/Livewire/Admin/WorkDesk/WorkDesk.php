<?php

namespace App\Livewire\Admin\WorkDesk;

use Livewire\Component;
use App\Models\{Client, VehicleBrand, VehicleModel, Material, Service, Car, Job, Part, JobMaterial, JobPart, JobService, Payment};
use App\Domain\Job\DTOs\JobDTO;
use App\Domain\Job\Actions\CreateJobAction;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;

use Livewire\WithFileUploads;

#[Title('Work Desk')]
class WorkDesk extends Component
{
    use WithFileUploads;
    // Registration State
    public $client_id, $brand_id, $model_id, $license_plate, $color, $year, $status = 'pending', $notes;
    public $total_price = 0;

    public $items = [];
    public $clientCars = [];

    // POS State
    public $posSearch = '';
    public $posCategory = 'All';

    // Quick Add State
    public $new_client_name, $new_client_phone;
    public $new_brand_name, $new_brand_logo;
    public $new_model_name, $new_model_body_type_id, $new_model_meters = 0;

    // Completion & Payment State
    public $selectedJobId;
    public $payment_amount = 0;
    public $payment_method = 'cash';
    public $should_complete = true;
    public $job_to_complete;

    // Quick Expense State
    public $expense_title, $expense_amount, $expense_category = 'other', $expense_notes;

    public function mount()
    {
        $this->temp_quantity = 1;
    }

    #[On('client-created')]
    public function refreshClients($id) { $this->client_id = $id; }

    #[On('vehicle-brand-created')]
    public function refreshBrands($id) { $this->brand_id = $id; }

    #[On('vehicle-model-created')]
    public function refreshModels($id) { $this->model_id = $id; }

    #[On('service-created')]
    public function refreshServices($id) { $this->addPosItem('Service', $id); }

    #[On('material-created')]
    public function refreshMaterials($id) { $this->addPosItem('Material', $id); }

    #[On('part-created')]
    public function refreshParts($id) { $this->addPosItem('Part', $id); }

    public function updated($propertyName)
    {
        if ($propertyName === 'brand_id') {
            $this->model_id = null;
        }

        if ($propertyName === 'model_id') {
            $this->recalculateMeters();
        }

        if ($propertyName === 'client_id' && $this->client_id) {
            $this->clientCars = Car::where('client_id', $this->client_id)->latest()->get()->toArray();
            $lastCar = collect($this->clientCars)->first();
            if ($lastCar) {
                $this->brand_id = $lastCar['brand_id'];
                $this->model_id = $lastCar['model_id'];
                $this->license_plate = $lastCar['license_plate'];
                $this->recalculateMeters();
            } else {
                $this->reset(['brand_id', 'model_id', 'license_plate']);
            }
        } elseif ($propertyName === 'client_id' && !$this->client_id) {
            $this->clientCars = [];
            $this->reset(['brand_id', 'model_id', 'license_plate']);
        }

        $this->calculateTotal();
    }

    public function addPosItem($type, $id)
    {
        if ($type === 'Service') {
            $service = Service::find($id);
            if (!$service) return;
            $this->items[] = [
                'type' => 'Service',
                'id' => $service->id,
                'name' => $service->name,
                'brand' => __('workdesk.Service'),
                'quantity' => 1,
                'sell_price' => (float)$service->base_price,
                'cost_price' => 0,
            ];
        } elseif ($type === 'Material') {
            $material = Material::find($id);
            if (!$material) return;

            if ($material->stock_meters <= 0) {
                $this->dispatch('toast', message: __('workdesk.No stock for') . ": {$material->name}", type: 'error');
                return;
            }

            $qty = 1;
            if ($this->model_id) {
                $vModel = VehicleModel::with('bodyType')->find($this->model_id);
                $qty = $vModel->wrap_meters_needed ?? ($vModel->bodyType?->wrap_meters ?? 1);
            }

            $this->items[] = [
                'type' => 'Material',
                'id' => $material->id,
                'name' => $material->name,
                'brand' => $material->brand,
                'quantity' => (float)$qty,
                'sell_price' => (float)$material->sell_price,
                'cost_price' => (float)$material->purchase_price,
            ];
        } else {
            $part = Part::find($id);
            if (!$part) return;

            if ($part->stock_quantity <= 0) {
                $this->dispatch('toast', message: __('workdesk.No stock for') . ": {$part->name}", type: 'error');
                return;
            }

            $this->items[] = [
                'type' => 'Part',
                'id' => $part->id,
                'name' => $part->name,
                'brand' => __('workdesk.Part'),
                'quantity' => 1,
                'sell_price' => (float)$part->sell_price,
                'cost_price' => (float)$part->purchase_price,
            ];
        }

        $this->calculateTotal();
        $this->dispatch('toast', message: __('workdesk.Added to list'), type: 'success');
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotal();
    }

    public function incrementQuantity($index)
    {
        $this->items[$index]['quantity'] = (float)$this->items[$index]['quantity'] + ($this->items[$index]['type'] === 'Material' ? 0.5 : 1);
        $this->calculateTotal();
    }

    public function decrementQuantity($index)
    {
        if ($this->items[$index]['quantity'] > 0.5) {
            $this->items[$index]['quantity'] = (float)$this->items[$index]['quantity'] - ($this->items[$index]['type'] === 'Material' ? 0.5 : 1);
        }
        $this->calculateTotal();
    }

    public function selectCar($carId)
    {
        $car = collect($this->clientCars)->firstWhere('id', $carId);
        if ($car) {
            $this->brand_id = $car['brand_id'];
            $this->model_id = $car['model_id'];
            $this->license_plate = $car['license_plate'];
            $this->recalculateMeters();
            $this->dispatch('toast', message: 'Mjeti u ndryshua', type: 'info');
        }
    }

    private function recalculateMeters()
    {
        if ($this->model_id) {
            $vModel = VehicleModel::with('bodyType')->find($this->model_id);
            if ($vModel) {
                $newQty = $vModel->wrap_meters_needed ?? ($vModel->bodyType?->wrap_meters ?? 1);
                foreach ($this->items as &$item) {
                    if ($item['type'] === 'Material') {
                        $item['quantity'] = (float)$newQty;
                    }
                }
            }
        }
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total_price = collect($this->items)->sum(fn($i) => (float)($i['quantity'] ?: 0) * (float)($i['sell_price'] ?: 0));
    }

    public function saveReception(CreateJobAction $action)
    {
        $this->validate([
            'client_id' => 'required',
            'items' => 'required|array|min:1',
        ]);

        try {
            // Stock Validation
            foreach ($this->items as $item) {
                if ($item['type'] === 'Material') {
                    $material = Material::find($item['id']);
                    if ($material && $material->stock_meters < $item['quantity']) {
                        throw new \Exception(__('workdesk.Low stock for') . ": {$material->name}. " . __('workdesk.Current stock') . ": {$material->stock_meters}m");
                    }
                } elseif ($item['type'] === 'Part') {
                    $part = Part::find($item['id']);
                    if ($part && $part->stock_quantity < $item['quantity']) {
                        throw new \Exception(__('workdesk.Low stock for') . ": {$part->name}. " . __('workdesk.Current stock') . ": {$part->stock_quantity}");
                    }
                }
            }

            $car = Car::updateOrCreate(
                ['license_plate' => $this->license_plate],
                [
                    'client_id' => $this->client_id,
                    'brand_id' => $this->brand_id,
                    'model_id' => $this->model_id,
                ]
            );

            $dto = JobDTO::fromArray([
                'car_id' => $car->id,
                'final_price' => $this->total_price,
                'status' => 'pending',
                'job_date' => now(),
                'notes' => $this->notes,
                'services' => collect($this->items)->filter(fn($i) => $i['type'] === 'Service')->toArray(),
                'materials' => collect($this->items)->filter(fn($i) => $i['type'] === 'Material')->toArray(),
                'parts' => collect($this->items)->filter(fn($i) => $i['type'] === 'Part')->toArray(),
            ]);

            $action->execute($dto);

            $this->resetAll();
            $this->dispatch('toast', message: 'Regjistrimi u krye me sukses', type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Gabim: ' . $e->getMessage(), type: 'error');
        }
    }

    public function resetAll() {
        $this->reset(['client_id', 'brand_id', 'model_id', 'license_plate', 'color', 'year', 'notes', 'total_price', 'items']);
    }

    public function addClient()
    {
        $this->validate(['new_client_name' => 'required|string|max:255']);
        $client = Client::create([
            'name' => $this->new_client_name,
            'phone' => $this->new_client_phone
        ]);
        $this->client_id = $client->id;
        $this->reset(['new_client_name', 'new_client_phone']);
        $this->dispatch('close-modal');
        $this->dispatch('toast', message: 'Klienti u shtua', type: 'success');
    }

    public function addBrand()
    {
        $this->validate([
            'new_brand_name' => 'required|string|max:255',
            'new_brand_logo' => 'nullable|image|max:2048'
        ]);

        $logoPath = null;
        if ($this->new_brand_logo) {
            $logoPath = $this->new_brand_logo->store('brands', 'public');
        }

        $brand = VehicleBrand::create([
            'name' => $this->new_brand_name,
            'logo' => $logoPath
        ]);

        $this->brand_id = $brand->id;
        $this->reset(['new_brand_name', 'new_brand_logo']);
        $this->dispatch('close-modal');
        $this->dispatch('toast', message: 'Marka u shtua', type: 'success');
    }

    public function addModel()
    {
        if (!$this->brand_id) {
            $this->dispatch('toast', message: 'Zgjidhni markën më parë', type: 'error');
            return;
        }
        $this->validate([
            'new_model_name' => 'required|string|max:255',
            'new_model_body_type_id' => 'required|integer',
            'new_model_meters' => 'required|numeric|min:0'
        ]);
        $model = VehicleModel::create([
            'brand_id' => $this->brand_id,
            'name' => $this->new_model_name,
            'body_type_id' => $this->new_model_body_type_id,
            'wrap_meters_needed' => $this->new_model_meters
        ]);
        $this->model_id = $model->id;
        $this->reset(['new_model_name', 'new_model_body_type_id', 'new_model_meters']);
        $this->dispatch('close-modal');
        $this->dispatch('toast', message: 'Modeli u shtua', type: 'success');
        $this->calculateTotal();
    }

    public function updatedNewModelBodyTypeId($value)
    {
        if (!$value) return;
        $related = \App\Models\BodyType::find($value);
        if ($related) {
            $this->new_model_meters = $related->wrap_meters;
        }
    }

    public function openCompletionModal($id)
    {
        $this->selectedJobId = $id;
        $this->job_to_complete = Job::with(['car.client', 'car.brand', 'car.model.bodyType', 'payments', 'services.service', 'materials.material', 'parts.part'])->find($id);
        $this->payment_amount = $this->job_to_complete->remaining_balance;
        $this->payment_method = 'cash';
        $this->should_complete = true;
        $this->dispatch('open-modal', id: 'completion-modal');
    }

    public function savePaymentAndComplete()
    {
        $this->validate([
            'payment_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,transfer',
        ]);

        $job = Job::find($this->selectedJobId);

        if ($this->payment_amount > 0) {
            Payment::create([
                'job_id' => $job->id,
                'amount' => $this->payment_amount,
                'method' => $this->payment_method,
                'payment_date' => now(),
            ]);
        }

        if ($this->should_complete) {
            $job->update(['status' => 'completed']);
        }

        $this->dispatch('close-modal');
        $this->dispatch('toast', message: 'Veprimi u kreu me sukses', type: 'success');
        $this->reset(['selectedJobId', 'payment_amount', 'payment_method', 'should_complete', 'job_to_complete']);
    }

    public function completeJob($id)
    {
        $this->openCompletionModal($id);
    }

    public function sendEmail($id)
    {
        $job = Job::with(['car.client', 'car.brand', 'car.model.bodyType', 'services.service', 'materials.material', 'parts.part', 'payments'])->find($id);
        if (!$job) {
            $this->dispatch('toast', message: 'Puna nuk u gjet.', type: 'error');
            return;
        }

        if (!$job->car?->client?->email) {
            $this->dispatch('toast', message: 'Klienti nuk ka një adresë email të regjistruar.', type: 'error');
            return;
        }

        try {
            \Illuminate\Support\Facades\Mail::send(new \App\Mail\Jobs\SendJobMail($job));
            $job->update(['email_sent_at' => now()]);
            $this->dispatch('toast', message: 'Emaili u dërgua me sukses!', type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Gabim gjatë dërgimit: ' . $e->getMessage(), type: 'error');
        }
    }

    public function markWhatsAppSent($id)
    {
        Job::where('id', $id)->update(['whatsapp_sent_at' => now()]);
    }

    public function openExpenseModal($id)
    {
        $this->selectedJobId = $id;
        $this->reset(['expense_title', 'expense_amount', 'expense_notes']);
        $this->expense_category = 'other';
        $this->dispatch('open-modal', id: 'quick-expense-modal');
    }

    public function saveQuickExpense(\App\Domain\Expense\Actions\CreateExpenseAction $action)
    {
        $this->validate([
            'expense_title' => 'required|string|max:255',
            'expense_amount' => 'required|numeric|min:0.01',
            'expense_category' => 'required',
        ]);

        $dto = \App\Domain\Expense\DTOs\ExpenseDTO::fromArray([
            'title' => $this->expense_title,
            'amount' => $this->expense_amount,
            'date' => now()->format('Y-m-d'),
            'category' => $this->expense_category,
            'job_id' => $this->selectedJobId,
            'notes' => $this->expense_notes,
        ]);

        $action->execute($dto);

        $this->dispatch('close-modal');
        $this->dispatch('toast', message: 'Shpenzimi u shtua me sukses', type: 'success');
        $this->reset(['expense_title', 'expense_amount', 'expense_category', 'expense_notes', 'selectedJobId']);
    }

    public function render()
    {
        abort_if_cannot('view_workdesk');
        $activeJobs = Job::with(['car.client', 'car.brand', 'car.model.bodyType', 'materials.material', 'parts.part', 'services.service', 'payments'])
            ->latest()
            ->get()
            ->filter(function($job) {
                // Keep if work is not finished OR if there is still a balance to pay
                return !in_array($job->status, ['completed', 'cancelled']) || $job->remaining_balance > 0.01;
            });

        return view('livewire.admin.work-desk.work-desk', [
            'clients' => Client::orderBy('name')->pluck('name', 'id')->toArray(),
            'brands' => VehicleBrand::orderBy('name')->pluck('name', 'id')->toArray(),
            'bodyTypes' => \App\Models\BodyType::orderBy('name')->pluck('name', 'id')->toArray(),
            'models' => $this->brand_id ? VehicleModel::where('brand_id', $this->brand_id)->orderBy('name')->pluck('name', 'id')->toArray() : [],
            'posItems' => $this->getPosItems(),
            'activeJobs' => $activeJobs,
        ])->layout('components.layouts.app');
    }

    protected function getPosItems()
    {
        $limit = 24;

        if ($this->posCategory === 'All') {
            $services = Service::query()->where('active', true)->where('name', 'like', '%' . $this->posSearch . '%')->orderBy('name')->take($limit)->get()->map(fn($i) => ['id' => $i->id, 'name' => $i->name, 'image' => $i->image, 'sell_price' => $i->base_price, 'type_label' => 'Service', 'stock' => null]);
            $materials = Material::query()->where('name', 'like', '%' . $this->posSearch . '%')->orderBy('name')->take($limit)->get()->map(fn($i) => ['id' => $i->id, 'name' => $i->name, 'image' => $i->image, 'sell_price' => $i->sell_price, 'type_label' => 'Material', 'stock' => $i->stock_meters]);
            $parts = Part::query()->where('name', 'like', '%' . $this->posSearch . '%')->orderBy('name')->take($limit)->get()->map(fn($i) => ['id' => $i->id, 'name' => $i->name, 'image' => $i->image, 'sell_price' => $i->sell_price, 'type_label' => 'Part', 'stock' => $i->stock_quantity]);

            return collect($services)->merge($materials)->merge($parts)->sortBy('name')->take($limit);
        }

        $query = match($this->posCategory) {
            'Service' => Service::query()->where('active', true),
            'Material' => Material::query(),
            'Part' => Part::query(),
        };

        if ($this->posSearch) {
            $query->where('name', 'like', '%' . $this->posSearch . '%');
        }

        $type = $this->posCategory;
        return $query->orderBy('name')->take($limit)->get()->map(function($i) use ($type) {
            return [
                'id' => $i->id,
                'name' => $i->name,
                'image' => $i->image,
                'sell_price' => $type === 'Service' ? $i->base_price : $i->sell_price,
                'type_label' => $type,
                'stock' => $type === 'Material' ? $i->stock_meters : ($type === 'Part' ? $i->stock_quantity : null)
            ];
        });
    }
}
