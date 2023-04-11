<?php

namespace App\Services;

use Illuminate\Support\Facades\Gate;

abstract class BaseService
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->getModel();
    }

    public function find($id, $relations = [])
    {
        $post = $this->model->with($relations)->find($id);
        Gate::authorize('edit-post',$post);
        return $post;

    }

    public function get()
    {
        return $this->model->all();
    }
}
