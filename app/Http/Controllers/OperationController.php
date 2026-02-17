<?php

namespace App\Http\Controllers;

use App\Actions\OperationCreateAction;
use App\Actions\Operations\GetOperationAction;
use App\Http\Requests\OperationRequest;
use App\Http\Resources\Operations\OperationResource;
use App\Models\Operation;
use App\Services\Operations\OperationCreateService;
use App\Services\Operations\OperationDeleteService;
use App\Services\Operations\OperationUpdateService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : AnonymousResourceCollection|Response
    {

        //todo Дописать фильтрацию и сортировку операций.
        $operations = Operation::where('user_id', auth()->user()->id)->with([
                'category',
                'type',
            ])->get();

        if($operations->isEmpty())
        {
            return response(['message' => 'Operations not found',], Response::HTTP_NOT_FOUND);
        }

        return OperationResource::collection($operations);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OperationRequest $request) : array
    {

        $fields = $request->all();
        $fields['userId'] = auth()->user()->id;

        return OperationCreateService::handle($fields);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id) : OperationResource|Response
    {
        $operation = GetOperationAction::getOperation($id);
        if(!$operation)
        {
            return response(['message' => 'Operation not found',], Response::HTTP_NOT_FOUND);
        }

        return new OperationResource($operation);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request) : array|Response
    {
        //todo дописать валидацию запроса. Проверять права на данную запись у пользователя.
        $operation = GetOperationAction::getOperation($request['id']);

        if(!$operation)
        {
            return response(['message' => 'Operation not found',], Response::HTTP_NOT_FOUND);
        }

        return OperationDeleteService::handle($operation);
    }

    public function update(Request $request)
    {
        $operation = GetOperationAction::getOperation($request['id']);

        if(!$operation)
        {
            return response(['message' => 'Operation not found',], Response::HTTP_NOT_FOUND);
        }

        return OperationUpdateService::handle($request, $operation );
        //todo
        // Проверять изменение суммы
        // Проверять изменение депозита
        // При изменении суммы пересчитывать связанные сущности.
        //
    }
}
