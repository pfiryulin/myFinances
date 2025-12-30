<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
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
    public function index() : View
    {
        $deposits = Deposit::where('user_id', Auth::id())->get();
        dump($deposits);
        return view('deposit.index', compact('deposits'));
    }

    /**
     * Create a new deposit
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) : RedirectResponse
    {
        $newDeposite = Deposit::create([
            'user_id' => Auth::id(),
            'name' => $request['name'],
            'amount' => $request['amount'],
            'comment' => $request['comment'],
        ]);
        return redirect()->route('deposit');
    }
}
