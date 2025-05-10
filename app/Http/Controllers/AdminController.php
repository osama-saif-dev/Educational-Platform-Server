<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Trait\HandleResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use HandleResponse;

    // Students
    public function getStudents()
    {
        $students = User::where('role', 'student')->get();
        return $this->data(compact('students'));
    }

    public function changeRole(Request $request, $id)
    {
        $user = User::find($id);
        $request->validate(
            [
                'role' => 'required|in:admin,student,teacher',
            ]
        );
        $user->update(
            [
                'role'    => $request->role,
            ]
        );
        return $this->successMessage('Updated Successfully');
    }


    public function deleteStudent($id)
    {

        $user = User::find($id);
        $user->delete();
        return $this->successMessage('Deleted Successfully');
    }

    // Teachers
    public function getTeachers()
    {
        $teachers = User::where('role', 'teacher')->get();
        return $this->data(compact('teachers'));
    }



    // public function delete(Request $request,$id)
    // {
    //     $user = User::find($id);
    //     $user->delete();


    //    return alertMessage($user,'User Deleted Successfaly',200);
    // }
}
