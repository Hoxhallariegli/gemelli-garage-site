<?php

namespace App\Livewire\Admin\Garages;

use App\Models\Garage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Title('Garazhet / Serviset')]
class Garages extends Component
{
    use WithPagination;

    public int $paginate = 10;
    #[Url(history: true)] public string $search = '';

    public function render()
    {
        abort_if_cannot('view_garages');

        $query = Garage::query();
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('city', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.admin.garages.index', [
            'items' => $query->orderByDesc('id')->paginate($this->paginate),
        ])->layout('components.layouts.app');
    }

    public function deleteGarage($id)
    {
        abort_if_cannot('delete_garages');

        $garage = Garage::find($id);
        if ($garage) {
            $garage->delete();
            $this->dispatch('toast', message: 'Garazhi u fshi me sukses.', type: 'success');
        }
    }
}
