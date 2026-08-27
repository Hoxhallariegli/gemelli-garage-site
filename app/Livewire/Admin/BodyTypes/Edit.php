<?php

namespace App\Livewire\Admin\BodyTypes;

use App\Models\BodyType;
use App\Domain\BodyType\DTOs\BodyTypeDTO;
use App\Domain\BodyType\Actions\UpdateBodyTypeAction;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

#[Title('Edit BodyType')]
class Edit extends Component
{
    use WithPagination, WithFileUploads;

    public BodyType $item;
    public $name = '';
    public $wrap_meters = '';
    public $image;

    public function mount(BodyType $bodyType)
    {
        $this->item = $bodyType;
        $this->name = $bodyType->name;
        $this->wrap_meters = $bodyType->wrap_meters;
    }

    public function render()
    {
        abort_if_cannot('edit_body_types');
        return view('livewire.admin.body-types.edit')->layout('components.layouts.app');
    }

    public function update(UpdateBodyTypeAction $action, \App\Services\ImageUploadService $uploadService)
    {
        $this->validate();

        $path = $this->item->image;
        if ($this->image && !is_string($this->image)) {
            $uploadService->delete($path);
            $path = $uploadService->upload($this->image, 'vehicle_assets');
        }

        $dto = BodyTypeDTO::fromArray([
            'name' => $this->name,
            'wrap_meters' => $this->wrap_meters,
            'image' => $path,
        ]);

        $action->execute($this->item, $dto);
        session()->flash('success', __('body-types.updated'));
        return to_route('admin.body-types.index');
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'wrap_meters' => 'required|numeric',
            'image' => $this->image && !is_string($this->image) ? 'image|max:5120' : 'nullable|string',
        ];
    }
}
