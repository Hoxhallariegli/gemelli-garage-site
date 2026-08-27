<?php

namespace App\Livewire\Admin\BodyTypes;

use App\Models\BodyType;
use App\Domain\BodyType\DTOs\BodyTypeDTO;
use App\Domain\BodyType\Actions\CreateBodyTypeAction;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class QuickCreate extends Component
{
    use WithFileUploads;

    public $name = '';
    public $wrap_meters = '';
    public $image;

    public bool $created = false;
    public ?int $createdId = null;
    public string $createdLabel = '';

    public function render() { return view('livewire.admin.body-types.quick-create'); }

    public function store(CreateBodyTypeAction $action)
    {
        $this->validate();

        $path = null;
        if ($this->image) {
            $path = $this->image->store('body_types', 'public');
        }

        $dto = BodyTypeDTO::fromArray([
            'name' => $this->name,
            'wrap_meters' => $this->wrap_meters,
            'image' => $path,
        ]);

        $item = $action->execute($dto);
        $this->dispatch('body-type-created', id: $item->id);
        $this->dispatch('toast', message: __('body-types.created'), type: 'success');

        $this->created = true;
        $this->createdId = $item->id;
        $this->createdLabel = $item->name;
        $this->reset(['name', 'wrap_meters', 'image']);
    }

    public function addAnother()
    {
        $this->created = false;
        $this->createdId = null;
        $this->createdLabel = '';
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'wrap_meters' => 'required|numeric',
            'image' => 'nullable|image|max:5120',
        ];
    }
}
