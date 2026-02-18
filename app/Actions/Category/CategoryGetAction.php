<?php

namespace App\Actions\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryGetAction
{
    /**
     * @param string $id
     *
     * @return \App\Models\Category
     */
    public static function getCategory(string $id) : Category
    {
        $category = Category::categoryItem($id, Auth::user()->id)
                            ->with('type')
                            ->first();
        if(!$category)
        {
            throw new NotFoundHttpException('Categories not found');
        }
        return $category;
    }
}
