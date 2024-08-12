<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image' => ['required', 'image', 'max:2048'], // NOTE: valicacion a la imagen
        ]);

        // NOTE: Realizamos el proceso para que guardar la imagen en la web
        $image = $request->file('image'); // NOTE: capturamos la imagen
        if ($image) { 
            $uniqueImage = time().'.'.$image->getClientOriginalExtension(); // NOTE: Le creamos un nombre unico a la imagen cargada
            $image->storeAs('', $uniqueImage, 'instagramUsers'); // NOTE: almacenamos la imagen en el directorio indicado y con el nuevo nombre y como sera llamada en nuestra web
        }

        $user = User::create([
            'role' => 'user',
            'name' => $request->name,
            'surname' => $request->surname,
            'nick' => $request->nick,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $uniqueImage ?? null // NOTE: en el caso de no haber subido nada no mostraria ningun error
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
