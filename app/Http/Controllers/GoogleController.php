<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        if ($request->has('type')) {
            session(['google_user_type' => $request->type]);
        }
        
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Buscar usuario existente
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Obtener el tipo de usuario
                $userType = session('google_user_type', 'unemployed');
                
                // CREAR SOLO EL USUARIO, NO el perfil específico
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(24)),
                    'type' => $userType,
                    'email_verified_at' => now(),
                ]);

                // NO crear unemployed o company aquí
                // Eso lo harán los controladores específicos

                session()->forget('google_user_type');

            } else {
                // Usuario existente - actualizar tipo si es necesario
                if (!$user->type && session()->has('google_user_type')) {
                    $user->update([
                        'type' => session('google_user_type')
                    ]);
                }
                session()->forget('google_user_type');
            }

            Auth::login($user);

            // Redirigir al formulario correspondiente para COMPLETAR el perfil
            if ($user->type == 'unemployed') {
                return redirect()->route('unemployed-form'); // Va al UnemployedController@create
            } else {
                return redirect()->route('company-form'); // Va al CompanyController@create
            }

        } catch (Exception $e) {
            return redirect('/login')->withErrors('Error al iniciar sesión con Google: ' . $e->getMessage());
        }
    }
}