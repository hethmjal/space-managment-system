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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required','regex:/^((059)|(056))[0-9]{7}$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]); 

    
        if($request->file('image')){
            $filenameWithExt = $request->file('image')->getClientOriginalName ();
            $fileNameToStore = time(). '_'. $filenameWithExt;
            $file = $request->file('image');
         
            $path = $file->storeAs('/users',$fileNameToStore,[
                'disk'=>'uploads'
            ]);
        
            $request->merge(['image_path' => $path]);
        }

     
        $hasPassword = Hash::make($request->password);
        $request->merge(['password' => $hasPassword,'type'=>'user']);

        $user = User::create($request->all());
        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
