# 3D Vehicle Configurator (IKEA-style) Implementation Plan

This plan outlines the steps to implement a 3D visualization feature for vehicle models, allowing users to see how different materials/colors look on a specific car model.

## User Review Required

> [!IMPORTANT]
> To use the 3D visualizer, each `VehicleModel` must have a corresponding `.glb` (GLTF Binary) file. These can be generated using AI tools like **Meshy.ai**, **Luma AI**, or **CSM.ai** from images of the car.

## Proposed Changes

### Database & Models

#### [MODIFY] [add_3d_fields_to_vehicle_models_table.php](file:///C:/laragon/www/gemelligaragesite/database/migrations/2026_08_26_122606_add_3d_fields_to_vehicle_models_table.php)
- Add `model_3d_path` column to store the location of the GLB file.

#### [NEW] [add_3d_properties_to_materials_table.php](file:///C:/laragon/www/gemelligaragesite/database/migrations/2026_08_26_144000_add_3d_properties_to_materials_table.php)
- Add `hex_code`, `roughness`, and `metalness` to the `materials` table to support PBR (Physically Based Rendering) in the 3D viewer.

#### [MODIFY] [VehicleModel.php](file:///C:/laragon/www/gemelligaragesite/app/Models/VehicleModel.php)
- Add `model_3d_path` to fillable and validation rules.

#### [MODIFY] [Material.php](file:///C:/laragon/www/gemelligaragesite/app/Models/Material.php)
- Add 3D properties to fillable and validation rules.

---

### UI Components

#### [NEW] [Vehicle3dConfigurator.php](file:///C:/laragon/www/gemelligaragesite/app/Livewire/Front/Vehicle3dConfigurator.php)
- Livewire component to manage the state of the 3D viewer (selected model, selected material).

#### [NEW] [vehicle-3d-configurator.blade.php](file:///C:/laragon/www/gemelligaragesite/resources/views/livewire/front/vehicle-3d-configurator.blade.php)
- Blade view using Google's `<model-viewer>` library for high-performance, easy-to-use 3D rendering in the browser.

## Verification Plan

### Automated Tests
- N/A (UI focused)

### Manual Verification
1. Upload a `.glb` car model to a test `VehicleModel`.
2. Assign a `hex_code` to a `Material`.
3. Open the Configurator page.
4. Select the car and click on the material.
5. Verify that the car's color changes in the 3D viewer.
