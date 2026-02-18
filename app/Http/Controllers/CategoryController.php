<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Categories\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : AnonymousResourceCollection|Response
    {
        $categories = Category::userCategories(Auth::user()->id)->get();

        if($categories->isEmpty())
        {
            return response(['message' => 'categories not found',], Response::HTTP_NOT_FOUND);
        }

        return CategoryResource::collection($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create([
            'name' => $request->name,
            'type_id' => $request->type,
            'user_id' => Auth::user()->id,
        ]);

        $category->load('type');

        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : CategoryResource|Response
    {
        $userId = Auth::user()->id;

        $category = Category::categoryItem($id, $userId)
                            ->with('type')
                            ->get()->first();
        if(!$category)
        {
            return response(['message' => 'Category not found',], Response::HTTP_NOT_FOUND);
        }

        return new CategoryResource($category);
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
//        $category = Category::;
    }
}
