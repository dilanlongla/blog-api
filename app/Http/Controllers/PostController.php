<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use OpenApi\Annotations as OA;


// /**
//  * @OA\Tag(
//  *     name="Posts",
//  *     description="Operations related to posts"
//  * )
//  */
class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get all posts",
     *     tags={"Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="A list of posts",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 ref="#/components/schemas/Post"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Create a new post",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "content"},
     *             @OA\Property(property="title", type="string", example="My Post Title"),
     *             @OA\Property(property="content", type="string", example="This is the content of the post")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     security={{"BearerAuth": {}}}
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        return Post::create($request->all());
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Get a post by ID",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function show($id)
    {
        try {
            return Post::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     summary="Update an existing post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "content"},
     *             @OA\Property(property="title", type="string", example="Updated Post Title"),
     *             @OA\Property(property="content", type="string", example="This is the updated content of the post")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     security={{"BearerAuth": {}}}
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->update($request->all());
            return $post;
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Delete a post by ID",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Delete successful")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     ),
     *     security={{"BearerAuth": {}}}
     * )
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if ($post) {
            $post->delete();
            return response()->json(['message' => 'Delete successful'], 200);
        }

        return response()->json(['message' => 'Post not found'], 404);
    }
}
