<?php

namespace App\Livewire\Admin\Clients;

use App\Models\Client;
use App\Domain\Client\DTOs\ClientDTO;
use App\Domain\Client\Actions\UpdateClientAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('Edit Client')]
class Edit extends Component
{
        use WithPagination;
 public Client $item;
    public $name = '';
    public $phone = '';
    public $email = '';
    public $notes = '';
   
    public function mount(Client $client) { $this->item = $client; $this->fill($client->toArray());  }
    public function render() { abort_if_cannot('edit_clients'); return view('livewire.admin.clients.edit', [
        ])->layout('components.layouts.app'); }
    public function update(UpdateClientAction $action) { $this->validate();  $dto = ClientDTO::fromArray([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'notes' => $this->notes,
        ]); $action->execute($this->item, $dto); session()->flash('success', __('clients.updated')); return to_route('admin.clients.index'); }
    protected function rules(): array { return Client::rules($this->item->id); }
}