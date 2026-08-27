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

class QuickCreate extends Component
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

    public bool $created = false;
    public ?int $createdId = null;
    public string $createdLabel = '';

    public function render() { return view('livewire.admin.payments.quick-create', [
            'jobs' => $this->getjobsList(),
        ]); }

    public function store(CreatePaymentAction $action)
    {
        $this->validate();
        $dto = PaymentDTO::fromArray([
            'job_id' => $this->job_id,
            'amount' => $this->amount,
            'method' => $this->method,
            'payment_date' => $this->payment_date,
        ]);
        $item = $action->execute($dto);
        $this->dispatch('payment-created', id: $item->id);
        $this->js("Livewire.dispatch('payment-created', { id: {$item->id} })");
        $this->dispatch('toast', message: __('payments.created'), type: 'success');
        $this->created = true;
        $this->createdId = $item->id;
        $this->createdLabel = (string) ($item->id ?? $item->id);
        $this->reset(['job_id', 'amount', 'method', 'payment_date']);
    }

    public function addAnother()
    {
        $this->created = false;
        $this->createdId = null;
        $this->createdLabel = '';
    }

    protected function rules(): array { return Payment::rules(); }
}