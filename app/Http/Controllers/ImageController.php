<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // TODO: Controlador encargado de la creacion y subida de imagenes en la web

    public function __construct(){
        $this->middleware('auth');
    }

    public function create(){
        return view('image.create');
    }

    public function save(Request $request){
        $user = Auth::user();

        // NOTE: Realizamos validaciones
        $request->validate([
            'image' => ['required', 'image', 'max:2048'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        try{
            $description = $request->input('description');
            // Manejo de la carga de la imagen
            if ($request->hasFile('image')) {
                // Guarda la nueva imagen
                $imageUpload = $request->file('image');
                $uniqueImage = time() . '.' . $imageUpload->getClientOriginalExtension();
                $imageUpload->storeAs('', $uniqueImage, 'instagramPosts');
                $imageSave = $uniqueImage; // Guarda el nombre de la nueva imagen en la base de datos
            }
            
            // Crear una nueva instancia del modelo Image y guardarla
            $image = new Image();
            $image->user_id = $user->id;
            $image->image_path = $imageSave;
            $image->description = $description;
            $image->save();

            return redirect()->route('home')
            ->with('status', 'Imagen posteada correctamente');
        } catch (\Exception $e) {
            return redirect()->route('home')
            ->with('error', 'Hubo un problema con la operación: ' . $e->getMessage());
        }
    }

    public function details($id){
        $image = Image::find($id); // NOTE: me trae los datos de la imagen
        $comments = Comment::where('image_id', '=', $image->id)->orderBy('id','desc')->get(); // NOTE: me trae los comentarios que esten relacionados con la imagen
        $hasYourLike = Helpers::hasYourLike($image->id);
        return view('image.details',[
            'image' => $image,
            'comments' => $comments,
            'dataImage' => $hasYourLike,
        ]);
    }

    public function edit($id){
        $user = Auth::user();
        $image = Image::find($id);
        if($user && $image && $image->user_id == $user->id){
            return view('image.edit',[
                'image' => $image
            ]);
        }else{
            return redirect('home');
        }
    }

    public function update(Request $request){
        $request->validate([
            'image' => [ 'image', 'max:2048'],
            'description' => ['required', 'string', 'max:255'],
        ]);
        
        try{
            $id = $request->input('id'); // NOTE: hace referencia al id de la imagen
            $description = $request->input('description');
            $image = Image::find($id);
            // Manejo de la carga de la imagen
            if ($request->hasFile('image')) {
                // Elimino la imagen anterior publicada
                if ($image->image_path) {
                    Storage::disk('public')->delete('instagramPosts/' . $image->image_path);
                }
                // Guarda la nueva imagen
                $imageUpload = $request->file('image');
                $uniqueImage = time() . '.' . $imageUpload->getClientOriginalExtension();
                $imageUpload->storeAs('', $uniqueImage, 'instagramPosts');
                $imageSave = $uniqueImage; // Guarda el nombre de la nueva imagen en la base de datos
            }
            
            $image->image_path = $imageSave;
            $image->description = $description;
            $image->update();

            return redirect()->route('home')
            ->with('status', 'Imagen actualizada correctamente');
        } catch (\Exception $e) {
            return redirect()->route('home')
            ->with('error', 'Hubo un problema con la operación: ' . $e->getMessage());
        }
    }

    public function delete($id){
        try {
            $user = Auth::user();
            $image = Image::find($id);
            $comments = Comment::where('image_id', '=', $image->id)->get();
            $likes = Like::where('image_id', '=', $image->id)->get();
            if ($user && $user->id == $image->user_id) {
                if ($comments && count($comments) >= 1) { // ANCHOR: eliminar los comentarios de la imagen borrada
                    foreach ($comments as $comment) {
                        $comment->delete();
                    }
                }
                if ($likes && count($likes) >= 1) { // ANCHOR: eliminar los likes de la imagen borrada
                    foreach ($likes as $like) {
                        $like->delete();
                    }
                }
                Storage::disk('public')->delete('instagramPosts/' . $image->image_path); // ANCHOR: eliminar la imagen del server
                $image->delete(); // ANCHOR: eliminar la imagen
                return redirect()->route('home')
                ->with('status', 'Imagen borrada con exito');
            }
        } catch (\Exception $e) {
            return redirect()->route('home')
            ->with('error', 'Hubo un problema con la operación: ' . $e->getMessage());
        }
    }
}

