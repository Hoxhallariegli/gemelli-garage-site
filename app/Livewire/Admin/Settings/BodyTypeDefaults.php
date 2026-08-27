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

    public function save($id)
    {
        $this->validate([
            'uploads2d.' . $id => 'required|image|max:10240', // 10MB limit
        ]);

        $item = BodyTypeDefault::findOrFail($id);
        $file = $this->uploads2d[$id];

        // 1. Create target directory if not exists
        $targetDir = public_path('vehicle_assets');
        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        // 2. Generate clean name
        $extension = $file->getClientOriginalExtension();
        $cleanName = Str::slug($item->body_type) . '-' . time() . '.' . $extension;
        $targetPath = $targetDir . '/' . $cleanName;

        // 3. Move file manually to public folder
        try {
            // Remove old file if exists in public
            if ($item->image_2d_path && File::exists(public_path($item->image_2d_path))) {
                File::delete(public_path($item->image_2d_path));
            }

            File::copy($file->getRealPath(), $targetPath);
            $path = 'vehicle_assets/' . $cleanName;

            $item->update([
                'image_2d_path' => $path
            ]);

            $this->dispatch('toast', message: "Imazhi u ruajt direkt në public!", type: 'success');
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
