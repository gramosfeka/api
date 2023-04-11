<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderByRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(OrderByRequest $request)
    {
        try{
            $posts = $this->postService->all($request->orderBy);
        } catch (\Exception $exception){

            return $this->errorResponse($exception);
        }

        return new PostCollection($posts);
    }

    public function store(StorePostRequest $request){
        try{
           $post = $this->postService->storePost($request->validated());
        } catch (\Exception $exception){

            return $this->errorResponse($exception);
        }

        return new PostResource($post);
    }


    public function show($id)
    {
        try{
            $post = $this->postService->find($id);
        } catch (\Exception $exception){

            return $this->errorResponse($exception);
        }

        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        try{
            $post = $this->postService->updatePost($request->validated(), $id);
        } catch (\Exception $exception){

            return $this->errorResponse($exception);
        }
        return new PostResource($post);

    }

    public function destroy($id)
    {
        try{
            $this->postService->deletePost($id);
        } catch (\Exception $exception){

            return $this->errorResponse($exception);
        }
        return response()->json([
            'type' => 'success',
            'message' => 'Post deleted successfully'
        ]);
    }
}
