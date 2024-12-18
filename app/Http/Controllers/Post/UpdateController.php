<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Image;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Post $post)
    {
        $data = $request->validated();
        
        $images = isset($data['images']) ? $data['images'] : null;
        $imageIdsForDelete = isset($data['image_ids_for_delete']) ? $data['image_ids_for_delete'] : null;
        $imageUrlsForDelete = isset($data['image_urls_for_delete']) ? $data['image_urls_for_delete'] : null;
        unset( $data['images'], $data['image_ids_for_delete'],$data['image_urls_for_delete']);

        $post->update($data);

        $currentImages = Image::all()->where('post_id','=',$post->id);
        //dd($currentImages);
        if ($imageIdsForDelete) {
        foreach ($currentImages as $currentImage) {
            if (in_array($currentImage->id, $imageIdsForDelete)) {
                Storage::disk('public')->delete($currentImage->path);
                Storage::disk('public')->delete(str_replace('images', 'images/prev_', $currentImage->path));
                $currentImage->delete();
            }
        }
        }

        if ($imageUrlsForDelete) {
            foreach ($imageUrlsForDelete as $imageUrlForDelete) {
                    $removeStr = $request->root() . "/storage/";
                    $path = str_replace($removeStr, '', $imageUrlForDelete);
                    Storage::disk('public')->delete($path);
            }
            }

        if ($images) {
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
    }
        return response()->json(['message' => 'success']);
    }
}
