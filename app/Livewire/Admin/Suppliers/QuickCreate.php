<?php

namespace App\Livewire\Admin\Suppliers;

use App\Models\Supplier;
use App\Domain\Supplier\DTOs\SupplierDTO;
use App\Domain\Supplier\Actions\CreateSupplierAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

class QuickCreate extends Component
{
    use WithPagination;
    public $name = '';
    public $contact_person = '';
    public $phone = '';
    public $email = '';

    public bool $created = false;
    public ?int $createdId = null;
    public string $createdLabel = '';

    public function render() { return view('livewire.admin.suppliers.quick-create', [
        ]); }

    public function store(CreateSupplierAction $action)
    {
        $this->validate();
        $dto = SupplierDTO::fromArray([
            'name' => $this->name,
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'email' => $this->email,
        ]);
        $item = $action->execute($dto);
        $this->dispatch('supplier-created', id: $item->id);
        $this->js("Livewire.dispatch('supplier-created', { id: {$item->id} })");
        $this->dispatch('toast', message: __('suppliers.created'), type: 'success');
        $this->created = true;
        $this->createdId = $item->id;
        $this->createdLabel = (string) ($item->name ?? $item->id);
        $this->reset(['name', 'contact_person', 'phone', 'email']);
    }

    public function addAnother()
    {
        $this->created = false;
        $this->createdId = null;
        $this->createdLabel = '';
    }

    protected function rules(): array { return Supplier::rules(); }
}
