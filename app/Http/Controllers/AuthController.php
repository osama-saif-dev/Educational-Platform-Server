<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Traits\HandleResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    use HandleResponse;

    
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('token')->plainTextToken;
        return $this->data(compact('user', 'token'), 'Created Successfully', 201);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!Hash::check($request->password, $user->password)) {
            return $this->errorsMessage(['error' => 'Email Or Password Has Been Failed']);
        }
        if (!$user->email_verified_at) {
            $user->token = $user->createToken('token')->plainTextToken;
            return $this->data(compact('user'), 'Email Must Be Verified', 404);
        }
        $user->token = $user->createToken('token')->plainTextToken;
        return $this->data(compact('user'), 'Login Successfully');
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return $this->successMessage('Logout Successfully');
    }

}
