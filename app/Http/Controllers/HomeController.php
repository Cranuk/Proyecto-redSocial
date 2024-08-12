<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Image;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');        
    }

    public function index(){ // ANCHOR: nos trae todas las imagenes publicadas en la web
        $images = Image::orderBy('id', 'desc')->paginate(5);
        $dataImage = [];
        foreach ($images as $image) {
            $dataImage[$image->id] = [
                'likes_count' => Helpers::countLikes($image->id),
                'comments_count' => Helpers::countComments($image->id),
                'hasYourLike' => Helpers::hasYourLike($image->id)
            ];
        }
        return view('home',[
            'images' => $images,
            'data' => $dataImage,
        ]);
    }
}
