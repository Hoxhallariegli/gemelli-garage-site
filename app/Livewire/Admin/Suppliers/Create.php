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

#[Title('Add Supplier')]
class Create extends Component
{
    use WithPagination;
    public $name = '';
    public $contact_person = '';
    public $phone = '';
    public $email = '';

    public function render() { abort_if_cannot('add_suppliers'); return view('livewire.admin.suppliers.create', [
        ])->layout('components.layouts.app'); }
    public function store(CreateSupplierAction $action) { $this->validate();  $dto = SupplierDTO::fromArray([
            'name' => $this->name,
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'email' => $this->email,
        ]); $action->execute($dto); session()->flash('success', __('suppliers.created')); return to_route('admin.suppliers.index'); }
    protected function rules(): array { return Supplier::rules(); }
}
