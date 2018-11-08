<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;


class PostApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return PostResource::collection(Post::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return PostResource
     */
    public function store(Request $request): PostResource
    {
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user_id,
        ]);

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return PostResource
     */
    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return PostResource
     */
    public function update(Request $request, Post $post): PostResource
    {
        $post->update($request->only(['title', 'user_id', 'content']));

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        $post->delete();

        return response()->json(null, 204);
    }
}
