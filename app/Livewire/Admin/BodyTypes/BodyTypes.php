<?php

namespace App\Livewire\Admin\BodyTypes;

use App\Models\BodyType;
use App\Domain\BodyType\Queries\BodyTypeListQuery;
use App\Domain\BodyType\Actions\DeleteBodyTypeAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Title('BodyTypes')]
class BodyTypes extends Component
{
    use WithPagination;

    public int $paginate = 15;
    #[Url(history: true)] public string $search = '';
    public bool $openFilter = false;
    public string $sortField = 'id';
    public bool $sortAsc = true;

    public function resetFilters() { $this->reset(['search', 'openFilter', ]); $this->resetPage(); }

    public function render()
    {
        abort_if_cannot('view_body_types');
        $query = (new BodyTypeListQuery())->handle(['search' => $this->search, ], $this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.admin.body-types.index', [
            'items' => $query->paginate($this->paginate),
            'sortableFields' => BodyType::sortable(),
        ])->layout('components.layouts.app');
    }

    public function sortBy($field) { if (!in_array($field, BodyType::sortable(), true)) return; if ($this->sortField === $field) { $this->sortAsc = ! $this->sortAsc; } $this->sortField = $field; }

    public function deleteBodyType($id, DeleteBodyTypeAction $action)
    {
        abort_if_cannot('delete_body_types');
        $item = BodyType::find($id);
        if (!$item) { $this->dispatch('toast', message: __('body-types.not_found'), type: 'error'); return; }
        try {
            if ($item->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($item->image);
            }
            $action->execute($item);
            $this->dispatch('toast', message: __('body-types.deleted'), type: 'success');
            $this->resetPage();
        }
        catch (\Illuminate\Database\QueryException $e) { $this->dispatch('toast', message: __('body-types.delete_error_referenced'), type: 'error'); }
        catch (\Exception $e) { $this->dispatch('toast', message: __('body-types.delete_error'), type: 'error'); }
    }
}
