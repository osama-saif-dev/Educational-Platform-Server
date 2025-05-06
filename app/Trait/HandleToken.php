<?php

namespace App\Trait;

use App\Models\RefreshToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait HandleToken
{
    public function isValidRefreshToken($refresh_token)
    {
        $tokens = RefreshToken::where('expired_at', '>', now())->get();
        if ($tokens){
            foreach($tokens as $token){
                if (Hash::check($refresh_token, $token->token)){
                    return $token;
                }
            }
        }
        return null;
    }

    public function generateNewAccessToken($user)
    {
        $token = $user->createToken('token');
        $access_token = $token->plainTextToken;
        $tokenModel = $token->accessToken;
        $tokenModel->expires_at = now()->addHour();
        $tokenModel->save();
        return $access_token;
    }


    public function storeRefreshToken($user)
    {
        RefreshToken::where('user_id', $user->id)->delete();

        $refresh_token = Str::random(60);

        RefreshToken::create([
            'user_id' => $user->id,
            'token' => Hash::make($refresh_token),
            'expired_at' => now()->addMonth()
        ]);

        return $refresh_token;
    }
}
