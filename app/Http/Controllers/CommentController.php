<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // NOTE: metodos para el manejo de los comentarios

    public function save(Request $request){
        $user = Auth::user();
        
        // NOTE: Realizamos validaciones
        $request->validate([
            'image_id' => ['required', 'int'],
            'content' => ['required', 'string', 'max:255'],
        ]);

        $image_id = $request->input('image_id');
        $content = $request->input('content');

        // Creamos una instancia para guardar los datos
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;
        $comment->save();

        return redirect()->route('image.details',['id' => $image_id]);
    }

    public function delete($id){
        $user = Auth::user();
        $comment = Comment::find($id);
        if ($user && ($user->id == $comment->user_id || $user->id == $comment->image->user_id)) {
            $comment->delete();
            return redirect()->route('image.details',['id' => $comment->image->id]);
        }
    }

}
