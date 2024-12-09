<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Models\Image;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        
        $images = $data['images'];
        unset( $data['images']);
        $post = Post::firstOrCreate($data);
        foreach ($images as $image) {
            $name = md5(Carbon::now() . '_' . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension(); 
            $filePath =  Storage::disk('public')->putFileAs('/images', $image, $name);
        
        $previewName = 'prev_'. $name;
        Image::create([
            'path' => $filePath,
            'url' => url('/storage/' . $filePath),
            'preview_url' => url('/storage/images/' . $previewName),
            'post_id' => $post->id
        ]);
        
        $image = ImageManager::imagick()->read('storage/' . $filePath)->scale(120,100)
            ->save(storage_path('app/public/images/'.$previewName));
    }
        return response()->json(['message' => 'success']);
    }
}
