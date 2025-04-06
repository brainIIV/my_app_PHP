<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $category = Category::create($data);
        return CategoryResource::make($category);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $exists = $category->products()->exists();
        if ($exists ==! true) {
            $category->delete();
            return response()->json(["message" => "The category is deleted"]);
        }
        else {
            return response()->json(["message" => "The category is assigned to the product"]);
        }
    }
}
