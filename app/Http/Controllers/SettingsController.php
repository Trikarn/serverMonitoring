<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('settings');
    }

    public function changePassword(Request $request)
    {
        $user = new User();

        $userData = User::find(Auth::id());

        $checkPasswordNow = $request->input('oldPassword');
        $newPassword = $request->input('newPassword');

        if(!Hash::check($checkPasswordNow, $userData->password)) {
            return back()
                ->with('status', 'Текущий пароль указан неверно')
                ->with('success', 'false');
        }

        $userData->password = Hash::make($newPassword);
        $userData->save();

        return back()->with('status', 'Пароль успешно изменен');
    }
}
