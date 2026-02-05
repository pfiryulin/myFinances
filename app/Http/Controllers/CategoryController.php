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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : CategoryResource|Response
    {
        $userId = Auth::user()->id;

        $category = Category::where('id', $id)
                            ->where(function($query) use($userId) {
                                $query->where('user_id', $userId)->orWhereNull('user_id');
                            })->first();
        if(!$category)
        {
            return response(['message' => 'Category not found',], Response::HTTP_NOT_FOUND);
        }

        return CategoryResource::make($category);
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
