<?php

namespace App\Livewire\Admin\Payments;

use App\Models\Payment;
use App\Domain\Payment\DTOs\PaymentDTO;
use App\Domain\Payment\Actions\UpdatePaymentAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Title('Edit Payment')]
class Edit extends Component
{
        use WithPagination;
 public Payment $item;
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

    public function mount(Payment $payment) { $this->item = $payment; $this->fill($payment->toArray()); $this->payment_date = $payment->payment_date?->format('Y-m-d\TH:i'); }
    public function render() { abort_if_cannot('edit_payments'); return view('livewire.admin.payments.edit', [
            'jobs' => $this->getjobsList(),
        ])->layout('components.layouts.app'); }
    public function update(UpdatePaymentAction $action) { $this->validate();  $dto = PaymentDTO::fromArray([
            'job_id' => $this->job_id,
            'amount' => $this->amount,
            'method' => $this->method,
            'payment_date' => $this->payment_date,
        ]); $action->execute($this->item, $dto); session()->flash('success', __('payments.updated')); return to_route('admin.payments.index'); }
    protected function rules(): array { return Payment::rules($this->item->id); }
}
