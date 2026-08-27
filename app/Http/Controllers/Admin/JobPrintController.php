<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class JobPrintController extends Controller
{
    public function show(Request $request, Job $job)
    {
        if ($request->has('lang')) {
            app()->setLocale($request->lang);
        }

        $job->load(['car.client', 'car.brand', 'car.model.bodyType', 'services.service', 'materials.material', 'parts.part', 'payments']);

        return view('admin.jobs.print', [
            'job' => $job,
            'isPublic' => false
        ]);
    }

    public function publicShow(Request $request, $token)
    {
        if ($request->has('lang')) {
            app()->setLocale($request->lang);
        }

        $job = Job::where('public_token', $token)
            ->with(['car.client', 'car.brand', 'car.model.bodyType', 'services.service', 'materials.material', 'parts.part', 'payments'])
            ->firstOrFail();

        return view('admin.jobs.print', [
            'job' => $job,
            'isPublic' => true
        ]);
    }

    public function previewImage($token)
    {
        $job = Job::where('public_token', $token)->firstOrFail();
        $bodyType = $job->car?->model?->bodyType;

        $manager = new ImageManager(new Driver());

        // Krijojmë një canvas të bardhë 1200x630 (standard për OG Image)
        $canvas = $manager->create(1200, 630)->fill('ffffff');

        // Shtojmë logon e kompanisë në cep
        $logoPath = public_path('assets/front/gemelli-garage/images/logo-gemelli.png');
        if (file_exists($logoPath)) {
            $logo = $manager->read($logoPath);
            $logo->scale(height: 80);
            $canvas->place($logo, 'top-left', 60, 50);
        }

        // Shtojmë imazhin e mjetit në qendër
        if ($bodyType && $bodyType->image) {
            $carPath = public_path($bodyType->image);
            if (file_exists($carPath)) {
                $car = $manager->read($carPath);
                $car->scale(height: 380);
                $canvas->place($car, 'center', 0, 40);
            }
        }

        return response($canvas->encodeByExtension('jpg', 85)->toString())
            ->header('Content-Type', 'image/jpeg');
    }
}
