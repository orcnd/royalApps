<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\loginApiUserRequest;
use App\Models\apiUser;

class ApiUserController extends Controller
{
    public function login() {
        return view('auth/login');
    }

    public function loginEnter(loginApiUserRequest $request) {
        $email=$request->input('email');
        $pass=$request->input('password');
        $response=apiUser::login($email,$pass);
        if ($response->status==true) {
            return redirect()->route('home');
        }else {
            return redirect()->route('login')->withErrors($response->errors);
        }
    }

}
