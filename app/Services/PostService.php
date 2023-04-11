<?php


namespace App\Services;


use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class PostService extends BaseService
{

    public function getModel()
    {
        return new Post();
    }

    public function all($orderBy)
    {
        $orderBy = $orderBy ?? config('app.orderBy');

        return $this->model->where('user_id', Auth::id())->orderBy($orderBy, 'desc')->get();
    }

    public function storePost(array $data )
    {
        return DB::transaction(function () use ($data) {

            //create new image
            $image = app()->make(StorageFileService::class)->putFileInStorage($data['image'], 'public/images');
            $imageName = basename($image);

            $post = $this->model->create([
                'description' => $data['description'],
                'image' => $imageName,
                'user_id' => Auth::user()->id,
            ]);

            if ($post) {
                //trigger event
                return $post;
            }

            throw new Exception(__('There was a problem creating post.'));
        });
    }

    public function updatePost($data, $id)
    {
        return DB::transaction(function () use ($id, $data) {
            $post = $this->find($id);
            Gate::authorize('edit-post', $post);

            if (isset($data['image'])) {
                //create new image and delete the old one
                $old_image = $post->image;
                $image = app()->make(StorageFileService::class)->putFileInStorage($data['image'], 'public/images');
                $imageName = basename($image);
            }

            $updatedPost = $post->update([
                'description' => $data['description'] ?? $post->description,
                'image' => $imageName ?? $post->image,
            ]);

            if ($updatedPost) {
                if (isset($data['image'])) {
                    app()->make(StorageFileService::class)->deleteFileFromStorage('public/images/' . $old_image);
                }

                return $post->refresh();
            }

            throw new Exception(__('There was a problem updating post.'));
        });
    }

    public function deletePost($id)
    {
        return DB::transaction(function () use ($id) {
            $post = $this->find($id);
            Gate::authorize('edit-post', $post);
            $post->delete();
            app()->make(StorageFileService::class)->deleteFileFromStorage('public/images/' . $post->image);
            return true;
        });
    }


}
