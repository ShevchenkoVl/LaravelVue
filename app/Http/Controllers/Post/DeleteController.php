<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeleteController extends Controller
{
    public function __invoke(Post $post)
    {
        $currentImages = Image::all()->where('post_id','=',$post->id);
        foreach ($currentImages as $currentImage) {
                Storage::disk('public')->delete($currentImage->path);
                Storage::disk('public')->delete(str_replace('images', 'images/prev_', $currentImage->path));
                $currentImage->delete();
        }
        $post->delete();
        return response([]);
    }
}
