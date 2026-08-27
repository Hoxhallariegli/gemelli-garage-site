<?php

namespace App\Livewire\Admin\Settings;

use App\Models\BodyTypeDefault;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

#[Title('Vizualizimi 2D')]
class BodyTypeDefaults extends Component
{
    use WithFileUploads;

    public $uploads2d = [];

    public function save($id, \App\Services\ImageUploadService $uploadService)
    {
        $this->validate([
            'uploads2d.' . $id => 'required|image|max:10240', // 10MB limit
        ]);

        $item = BodyTypeDefault::findOrFail($id);
        $file = $this->uploads2d[$id];

        try {
            // Remove old file
            if ($item->image_2d_path) {
                $uploadService->delete($item->image_2d_path);
            }

            // Upload and compress
            $path = $uploadService->upload($file, 'vehicle_assets');

            $item->update([
                'image_2d_path' => $path
            ]);

            $this->dispatch('toast', message: "Imazhi u kompresua dhe u ruajt!", type: 'success');
            $this->reset('uploads2d');
        } catch (\Exception $e) {
            $this->dispatch('toast', message: "Gabim: " . $e->getMessage(), type: 'error');
        }
    }

    public function delete($id)
    {
        $item = BodyTypeDefault::findOrFail($id);
        if ($item->image_2d_path) {
            $fullPath = public_path($item->image_2d_path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
            $item->update(['image_2d_path' => null]);
            $this->dispatch('toast', message: "Imazhi u fshi.", type: 'info');
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.body-type-defaults', [
            'items' => BodyTypeDefault::all()
        ])->layout('components.layouts.app');
    }
}
