<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ContactRequest;
use App\Mail\ContactUs;
use App\Models\User;
use App\Trait\HandleResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    use HandleResponse;

    public function contact(ContactRequest $req)
    {
        $admin = User::where('role', 'admin')->where('email', 'osamasaif242@gmail.com')->first();
        Mail::to($admin->email)->send(new ContactUs($req->first_name, $req->last_name, $req->email, $req->message));
        return $this->successMessage('Sent Your Message Successfully');
    }
}
