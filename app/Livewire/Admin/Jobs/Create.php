<?php

namespace App\Livewire\Admin\Jobs;

use App\Models\Job;
use App\Models\Car;
use App\Models\Service;
use App\Models\Material;
use App\Models\Part;
use App\Domain\Job\DTOs\JobDTO;
use App\Domain\Job\Actions\CreateJobAction;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;

#[Title('New Job Card')]
class Create extends Component
{
    public $car_id, $status = 'pending', $job_date, $notes;

    public $items = [];

    // POS State
    public $posSearch = '';
    public $posCategory = 'All';

    public function mount()
    {
        $this->job_date = now()->format('Y-m-d\TH:i');
    }

    #[On('car-created')]
    public function refreshCars($id) { $this->car_id = $id; }

    #[On('service-created')]
    public function refreshServices($id) { $this->addPosItem('Service', $id); }

    #[On('material-created')]
    public function refreshMaterials($id) { $this->addPosItem('Material', $id); }

    #[On('part-created')]
    public function refreshParts($id) { $this->addPosItem('Part', $id); }

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
            $material = Material::with('materialBrand')->find($id);
            if (!$material) return;

            if ($material->stock_meters <= 0) {
                $this->dispatch('toast', message: __('workdesk.No stock for') . ": {$material->name}", type: 'error');
                return;
            }

            $qty = 1;
            if ($this->car_id) {
                $car = Car::with('model')->find($this->car_id);
                if ($car && $car->model) {
                    $qty = (float) ($car->model->wrap_meters_needed ?? 1);
                }
            }

            $this->items[] = [
                'type' => 'Material',
                'id' => $material->id,
                'name' => $material->name,
                'brand' => $material->materialBrand?->name ?? '-',
                'quantity' => $qty,
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
        $this->dispatch('toast', message: __('workdesk.Added to list'), type: 'success');
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function incrementQuantity($index)
    {
        $this->items[$index]['quantity'] = (float)$this->items[$index]['quantity'] + ($this->items[$index]['type'] === 'Material' ? 0.5 : 1);
    }

    public function decrementQuantity($index)
    {
        if ($this->items[$index]['quantity'] > 0.5) {
            $this->items[$index]['quantity'] = (float)$this->items[$index]['quantity'] - ($this->items[$index]['type'] === 'Material' ? 0.5 : 1);
        }
    }

    public function store(CreateJobAction $action)
    {
        $this->validate([
            'car_id' => 'required',
            'status' => 'required',
            'job_date' => 'required',
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

            $totalRevenue = collect($this->items)->sum(fn($i) => (float)$i['quantity'] * (float)$i['sell_price']);

            $dto = JobDTO::fromArray([
                'car_id' => $this->car_id,
                'status' => $this->status,
                'job_date' => $this->job_date,
                'notes' => $this->notes,
                'final_price' => $totalRevenue,
                'services' => collect($this->items)->filter(fn($i) => $i['type'] === 'Service')->toArray(),
                'materials' => collect($this->items)->filter(fn($i) => $i['type'] === 'Material')->toArray(),
                'parts' => collect($this->items)->filter(fn($i) => $i['type'] === 'Part')->toArray(),
            ]);

            $action->execute($dto);

            session()->flash('success', 'Job Card created successfully.');
            return to_route('admin.jobs.index');
        } catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        $servicesTotal = collect($this->items)->filter(fn($i) => $i['type'] === 'Service')->sum(fn($i) => (float)($i['quantity'] ?: 0) * (float)($i['sell_price'] ?: 0));
        $inventoryTotal = collect($this->items)->filter(fn($i) => $i['type'] !== 'Service')->sum(fn($i) => (float)($i['quantity'] ?: 0) * (float)($i['sell_price'] ?: 0));

        $selectedCar = $this->car_id ? Car::with('client')->find($this->car_id) : null;

        return view('livewire.admin.jobs.create', [
            'cars' => Car::with(['brand', 'model'])->get()->mapWithKeys(fn($c) => [$c->id => $c->license_plate . " (" . $c->brand?->name . " " . $c->model?->name . ")"])->toArray(),
            'posItems' => $this->getPosItems(),
            'totalRevenue' => $servicesTotal + $inventoryTotal,
            'servicesTotal' => $servicesTotal,
            'inventoryTotal' => $inventoryTotal,
            'totalCost' => collect($this->items)->sum(fn($i) => (float)($i['quantity'] ?: 0) * (float)($i['cost_price'] ?: 0)),
            'selectedClientName' => $selectedCar?->client?->name ?? 'N/A',
        ])->layout('components.layouts.app');
    }

    protected function getPosItems()
    {
        $limit = 24;

        if ($this->posCategory === 'All') {
            $services = Service::query()->where('active', true)->where('name', 'like', '%' . $this->posSearch . '%')->orderBy('name')->take($limit)->get()->map(fn($i) => ['id' => $i->id, 'name' => $i->name, 'image' => $i->image, 'sell_price' => $i->base_price, 'type_label' => 'Service', 'stock' => null]);
            $materials = Material::query()->with('materialBrand')->where('name', 'like', '%' . $this->posSearch . '%')->orderBy('name')->take($limit)->get()->map(fn($i) => ['id' => $i->id, 'name' => $i->name, 'image' => $i->image, 'sell_price' => $i->sell_price, 'type_label' => 'Material', 'stock' => $i->stock_meters]);
            $parts = Part::query()->where('name', 'like', '%' . $this->posSearch . '%')->orderBy('name')->take($limit)->get()->map(fn($i) => ['id' => $i->id, 'name' => $i->name, 'image' => $i->image, 'sell_price' => $i->sell_price, 'type_label' => 'Part', 'stock' => $i->stock_quantity]);

            return collect($services)->merge($materials)->merge($parts)->sortBy('name')->take($limit);
        }

        $query = match($this->posCategory) {
            'Service' => Service::query()->where('active', true),
            'Material' => Material::query()->with('materialBrand'),
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
