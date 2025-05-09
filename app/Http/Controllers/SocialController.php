<?php

namespace App\Http\Controllers;

use Auth;
use Socialite;
use App\Models\User;
use App\Trait\HandleToken;
use Illuminate\Http\Request;
use App\Trait\HandleResponse;
use Illuminate\Support\Facades\Hash;

class SocialController extends Controller
{
    use HandleResponse, HandleToken;
    public function facebookRedirect()
    {
        // Redirect to Facebook for authentication
        return Socialite::driver('facebook')->stateless()->redirect();
    }
    // public function loginWithFacebook()
    // {
    //     try
    //     {
    //         // Retrieve user from Facebook
    //         $facebookUser = Socialite::driver('facebook')->stateless()->user();

    //         // Attempt to find an existing user by Facebook ID or email
    //         $existingUser = User::where('facebook_id', $facebookUser->id)
    //             ->orWhere('email', $facebookUser->email)
    //             ->first();
    //         if ($existingUser)
    //         {
    //             // Update Facebook ID if the user was found by email
    //             if ($existingUser->facebook_id !== $facebookUser->id)
    //              {
    //                 $existingUser->facebook_id = $facebookUser->id;
    //                 $existingUser->save();
    //             }
    //             Auth::login($existingUser);
    //         } else
    //         {
    //             // Create a new user
    //             $createUser = User::create(
    //             [
    //                 'first_name' => $facebookUser->name,
    //                 'last_name' => $facebookUser->name,
    //                 'email' => $facebookUser->email,
    //                 'facebook_id' => $facebookUser->id,
    //                 'password' => bcrypt('password'), // Hashing the password
    //             ]);
    //             $token = $user->createToken('token')->plainTextToken;

    //             Auth::login($createUser);
    //         }
    //         // Redirect to the dashboard without the fragment
    //         // return redirect()->to('/dashboard'); // Ensure this is the direct path to your dashboard
    //         return response()->json(
    //             [
    //                 'data'          => $createUser,
    //                 'token'         => $token,
    //                 'message'       => 'Created Successfully',
    //                 'status'        => 201,
    //             ]);

    //     } catch (\Throwable $th)
    //     {
    //         // Handle the exception or log it
    //         throw $th; // Consider logging the exception for debugging
    //     }
    // }



    public function loginWithFacebook()
    {
        // استدعاء بيانات المستخدم من فيسبوك
        $facebookUser = Socialite::driver('facebook')->stateless()->user();

        // البحث عن المستخدم في قاعدة البيانات
        $user = User::where('facebook_id', $facebookUser->id)
            ->orWhere('email', $facebookUser->email)
            ->first();

        if (!$user)
        {
            // إنشاء مستخدم جديد إذا لم يوجد
            $user = User::create([
                'first_name'   => $facebookUser->user['first_name'] ?? $facebookUser->name,
                'last_name'    => $facebookUser->user['last_name'] ?? '',
                'email'        => $facebookUser->email,
                'facebook_id'  => $facebookUser->id,
                'password'     =>  Hash::make($facebookUser->password) // كلمة مرور افتراضية
            ]);
        }

        // إنشاء التوكن باستخدام Laravel Sanctum
        $access_token = $this->generateNewAccessToken($user);
        $refresh_token = $this->storeRefreshToken($user);

        return $this->data(compact('user','access_token','refresh_token'));
    }
}
