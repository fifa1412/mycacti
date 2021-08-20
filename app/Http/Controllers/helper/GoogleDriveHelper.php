<?php

namespace App\Http\Controllers\helper;
use Storage;
use Image;

use App\Http\Controllers\Controller;

class GoogleDriveHelper extends Controller{

    public static function uploadPlantImg($file, $filename){
        Storage::disk("gd-img")->putFileAs("", $file, $filename);
    }

    public static function uploadPlantThumbnailImg($file, $filename){
        $image = Image::make($file);
        $image->orientate();
        $image->resize(500, 500, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save(public_path('images/'.$filename));
        $saved_image_uri = $image->dirname.'/'.$image->basename; 
        Storage::disk("gd-thumbnail-img")->put($filename, file_get_contents($saved_image_uri));
        $image->destroy();
        unlink($saved_image_uri);
    }

    public static function getCloudFileList($folder){
        $return_data = array();
        $file_list = Storage::disk($folder)->allFiles();
        foreach($file_list as $file){
            $details = Storage::disk($folder)->getMetadata($file);
            $fname = $details['name'];
            $url = Storage::disk($folder)->url($file);
            $return_data[$fname] = $url;
        }
        return $return_data;
    }
} 