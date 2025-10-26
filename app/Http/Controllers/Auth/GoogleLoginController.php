<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('flash', [
                'type' => 'error',
                'title' => 'Login Gagal',
                'message' => 'Google login gagal: ' . $e->getMessage(),
            ]);
        }

        $user = User::where('google_id', $googleUser->getId())->first();

        if (!$user) {
            // Check if a user with the same email already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // If user exists with email, link Google ID
                $user->google_id = $googleUser->getId();
                $user->save();
            } else {
                // Create a new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(24)), // Generate a random password
                    'email_verified_at' => now(), // Google users are considered verified
                ]);

                // Assign 'student' role
                $user->assignRole('student');

                event(new Registered($user));
            }
        }

        Auth::login($user);

        return redirect()->intended('/dashboard')->with('flash', [
            'type' => 'success',
            'title' => 'Oh Yeah!',
            'message' => 'Anda berhasil masuk dengan Google.',
        ]);
    }
}
