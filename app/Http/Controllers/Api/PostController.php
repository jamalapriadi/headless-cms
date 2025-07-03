<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Support\Str;

/**
 * @OA\Tag(name="Posts")
 */
class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="List all posts",
     *     tags={"Posts"},
     *     @OA\Response(response=200, description="List of posts")
     * )
     */
    public function index()
    {
        return PostResource::collection(Post::with('categories', 'user')->paginate(15));
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Get a single post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id", in="path", required=true, @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Post found"),
     *     @OA\Response(response=404, description="Post not found")
     * )
     */
    public function show(Post $post)
    {
        return new PostResource($post->load('categories', 'user'));
    }
}
