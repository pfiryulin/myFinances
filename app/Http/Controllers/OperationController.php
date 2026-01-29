<?php

namespace App\Http\Controllers;

use App\Actions\OperationCreateAction;
use App\Http\Requests\StoreOperationRequest;
use App\Http\Resources\OperationResource;
use App\Models\Operation;
use App\Services\Operations\OperationServices;
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


        $operation = OperationServices::storeOperationHandler(
            auth()->user()->id,
            $request->categoryId,
            $request->typeId,
            $request->summ,
            ($request->comment) ?? null
        );




        dump(Auth::user()->id);
        dump(auth()->user()->id);
        dump($request);

//        $type = $request['type'];
//        $freeMoney = FreeMoneyAction::getFreeMoney($request['userId']);
//        if ($type == Type::EXPENDITURE || ($type == Type::DEPOSIT && $request['category'] == Deposit::TO_DEPOSIT))
//        {
//            if ($freeMoney < $request['summ'])
//            {
//                return redirect(route('index'));
//            }
//        }
//
//        $o = Operation::register(
//            $request['userId'],
//            $request['category'],
//            $type,
//            $request['summ'],
//            $request['comment']
//        );;
//
//        return FreeMoneyAction::updateAmount($o);
        return [];
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
