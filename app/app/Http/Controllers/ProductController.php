<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }

    public function showByName(string $name)
    {
        $products = Product::select()->where('name','like', '%' . $name. '%')->get();
        return ProductResource::collection($products);
    }

    public function showByNameCategory(string $name)
    {
        $categories = Category::select()->where('name','like', '%' . $name. '%')->with('products')->get();
        return ProductResource::collection($categories->pluck('products')->flatten());

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $product = Product::create($data);
        $categories = $data['categories'];
        foreach ($categories as $categoryName) {
            $category = Category::select()->where('name', $categoryName)->first();
            $product->categories()->attach($category);
        }
        return  ProductResource::make($product);

    }

    public function showInCategory(Category $category)
    {
        return CategoryResource::collection($category->products);
    }

    public function showInPriceRange(int $min, int $max)
    {
        $products = Product::select()->whereBetween('price',[$min,$max])->get();
        return ProductResource::collection($products);
    }

    public function showNotDeleted()
    {
        $products = Product::select()->where('is_deleted',false)->get();
        return ProductResource::collection($products);
    }

    public function showPublished(string $published)
    {
        if($published === 'false' || $published === 'off' || $published === '0' ){
            $published = false;
        } else {
            $published = true;
        }
        $products = Product::select()->where('is_published', $published)->get();
        return ProductResource::collection($products);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $date = $request->validated();
        $product->fill($date);
        $product->save();
        return ProductResource::make($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->is_deleted = true;
        $product->save();
        return response()->json(["message" => "The product is marked as deleted"]);
    }
}
