<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

use Illuminate\Support\Str;


/**
 * @OA\Tag(name="Categories")
 */
class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="List all categories",
     *     tags={"Categories"},
     *     @OA\Response(response=200, description="List of categories")
     * )
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{id}",
     *     summary="Get a single category",
     *     tags={"Categories"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Category found"),
     *     @OA\Response(response=404, description="Category not found")
     * )
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }
}
