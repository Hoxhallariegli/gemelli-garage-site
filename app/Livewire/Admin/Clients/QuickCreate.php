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

class QuickCreate extends Component
{
        use WithPagination;
     public $name = '';
    public $phone = '';
    public $email = '';
    public $notes = '';
   
    public bool $created = false;
    public ?int $createdId = null;
    public string $createdLabel = '';

    public function render() { return view('livewire.admin.clients.quick-create', [
        ]); }

    public function store(CreateClientAction $action)
    {
        $this->validate();
        $dto = ClientDTO::fromArray([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'notes' => $this->notes,
        ]);
        $item = $action->execute($dto);
        $this->dispatch('client-created', id: $item->id);
        $this->js("Livewire.dispatch('client-created', { id: {$item->id} })");
        $this->dispatch('toast', message: __('clients.created'), type: 'success');
        $this->created = true;
        $this->createdId = $item->id;
        $this->createdLabel = (string) ($item->name ?? $item->id);
        $this->reset(['name', 'phone', 'email', 'notes']);
    }

    public function addAnother()
    {
        $this->created = false;
        $this->createdId = null;
        $this->createdLabel = '';
    }

    protected function rules(): array { return Client::rules(); }
}