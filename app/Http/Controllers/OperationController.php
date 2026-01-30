<?php

namespace App\Http\Controllers;

use App\Actions\OperationCreateAction;
use App\Http\Requests\StoreOperationRequest;
use App\Http\Resources\OperationResource;
use App\Models\Operation;
use App\Services\Operations\OperationCreateService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : AnonymousResourceCollection|Response
    {
        $operations = Operation::where('user_id', auth()->user()->id)->with([
                'category',
                'type',
            ])->get();

        if($operations->isEmpty())
        {
            return response(['message' => 'Operations not found',], 404);
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
    public function store(StoreOperationRequest $request) : array
    {

        $fields = $request->all();
        $fields['userId'] = auth()->user()->id;

        $arrResult = OperationCreateService::storeOperationHandler($fields);

        return $arrResult;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : OperationResource|Response
    {
        $operation = Operation::find($id);
        if(!$operation)
        {
            return response(['message' => 'Operation not found',], 404);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //todo
        // 1. Валилировать запрос на право обновления данных
        // 2.
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
