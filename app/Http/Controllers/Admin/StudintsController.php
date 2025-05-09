<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\StudentsRequest;

class StudintsController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin')
        {
            $students = User::where('role','student')->get();
            return alertMessage($students, '', 200);
        } else
        {
            return alertMessage(null, 'You are not authorized to access this resource', 403);

        }


    }

    public function store(StudentsRequest $request)
    {
        if (auth()->user()->role === 'admin')
        {
            $create = User::create(
                [
                    'first_name'    => $request->first_name,
                    'last_name'     => $request->last_name,
                    'email'         => $request->email,
                    'password'      => Hash::make($request->password),
                ]);

               return alertMessage($create,'ٍStudent Created Successfaly',200);
        } else
        {
            return alertMessage(null, 'You are not authorized to access this resource', 403);

        }


    }

    public function update(Request $request,$id)
    {
        if (auth()->user()->role === 'admin')
        {
            $user = User::find($id);
            $request->validate(
            [
                'role' => 'required|in:admin,student,teacher', // مثال على القيم المسموح بها
            ]);


            $user->update(
            [
                'role'    => $request->role,
            ]);

           return alertMessage($user,'User Updated Successfaly',200);
        } else
        {
            return alertMessage(null, 'You are not authorized to access this resource', 403);
        }
    }


    public function delete(Request $request,$id)
    {
        if (auth()->user()->role === 'admin')
        {
            $user = User::find($id);
            $user->delete();

            return alertMessage($user,'User Deleted Successfaly',200);
        } else
        {
            return alertMessage(null, 'You are not authorized to access this resource', 403);

        }


    }

}
