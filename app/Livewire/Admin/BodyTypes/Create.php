<?php

namespace App\Livewire\Admin\BodyTypes;

use App\Models\BodyType;
use App\Domain\BodyType\DTOs\BodyTypeDTO;
use App\Domain\BodyType\Actions\CreateBodyTypeAction;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

#[Title('Add BodyType')]
class Create extends Component
{
    use WithFileUploads;

    public $name = '';
    public $wrap_meters = '';
    public $image;

    public function render()
    {
        abort_if_cannot('add_body_types');
        return view('livewire.admin.body-types.create')->layout('components.layouts.app');
    }

    public function store(CreateBodyTypeAction $action, \App\Services\ImageUploadService $uploadService)
    {
        $this->validate();

        $path = $uploadService->upload($this->image, 'vehicle_assets');

        $dto = BodyTypeDTO::fromArray([
            'name' => $this->name,
            'wrap_meters' => $this->wrap_meters,
            'image' => $path,
        ]);

        $action->execute($dto);
        session()->flash('success', __('body-types.created'));
        return to_route('admin.body-types.index');
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
