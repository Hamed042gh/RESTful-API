<?php
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;


/**
 * @OA\Schema(
 *     schema="Post",
 *     required={"title", "content", "user_id"},
 *     @OA\Property(property="id", type="integer", format="int64", description="ID of the post"),
 *     @OA\Property(property="title", type="string", description="Title of the post"),
 *     @OA\Property(property="content", type="string", description="Content of the post"),
 *     @OA\Property(property="user_id", type="integer", description="ID of the user who created the post"),
 * )
 */

class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/posts",
     *     summary="Get all posts",
     *     description="Returns a list of all posts",
     *     operationId="getAllPosts",
     *     tags={"Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of posts",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Post")  
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $posts = Post::all();
        return response()
            ->json([
                'message' => 'all posts',
                'posts' => $posts
            ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/posts",
     *     summary="Create a new post",
     *     description="Create a new post with provided data",
     *     operationId="createPost",
     *     tags={"Post"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Post object that needs to be created",
     *         @OA\JsonContent(
     *             required={"title", "content", "user_id"},
     *             @OA\Property(property="title", type="string", example="New Post Title"),
     *             @OA\Property(property="content", type="string", example="New Post Content"),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post successfully created",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $post = Post::create($request->validated());

        return response()
            ->json(['message' => 'post created!',
                'post' => $post
            ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/posts/{id}",
     *     summary="Get a single post",
     *     description="Retrieve a post by its ID",
     *     operationId="getPostById",
     *     tags={"Post"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post to retrieve",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post found",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $post = Post::findOrFail($id);

        return response()
            ->json([
                'message' => 'post show',
                'post' => $post
            ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/posts/{id}",
     *     summary="Update an existing post",
     *     description="Update the details of an existing post by its ID",
     *     operationId="updatePost",
     *     tags={"Post"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated post object",
     *         @OA\JsonContent(
     *             required={"title", "content"},
     *             @OA\Property(property="title", type="string", example="Updated Post Title"),
     *             @OA\Property(property="content", type="string", example="Updated Post Content")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post successfully updated",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function update(UpdatePostRequest $request, int $id): JsonResponse
    {
        $post = Post::findOrFail($id);
        $post->update($request->validated());

        return response()
            ->json([
                'message' => 'post updated!',
                'post' => $post
            ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/posts/{id}",
     *     summary="Delete a post",
     *     description="Delete a post by its ID",
     *     operationId="deletePost",
     *     tags={"Post"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Post successfully deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(null, 204);
    }
}
