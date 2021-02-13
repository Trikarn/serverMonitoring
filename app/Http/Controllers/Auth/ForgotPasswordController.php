<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }

    public function sendResetLinkEmail(Request $request) 
    {
        $this->validateEmail($request);
        $userData = User::findByEmail($request->email);
        
        if(empty($userData)) {
            return back()->withErrors(['email' => 'Не найден пользователь с таким email']);
        }

        $newPassword = Str::random(8);
        $userData->password = Hash::make($newPassword);
        $userData->save();

        mail($request->email,'Смена пароля','Ваш новый пароль '.$newPassword);
        return back()->with('status', 'Новый пароль был выслан на ваш адрес электронной почты');
    }

}
