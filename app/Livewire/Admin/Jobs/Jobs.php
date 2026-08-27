<?php

namespace App\Livewire\Admin\Jobs;

use App\Models\Job;
use App\Domain\Job\Queries\JobListQuery;
use App\Domain\Job\Actions\DeleteJobAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('Jobs')]
class Jobs extends Component
{
        use WithPagination;

    public int $paginate = 20;
    #[Url(history: true)] public string $search = '';
    #[Url(history: true)] public $car_id = '';
    #[Url(history: true)] public $service_id = '';
    public bool $openFilter = false;
    public string $sortField = 'id';
    public bool $sortAsc = false;

    public function resetFilters() { $this->reset(['search', 'openFilter', 'car_id', 'service_id']); $this->resetPage(); }

    public function render()
    {
        abort_if_cannot('view_jobs');
        $query = (new JobListQuery())->handle([
            'search' => $this->search,
            'car_id' => $this->car_id,
        ], $this->sortField, $this->sortAsc ? 'asc' : 'desc');

        return view('livewire.admin.jobs.index', [
            'items' => $query->paginate($this->paginate),
            'sortableFields' => Job::sortable(),
            'cars' => \App\Models\Car::orderBy('license_plate')->pluck('license_plate', 'id')->toArray(),
            'services' => \App\Models\Service::orderBy('name')->pluck('name', 'id')->toArray(),
        ])->layout('components.layouts.app');
    }

    public function sortBy($field) { if (!in_array($field, Job::sortable(), true)) return; if ($this->sortField === $field) { $this->sortAsc = ! $this->sortAsc; } $this->sortField = $field; }

    public function deleteJob($id, DeleteJobAction $action)
    {
        abort_if_cannot('delete_jobs');
        $item = Job::find($id);
        if (!$item) { $this->dispatch('toast', message: __('jobs.not_found'), type: 'error'); return; }
        try { $action->execute($item); $this->dispatch('toast', message: __('jobs.deleted'), type: 'success'); $this->resetPage(); }
        catch (\Illuminate\Database\QueryException $e) { $this->dispatch('toast', message: __('jobs.delete_error_referenced'), type: 'error'); }
        catch (\Exception $e) { $this->dispatch('toast', message: __('jobs.delete_error'), type: 'error'); }
    }

    public function sendEmail($id)
    {
        $job = Job::with('car.client')->find($id);
        if (!$job) {
            $this->dispatch('toast', message: 'Puna nuk u gjet.', type: 'error');
            return;
        }

        if (!$job->car?->client?->email) {
            $this->dispatch('toast', message: 'Klienti nuk ka një adresë email të regjistruar.', type: 'error');
            return;
        }

        try {
            \Illuminate\Support\Facades\Mail::send(new \App\Mail\Jobs\SendJobMail($job));
            $job->update(['email_sent_at' => now()]);
            $this->dispatch('toast', message: 'Emaili u dërgua me sukses!', type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Gabim gjatë dërgimit: ' . $e->getMessage(), type: 'error');
        }
    }

    public function markWhatsAppSent($id)
    {
        Job::where('id', $id)->update(['whatsapp_sent_at' => now()]);
    }
}
