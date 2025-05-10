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
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function loginWithFacebook()
    {
        $facebookUser = Socialite::driver('facebook')->stateless()->user();

        $user = User::where('facebook_id', $facebookUser->id)
            ->orWhere('email', $facebookUser->email)
            ->first();

        if (!$user)
        {
            $user = User::create([
                'first_name'   => $facebookUser->user['first_name'] ?? $facebookUser->name,
                'last_name'    => $facebookUser->user['last_name'] ?? '',
                'email'        => $facebookUser->email,
                'facebook_id'  => $facebookUser->id,
                'password'     =>  Hash::make($facebookUser->password) 
            ]);
        }

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
