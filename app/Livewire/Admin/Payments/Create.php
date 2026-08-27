<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payment;
use App\Domain\Payment\DTOs\PaymentDTO;
use App\Domain\Payment\Actions\CreatePaymentAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('Add Payment')]
class Create extends Component
{
        use WithPagination;
     public $job_id = '';
    public $amount = '';
    public $method = '';
    public $payment_date = '';

    #[On('job-created')]
    public function refreshJobs($id) { $this->job_id = $id; $this->updatedJobId($id); }

    public function updatedJobId($value)
    {
        if (!$value) return;
        $related = \App\Models\Job::find($value);
        if (!$related) return;
    }

    protected function getjobsList() {
        return \App\Models\Job::with('car')->get()->pluck('car.license_plate', 'id')->toArray();
    }

    public function render() { abort_if_cannot('add_payments'); return view('livewire.admin.payments.create', [
            'jobs' => $this->getjobsList(),
        ])->layout('components.layouts.app'); }
    public function store(CreatePaymentAction $action) { $this->validate();  $dto = PaymentDTO::fromArray([
            'job_id' => $this->job_id,
            'amount' => $this->amount,
            'method' => $this->method,
            'payment_date' => $this->payment_date,
        ]); $action->execute($dto); session()->flash('success', __('payments.created')); return to_route('admin.payments.index'); }
    protected function rules(): array { return Payment::rules(); }
}
