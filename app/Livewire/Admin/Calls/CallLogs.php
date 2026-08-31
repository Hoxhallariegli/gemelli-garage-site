<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Calls;

use App\Models\CallLog;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Call Logs')]
class CallLogs extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $calls = CallLog::query()
            ->when($this->search, function ($query) {
                $query->where('phone_number', 'like', '%' . $this->search . '%')
                    ->orWhere('caller_name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(15);

        return view('livewire.admin.calls.call-logs', [
            'calls' => $calls,
        ])->layout('components.layouts.app');
    }

    public function delete(int $id): void
    {
        CallLog::findOrFail($id)->delete();
        $this->dispatch('toast', ['message' => 'Call log deleted successfully', 'type' => 'success']);
    }
}
