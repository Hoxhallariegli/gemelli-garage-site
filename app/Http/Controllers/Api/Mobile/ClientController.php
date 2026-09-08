<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Domain\Client\Queries\ClientListQuery;
use App\Domain\Client\DTOs\ClientDTO;
use App\Domain\Client\Actions\CreateClientAction;
use App\Domain\Client\Actions\UpdateClientAction;
use App\Domain\Client\Actions\DeleteClientAction;


class ClientController extends Controller
{
    
    public function index(Request $request, ClientListQuery $query)
    {
        abort_if_cannot('view_clients');
        $items = $query->execute($request);
        $items->getCollection()->transform(fn($i) => $this->transformItem($i));
        return response()->json($items);
    }
    
    public function store(Request $request, CreateClientAction $action)
    {
        abort_if_cannot('add_clients');
        $data = $this->prepareData($request);
        $dto = ClientDTO::fromArray($data);
        $item = $action->execute($dto);
        return response()->json(['success' => true, 'data' => $this->transformItem($item)]);
    }
    
    public function update(Request $request, $id, UpdateClientAction $action)
    {
        abort_if_cannot('edit_clients');
        $item = Client::findOrFail($id);
        $data = $this->prepareData($request);
        $dto = ClientDTO::fromArray($data);
        $item = $action->execute($item, $dto);
        return response()->json(['success' => true, 'data' => $this->transformItem($item)]);
    }

    
    public function destroy($id, DeleteClientAction $action)
    {
        abort_if_cannot('delete_clients');
        try {
            $item = Client::findOrFail($id);
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