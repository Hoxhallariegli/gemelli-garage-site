<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Domain\Job\Queries\JobListQuery;
use App\Domain\Job\DTOs\JobDTO;
use App\Domain\Job\Actions\CreateJobAction;
use App\Domain\Job\Actions\UpdateJobAction;
use App\Domain\Job\Actions\DeleteJobAction;


class JobController extends Controller
{
    
    public function index(Request $request, JobListQuery $query)
    {
        abort_if_cannot('view_jobs');
        $items = $query->execute($request);
        $items->getCollection()->transform(fn($i) => $this->transformItem($i));
        return response()->json($items);
    }
    
    public function store(Request $request, CreateJobAction $action)
    {
        abort_if_cannot('add_jobs');
        $data = $this->prepareData($request);
        $dto = JobDTO::fromArray($data);
        $item = $action->execute($dto);
        return response()->json(['success' => true, 'data' => $this->transformItem($item)]);
    }
    
    public function update(Request $request, $id, UpdateJobAction $action)
    {
        abort_if_cannot('edit_jobs');
        $item = Job::findOrFail($id);
        $data = $this->prepareData($request);
        $dto = JobDTO::fromArray($data);
        $item = $action->execute($item, $dto);
        return response()->json(['success' => true, 'data' => $this->transformItem($item)]);
    }

    
    public function destroy($id, DeleteJobAction $action)
    {
        abort_if_cannot('delete_jobs');
        try {
            $item = Job::findOrFail($id);
            $action->execute($item);
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Ky rekord është i lidhur me të dhëna të tjera.'], 400);
        }
    }

    private function transformItem($item) {
        foreach (array (
) as $f) {
            $val = $item->getRawOriginal($f);
            $item->setAttribute("{$f}_raw", is_string($val) && str_starts_with($val, '{') ? json_decode($val, true) : $val);
        }
        return $item;
    }

    private function prepareData(Request $request) {
        $data = $request->all();
        foreach (array (
) as $f) {
            if (isset($data[$f]) && is_string($data[$f]) && str_starts_with($data[$f], '{')) $data[$f] = json_decode($data[$f], true);
        }
        // Mos e prek fushen e fotos/imazhit nese s'ka file te ri ne kete kerkese
        foreach (array (
) as $f) {
            if (!$request->hasFile($f)) {
                unset($data[$f]);
            }
        }
        return $data;
    }
}