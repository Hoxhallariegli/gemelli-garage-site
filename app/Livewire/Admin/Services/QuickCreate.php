<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
use App\Domain\Service\DTOs\ServiceDTO;
use App\Domain\Service\Actions\CreateServiceAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

class QuickCreate extends Component
{
        use WithPagination;
     public $name = '';
    public $description = '';
    public $base_price = '';
    public $active = true;

    public bool $created = false;
    public ?int $createdId = null;
    public string $createdLabel = '';

    public function render() { return view('livewire.admin.services.quick-create', [
        ]); }

    public function store(CreateServiceAction $action)
    {
        $this->validate();
        $dto = ServiceDTO::fromArray([
            'name' => $this->name,
            'description' => $this->description,
            'base_price' => $this->base_price,
            'active' => $this->active,
        ]);
        $item = $action->execute($dto);
        $this->dispatch('service-created', id: $item->id);
        $this->js("Livewire.dispatch('service-created', { id: {$item->id} })");
        $this->dispatch('toast', message: __('services.created'), type: 'success');
        $this->created = true;
        $this->createdId = $item->id;
        $this->createdLabel = (string) ($item->name ?? $item->id);
        $this->reset(['name', 'description', 'base_price', 'active']);
    }

    public function addAnother()
    {
        $this->created = false;
        $this->createdId = null;
        $this->createdLabel = '';
    }

    protected function rules(): array { return Service::rules(); }
}
