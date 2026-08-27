<?php

namespace App\Livewire\Admin\Clients;

use App\Models\Client;
use App\Domain\Client\DTOs\ClientDTO;
use App\Domain\Client\Actions\CreateClientAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('Add Client')]
class Create extends Component
{
        use WithPagination;
     public $name = '';
    public $phone = '';
    public $email = '';
    public $notes = '';
   
    public function render() { abort_if_cannot('add_clients'); return view('livewire.admin.clients.create', [
        ])->layout('components.layouts.app'); }
    public function store(CreateClientAction $action) { $this->validate();  $dto = ClientDTO::fromArray([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'notes' => $this->notes,
        ]); $action->execute($dto); session()->flash('success', __('clients.created')); return to_route('admin.clients.index'); }
    protected function rules(): array { return Client::rules(); }
}