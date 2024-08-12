<?php 
namespace App\Helpers;

use App\Models\Comment;
use App\Models\Like;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Helpers
{
    // TODO: aquí estarán los métodos que se usarán en toda la web, revisar igual si funciona como corresponde

    // NOTE: función para las fechas
    public static function formatDate($date){
        $now = Carbon::now(); // NOTE: fecha actual para realizar la diferencia de tiempo
        $differenceDate = $date->locale('es')->diffForHumans($now); // NOTE: Devuelve una cadena legible de tiempo transcurrido entre fechas
        return $differenceDate;
    }

    public static function countComments($image_id){ // NOTE: cuenta la cantidad de comentarios que tenga esa imagen
        $total = Comment::where('image_id' , '=' ,$image_id)->count();
        return $total;
    }

    public static function countLikes($image_id){ // NOTE: cuenta la cantidad de like tenga la imagen
        $total = Like::where('image_id', '=', $image_id)->count();
        return $total;
    }

    public static function hasYourLike($image_id){ // NOTE: verifica si tiene like la imagen de un usuario
        $user = Auth::user();
        $hasLike = Like::where('image_id', '=', $image_id)
                        ->where('user_id', '=', $user->id)
                        ->exists();
        return $hasLike;
    }
}
