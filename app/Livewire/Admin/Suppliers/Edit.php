<?php

namespace App\Livewire\Admin\Suppliers;

use App\Models\Supplier;
use App\Domain\Supplier\DTOs\SupplierDTO;
use App\Domain\Supplier\Actions\UpdateSupplierAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('Edit Supplier')]
class Edit extends Component
{
    use WithPagination; public Supplier $item;
    public $name = '';
    public $contact_person = '';
    public $phone = '';
    public $email = '';

    public function mount(Supplier $supplier) { $this->item = $supplier; $this->fill($supplier->toArray());  }
    public function render() { abort_if_cannot('edit_suppliers'); return view('livewire.admin.suppliers.edit', [
        ])->layout('components.layouts.app'); }
    public function update(UpdateSupplierAction $action) { $this->validate();  $dto = SupplierDTO::fromArray([
            'name' => $this->name,
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'email' => $this->email,
        ]); $action->execute($this->item, $dto); session()->flash('success', __('suppliers.updated')); return to_route('admin.suppliers.index'); }
    protected function rules(): array { return Supplier::rules($this->item->id); }
}
