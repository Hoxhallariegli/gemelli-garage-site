<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Domain\Job\DTOs\JobDTO;
use App\Domain\Job\Actions\CreateJobAction;
use App\Domain\Job\Actions\UpdateJobAction;

class JobController extends Controller
{
    public function index()
    {
        abort_if_cannot('view_jobs');
        $items = Job::query()->with(['car', 'service'])->latest()->paginate(50);
        return response()->json($items);
    }

    public function store(Request $request, CreateJobAction $action)
    {
        abort_if_cannot('add_jobs');
        $data = $request->all();
        $dto = JobDTO::fromArray($data);
        $item = $action->execute($dto);
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function update(Request $request, $id, UpdateJobAction $action)
    {
        abort_if_cannot('edit_jobs');
        $item = Job::findOrFail($id);
        $data = $request->all();
        $dto = JobDTO::fromArray($data);
        $item = $action->execute($item, $dto);
        return response()->json(['success' => true, 'data' => $item]);
    }

    public function destroy($id)
    {
        abort_if_cannot('delete_jobs');
        try {
            $item = Job::findOrFail($id);
            $item->delete();
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Ky rekord është i lidhur me të dhëna të tjera.'], 400);
        }
    }
}
