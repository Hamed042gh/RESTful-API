<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index(): JsonResponse
    {
        $posts = Post::all();
        return response()
            ->json([
                'message' => 'all posts',
                'posts' => $posts
            ], 200);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $post = Post::create($request->validated());

        return response()
            ->json([
                'message' => 'post  created!',
                'post' => $post
            ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $post = Post::findOrfail($id);

        return response()
            ->json([
                'message' => 'post show',
                'post' => $post
            ], 200);
    }


    public function update(UpdatePostRequest $request, int $id): JsonResponse
    {

        $post = Post::findOrfail($id);
        $post->update($request->validated());

        return response()
            ->json([
                'message' => 'post updated!',
                'post' => $post
            ], 200);
    }


    public function destroy(int $id): JsonResponse
    {
        $post = Post::findOrfail($id);
        $post->delete();

        return response()
            ->json([
                'message' => 'post removed!'
            ], 200);
    }
}
