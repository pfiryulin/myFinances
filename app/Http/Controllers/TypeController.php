<?php

namespace App\Http\Controllers;

use App\Actions\Types\TypeGetAction;
use App\Http\Resources\TypeResource;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : Response|AnonymousResourceCollection
    {
        try
        {
            $types = TypeGetAction::getType();
            return TypeResource::collection($types);
        }
        catch(\Exception $e)
        {
            return response(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function allList() : Response|AnonymousResourceCollection
    {
        try
        {
            $types = TypeGetAction::getAllType();
            return TypeResource::collection($types);
        }
        catch(\Exception $e)
        {
            return response(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
    public function store(Request $request)
    {
        //
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
