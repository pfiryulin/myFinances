<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Operation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

        return view('operations.index', compact('opertaions', 'categories'));
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
        $o = Operation::create([
            'user_id' => Auth::id(),
            'category_id' => $request['category'],
            'type_id' => Category::find($request['category'])->type_id,
            'summ' => $request['summ'],
            'comment' => $request['comment'],
        ]);



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
