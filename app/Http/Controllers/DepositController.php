<?php

namespace App\Http\Controllers;

use App\Actions\Deposits\DepositGetAction;
use App\Http\Resources\DepositeResource;
use App\Models\Deposit;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

//todo добавить функционал внесения процентов по вкладу. Это не должно влиять на свободные средства и должно
// отображаться в сумме депозита и общем балансе
class DepositController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index() : AnonymousResourceCollection|Response
    {
        $deposits = Deposit::where('user_id', Auth::id())->get();

        if($deposits->isEmpty())
        {
            return response(['message' => 'No Deposit Found'], Response::HTTP_NOT_FOUND);
        }

        return DepositeResource::collection($deposits);
    }

    /**
     * Create a new deposit
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) : DepositeResource
    {
        $newDeposit = Deposit::create([
            'user_id' => Auth::id(),
            'name'    => $request['name'],
            'amount'  => $request['amount'],
            'comment' => $request['comment'],
        ]);
       return new DepositeResource($newDeposit);
    }

    public function show(int $id) : DepositeResource|Response
    {
        try
        {
            $deposit = DepositGetAction::getDeposit($id);
            return new DepositeResource($deposit);
        }
        catch (\Exception $exception)
        {
            return response(['message' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, int $id) : DepositeResource|Response
    {
        try{
            $deposit = DepositGetAction::getDeposit($id);
            if($deposit->update($request->all()))
            {
                return new DepositeResource($deposit);
            }
            else{
                throw new \Exception("Unable to update Deposit");
            }
        }
        catch (\Exception $exception)
        {
            return response(['message' => $exception->getMessage()], $exception->getCode());
        }
    }
}
