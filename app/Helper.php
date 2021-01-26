<?php


namespace App;


use Carbon\Carbon;

class Helper
{
    public static function getSubDomain(){
        return explode('.', $_SERVER['HTTP_HOST'])[0];
    }

    /**
     * store new image and delete old image in storage, save only name in database
     * return filename
     *
     * @param $old_img
     * @param $image
     * @param $base_path
     * @return string|null
     */
    public static function saveImage($old_img, $image, $base_path){
        if(!is_null($old_img)){
            $old_file_path = public_path('storage/'.$base_path.'/'.$old_img);
            if (file_exists($old_file_path) ){
                unlink($old_file_path);
            }
        }
        $filename=null;
        if(!is_null($image)){
            $time = Carbon::now()->format('Y-m-d-h-i-s');
            $filename = $time . uniqid() .'.'. pathinfo($image->getClientOriginalName(),PATHINFO_EXTENSION ) ;
            $image->storeAs($base_path.'/', $filename, 'public');
        }
        return $filename;
    }
}
