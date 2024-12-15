<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\IndexRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Image;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request)
    {
        $data = $request->validationData();
        //dd($data['page']);
        $posts = Post::paginate(5, '*', 'page', $data['page']);
        return PostResource::collection($posts);
    }
}
