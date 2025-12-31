<?php

namespace App\Http\Controllers;

use App\Base\BaseActions\FreeMoneyAction;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\FreeMoney;
use App\Models\Operation;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $opertaions = Operation::where('user_id', Auth::id())
                               ->with([
                                   'category',
                                   'type',
                               ])
                               ->get();

        $categories = Category::userCategories(Auth::id())->get();
        $types = Type::all();

        $freeMoney = FreeMoneyAction::getFreeMoney(Auth::id());
        dump($freeMoney);

        return view('operations.index', compact('opertaions', 'categories', 'freeMoney', 'types'));
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
    public function store(Request $request) : RedirectResponse
    {

        $type = $request['type'];
        $freeMoney = FreeMoneyAction::getFreeMoney(Auth::id());
        if($type == Type::EXPENDITURE || ($type == Type::DEPOSIT && $request['category'] == Deposit::TO_DEPOSIT))
        {
            if($freeMoney < $request['summ'])
            {
                return redirect(route('index'));
            }
        }

        $o = Operation::register(Auth::id(), $request['category'], $type, $request['summ'], $request['comment']);

        FreeMoneyAction::updateAmount($o);

        return redirect(route('operation'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
