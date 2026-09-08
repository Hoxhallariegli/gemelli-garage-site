<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\JobRequest;
use Illuminate\Http\Request;
use App\Domain\JobRequest\Queries\JobRequestListQuery;
use App\Domain\JobRequest\DTOs\JobRequestDTO;
use App\Domain\JobRequest\Actions\CreateJobRequestAction;
use App\Domain\JobRequest\Actions\UpdateJobRequestAction;
use App\Domain\JobRequest\Actions\DeleteJobRequestAction;


class JobRequestController extends Controller
{
    
    public function index(Request $request, JobRequestListQuery $query)
    {
        abort_if_cannot('view_job_requests');
        $items = $query->execute($request);
        $items->getCollection()->transform(fn($i) => $this->transformItem($i));
        return response()->json($items);
    }
    
    public function store(Request $request, CreateJobRequestAction $action)
    {
        abort_if_cannot('add_job_requests');
        $data = $this->prepareData($request);
        $dto = JobRequestDTO::fromArray($data);
        $item = $action->execute($dto);
        return response()->json(['success' => true, 'data' => $this->transformItem($item)]);
    }
    
    public function update(Request $request, $id, UpdateJobRequestAction $action)
    {
        abort_if_cannot('edit_job_requests');
        $item = JobRequest::findOrFail($id);
        $data = $this->prepareData($request);
        $dto = JobRequestDTO::fromArray($data);
        $item = $action->execute($item, $dto);
        return response()->json(['success' => true, 'data' => $this->transformItem($item)]);
    }

    
    public function destroy($id, DeleteJobRequestAction $action)
    {
        abort_if_cannot('delete_job_requests');
        try {
            $item = JobRequest::findOrFail($id);
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