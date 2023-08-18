<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public static function GetImageUrl($imageId){
        try {
            $image = Image::where('id', $imageId)->get()->first();
            return 'http://192.168.1.89:8000/'.$image->file_name;

        } catch (\Throwable $th) {
            return null;
        }
    }
}
