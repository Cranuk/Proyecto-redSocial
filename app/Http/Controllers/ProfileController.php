<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{

    /** 
     * Display all users registered in the web 
     */
    public function index($search = null){
        if (!empty($search)) {
            $users = User::where('nick','like','%'.$search.'%')
                            ->orWhere('name','like','%'.$search.'%')
                            ->orWhere('surname','like','%'.$search.'%')
                            ->orderBy('id','desc')
                            ->paginate(5);
        } else {
            $users = User::orderBy('id','desc')->paginate(5);
        }
        return view('profile.listUsers',[
            'users' => $users
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        // Manejo de la carga de la imagen
        if ($request->hasFile('image')) {
            // Elimina la imagen anterior si existe
            if ($user->image) {
                Storage::disk('public')->delete('instagramUsers/' . $user->image);
            }

            // Guarda la nueva imagen
            $image = $request->file('image');
            $uniqueImage = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('', $uniqueImage, 'instagramUsers');
            $user->image = $uniqueImage; // Guarda el nombre de la nueva imagen en la base de datos
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function myProfile(){
        $user = Auth::user();
        $image = Image::where('user_id', $user->id)
                ->orderBy('id', 'desc')
                ->paginate(5);
        return view('profile.profile', [
            'user' => $user,
            'images' => $image
        ]);
    }

    public function viewProfile($id){
        $user = User::find($id);
        $image = Image::where('user_id', $user->id)
                ->orderBy('id', 'desc')
                ->paginate(5);
        return view('profile.profile', [
            'user' => $user,
            'images' => $image
        ]);
    }
}
