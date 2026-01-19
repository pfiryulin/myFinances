<?php

namespace App\Http\Controllers;

use App\Base\BaseActions\FreeMoneyAction;
use App\Http\Resources\OperationResource;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\FreeMoney;
use App\Models\Operation;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
            return response(['message' => 'Operation not found',], 404);
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
    public function store(Request $request) : FreeMoney
    {
        $type = $request['type'];
        $freeMoney = FreeMoneyAction::getFreeMoney($request['userId']);
        if ($type == Type::EXPENDITURE || ($type == Type::DEPOSIT && $request['category'] == Deposit::TO_DEPOSIT))
        {
            if ($freeMoney < $request['summ'])
            {
                return redirect(route('index'));
            }
        }

        $o = Operation::register(
            $request['userId'],
            $request['category'],
            $type,
            $request['summ'],
            $request['comment']
        );;

        return FreeMoneyAction::updateAmount($o);
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
