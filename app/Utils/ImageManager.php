<?php
namespace App\Utils;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageManager
{
    public static function uploadImages($request , $user=null)
    {
        if($request->hasFile('image')){
            self::deleteImageFromLocal($user->image);
            $path = self::storeImageInLocal($request->file('image') , 'users');
            $user->update([
                'image' => $path
            ]);
        }
    }

    public static function deleteImages($post){
        if($post->images->count() > 0){
            foreach($post->images as $image){
                self::deleteImageFromLocal($image->path);
                $image->delete();
            }
        }
    }

    public static function deleteImageFromLocal($path){
        if(File::exists(public_path($path))){
            File::delete(public_path($path));
        }
    }



    //private functions
    //seperated for clarity
    private static function generateImageName($file){
        return Str::uuid() . '-' . time() . '.' . $file->getClientOriginalExtension();
    }

    private static function storeImageInLocal($file , $path){
        $newName = self::generateImageName($file);
        $path = $file->storeAs('uploads/'.$path, $newName , ['disk' => 'uploads']);
        return $path;
    }


}
