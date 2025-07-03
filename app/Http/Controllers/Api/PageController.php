<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\PageResource;
use App\Models\Page;
use Illuminate\Support\Str;

/**
 * @OA\Tag(name="Pages")
 */
class PageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pages",
     *     summary="List all pages",
     *     tags={"Pages"},
     *     @OA\Response(response=200, description="List of pages")
     * )
     */
    public function index()
    {
        return PageResource::collection(Page::with('user')->get());
    }

    /**
     * @OA\Get(
     *     path="/api/pages/{id}",
     *     summary="Get a single page",
     *     tags={"Pages"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Page found"),
     *     @OA\Response(response=404, description="Page not found")
     * )
     */
    public function show(Page $page)
    {
        return new PageResource($page->load('user'));
    }
}
