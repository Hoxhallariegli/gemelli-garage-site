<?php

namespace App\Livewire\Admin\JobRequests;

use App\Models\JobRequest;
use App\Domain\JobRequest\Queries\JobRequestListQuery;
use App\Domain\JobRequest\Actions\DeleteJobRequestAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('JobRequests')]
class JobRequests extends Component
{
        use WithPagination;

    public int $paginate = 10;
    #[Url(history: true)] public string $search = '';
    #[Url(history: true)] public $body_type_id = '';
    #[Url(history: true)] public $service_id = '';
    #[Url(history: true)] public $material_id = '';
    public bool $openFilter = false;
    public string $sortField = 'id';
    public bool $sortAsc = true;

    public function resetFilters() { $this->reset(['search', 'openFilter', 'body_type_id', 'service_id', 'material_id', ]); $this->resetPage(); }

    public function render()
    {
        abort_if_cannot('view_job_requests');
        $query = (new JobRequestListQuery())->handle(['search' => $this->search,             'body_type_id' => $this->body_type_id,
            'service_id' => $this->service_id,
            'material_id' => $this->material_id,
], $this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.admin.job-requests.index', [
            'items' => $query->paginate($this->paginate),
            'sortableFields' => JobRequest::sortable(),
            'bodyTypes' => \App\Models\BodyType::pluck('name', 'id')->toArray(),
            'services' => \App\Models\Service::pluck('name', 'id')->toArray(),
            'materials' => \App\Models\Material::pluck('name', 'id')->toArray(),
        ])->layout('components.layouts.app');
    }

    public function sortBy($field) { if (!in_array($field, JobRequest::sortable(), true)) return; if ($this->sortField === $field) { $this->sortAsc = ! $this->sortAsc; } $this->sortField = $field; }

    public function deleteJobRequest($id, DeleteJobRequestAction $action) 
    {
        abort_if_cannot('delete_job_requests');
        $item = JobRequest::find($id);
        if (!$item) { $this->dispatch('toast', message: __('job-requests.not_found'), type: 'error'); return; }
        try { $action->execute($item); $this->dispatch('toast', message: __('job-requests.deleted'), type: 'success'); $this->resetPage(); } 
        catch (\Illuminate\Database\QueryException $e) { $this->dispatch('toast', message: __('job-requests.delete_error_referenced'), type: 'error'); }
        catch (\Exception $e) { $this->dispatch('toast', message: __('job-requests.delete_error'), type: 'error'); }
    }
}