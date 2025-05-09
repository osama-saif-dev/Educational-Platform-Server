<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\TeacherRequest;

class TeacherController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin')
        {
            $teachers = User::where('role', 'teacher')->get();
            return alertMessage($teachers, 'Teachers fetched successfully', 200);
        }else
        {
            return alertMessage(null, 'You are not authorized to access this resource', 403);
        }


    }

    public function store(TeacherRequest $request)
    {
        if (auth()->user()->role === 'admin')
        {
            $create = User::create(
                [
                    'first_name'    => $request->first_name,
                    'last_name'     => $request->last_name,
                    'email'         => $request->email,
                    'password'      => Hash::make($request->password),
                    'role'          => 'teacher'
                ]);

               return alertMessage($create,'ٍStudent Created Successfaly',200);
        } else
        {
            return alertMessage(null, 'You are not authorized to access this resource', 403);
        }


    }

    // public function update(Request $request,$id)
    // {
    //     $user = User::find($id);
    //     $request->validate([
    //         'role' => 'required|in:admin,student,teacher', // مثال على القيم المسموح بها
    //     ]);


    //     $user->update(
    //     [
    //         'role'    => $request->role,
    //     ]);

    //    return alertMessage($user,'User Updated Successfaly',200);
    // }


    // public function delete(Request $request,$id)
    // {
    //     $user = User::find($id);
    //     $user->delete();


    //    return alertMessage($user,'User Deleted Successfaly',200);
    // }
}
