<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshTokenRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\RefreshToken;
use App\Models\User;
use App\Trait\HandleResponse;
use App\Trait\HandleToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    use HandleResponse, HandleToken;


    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('token')->plainTextToken;
        return $this->data([
            'email' => $user->email,
            'token' => $token
        ], 'Created Successfully', 201);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!Hash::check($request->password, $user->password)) {
            return $this->errorsMessage(['error' => 'Email Or Password Is Not Valid']);
        }
        if (!$user->email_verified_at) {
            $email = $user->email;
            $access_token = $this->generateNewAccessToken($user);
            return $this->data(compact('email', 'access_token'), 'You Must Verify Your Email', 403);
        }
        $access_token = $this->generateNewAccessToken($user);
        $refresh_token = $this->storeRefreshToken($user);
        return $this->data(compact('user', 'access_token', 'refresh_token'), 'Login Successfully');
    }

    public function logout()
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        RefreshToken::where('user_id', $user->id)->delete();
        return $this->successMessage('Logout Successfully');
    }

    public function refreshToken(RefreshTokenRequest $request)
    {
        $old_token = $this->isValidRefreshToken($request->refresh_token);
        // here you should navigate to login page
        if (!$old_token) {
            return $this->errorsMessage([
                'error' => 'Refresh token expired or invalid',
                'status' => false
            ]);
        }
        $user = $old_token->user;
        $access_token = $this->generateNewAccessToken($user);
        $refresh_token = $this->storeRefreshToken($user);
        return $this->data(compact('user', 'access_token', 'refresh_token'));
    }
}
