<?php

namespace App\Http\Controllers;

use App\Actions\OperationCreateAction;
use App\Actions\Operations\GetOperationAction;
use App\Http\Requests\OperationRequest;
use App\Http\Resources\Operations\OperationResource;
use App\Models\Operation;
use App\Services\Operations\OperationCreateService;
use App\Services\Operations\OperationDeleteService;
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

        $arrResult = OperationCreateService::storeOperationHandler($fields);

        return $arrResult;
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id) : OperationResource|Response
    {
        $operation = GetOperationAction::getOperation($id);
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
        // 1. Валидировать запрос на право обновления данных
        // 2. Валидировать данные для операции.
        // 3. Если меняется сумма произвести пересчет свободных средств в обратную сторону (вычесть суммы операции
        // или прибавить сумму операции)
        //   3.1 Сохранить старую сумму
        //   3.2. После успешного обновления записи пересчитать свободные средства
        // 4. Обновить свободные средства.
        // 5. Вернутьо операцию, свободные средства, обновленный баланс
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : array|Response
    {

        $operation = GetOperationAction::getOperation($id);

        if(!$operation)
        {
            return response(['message' => 'Operation not found',], 404);
        }

        //todo дописать проверку на error и возвращать с кодом, если ошибка есть
        return OperationDeleteService::handle($operation);
    }
}
