<?php

namespace App\Livewire\Front;

use App\Models\BodyTypeDefault;
use App\Models\Material;
use Livewire\Component;

class Vehicle3dConfigurator extends Component
{
    public $selectedBodyTypeId = null;
    public $selectedMaterialId = null;

    public function mount($typeId = null): void
    {
        $this->selectedBodyTypeId = $typeId
            ?? BodyTypeDefault::query()
                ->whereNotNull('image_2d_path')
                ->value('id');

        $this->selectedMaterialId = Material::query()
            ->value('id');
    }

    public function getBodyTypesProperty()
    {
        return BodyTypeDefault::all();
    }

    public function getMaterialsProperty()
    {
        return Material::all();
    }

    public function getSelectedTypeProperty()
    {
        return BodyTypeDefault::query()->find($this->selectedBodyTypeId);
    }

    public function getSelectedMaterialProperty()
    {
        return Material::query()->find($this->selectedMaterialId);
    }

    public function selectType($id): void
    {
        $this->selectedBodyTypeId = $id;
    }

    public function selectMaterial($id): void
    {
        $material = Material::find($id);

        if (!$material) {
            return;
        }

        $this->selectedMaterialId = $material->id;
    }

    public function render()
    {
        return view('livewire.front.vehicle-3d-configurator');
    }
}
