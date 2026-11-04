<?php

namespace App\Livewire\Admin\Plans;

use App\Models\Plan;
use App\Domain\Plan\DTOs\PlanDTO;
use App\Domain\Plan\Actions\UpdatePlanAction;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Përditëso Planin')]
class Edit extends Component
{
    public Plan $plan;
    public string $name = '';
    public $price = 0;
    public $duration_months = 1;
    public $max_users = 5;
    public $max_cars = 100;
    public $max_jobs = 500;
    public bool $active = true;

    public function mount(Plan $plan)
    {
        $this->plan = $plan;
        $this->name = $plan->name;
        $this->price = $plan->price;
        $this->duration_months = $plan->duration_months;
        $this->max_users = $plan->max_users;
        $this->max_cars = $plan->max_cars;
        $this->max_jobs = $plan->max_jobs;
        $this->active = $plan->active;
    }

    public function save(UpdatePlanAction $action)
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
        ]);

        $dto = PlanDTO::fromArray([
            'name' => $this->name,
            'price' => $this->price,
            'duration_months' => $this->duration_months,
            'max_users' => $this->max_users,
            'max_cars' => $this->max_cars,
            'max_jobs' => $this->max_jobs,
            'active' => $this->active,
        ]);

        $action->execute($this->plan, $dto);
        $this->dispatch('toast', message: 'Plani u përditësua me sukses.', type: 'success');
        return redirect()->route('admin.plans.index');
    }

    public function render()
    {
        return view('livewire.admin.plans.edit')->layout('components.layouts.app');
    }
}
