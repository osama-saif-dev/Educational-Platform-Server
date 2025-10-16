<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Trait\HandleToken;
use Illuminate\Http\Request;
use App\Trait\HandleResponse;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

// use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    use HandleResponse, HandleToken;

    public function facebookRedirect()
    {
        return Socialite::driver('facebook')
        ->stateless()
        ->with(['auth_type' => 'reauthenticate'])
        ->redirect();
    }

    public function loginWithFacebook()
    {
        $facebookUser = Socialite::driver('facebook')->stateless()->user();

        $user = User::where('facebook_id', $facebookUser->id)
            ->orWhere('email', $facebookUser->email)
            ->first();

        if (!$user) {
            $user = User::create([
                'first_name'   => explode(' ', $facebookUser->getName())[0] ?? 'FaceBook',
                'last_name'    => explode(' ', $facebookUser->getName())[1] ?? 'user',
                'email'        => $facebookUser->email,
                'facebook_id'  => $facebookUser->id,
                'email_verified_at' => now(),
                'password'     =>  Hash::make($facebookUser->password)
            ]);
        }

        $user->refresh();

        $access_token = $this->generateNewAccessToken($user);
        $refresh_token = $this->storeRefreshToken($user);

        $data = [
            'user' => $user,
            'access_token' => $access_token,
            'refresh_token' => $refresh_token
        ];

        return redirect()->to("http://localhost:3000/auth/facebook/callback?data=" . urlencode(json_encode($data)));
    }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account consent'])
            ->stateless()
            ->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'first_name' => explode(' ', $googleUser->getName())[0] ?? 'User',
                'last_name' => explode(' ', $googleUser->getName())[1] ?? 'Google',
                'email'        => $googleUser->email,
                'google_id'  => $googleUser->id,
                'email_verified_at' => now(),
                'password'     =>  Hash::make($googleUser->password)
            ]);
        }

        $user->refresh();

        $access_token = $this->generateNewAccessToken($user);
        $refresh_token = $this->storeRefreshToken($user);

        $data = [
            'user' => $user,
            'access_token' => $access_token,
            'refresh_token' => $refresh_token
        ];

        return redirect()->to("http://localhost:3000/auth/google/callback?data=" . urlencode(json_encode($data)));
    }
}
