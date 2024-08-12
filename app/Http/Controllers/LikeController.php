<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class LikeController extends Controller
{
    // TODO: Controlador encargado de revisar los 'like' o 'dislike' de los usuarios

    public function __construct(){
        $this->middleware('auth');
    }

    public function myLikes(){
        $user = Auth::user();
        $myLike = Like::with('image')
                    ->where('user_id', '=', $user->id)
                    ->orderBy('id', 'desc')
                    ->paginate(5);

        return view('like.list',[
            'myLikes' => $myLike,
            'user' => $user,
        ]);
    }

    public function like($image_id){
        $user = Auth::user();

        $hasLike = Like::where('image_id', '=', $image_id)
                        ->where('user_id', '=', $user->id)
                        ->count();

        if ($hasLike == 0) {
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = $image_id;
            $like->save();

            $likesCount = Helpers::countLikes($image_id);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Like added successfully',
                'likes' => $likesCount
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User already liked this image'
            ]);
        }
    }

    public function dislike($image_id){
        $user = Auth::user();

        $hasLike = Like::where('image_id', '=', $image_id)
                        ->where('user_id', '=', $user->id)
                        ->first();

        if ($hasLike) {
            $hasLike->delete();

            $likesCount = Helpers::countLikes($image_id);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Like drop successfully',
                'likes' => $likesCount
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User does not like this image'
            ]);
        }
    }
}

