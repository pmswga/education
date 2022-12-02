<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function loginUser(Request $request)
    {
        $data = $request->all();
        $data['remember_me'] = isset($data['remember_me']) ? 1 : 0;

        $validator = Validator::make($data, [
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Поле почта не может быть пустым',
            'password.required' => 'Поле пароля не может быть пустым'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        if (Auth::guard('web')->attempt($credentials, $data['remember_me'])) {
            $request->session()->regenerate();

            return redirect()->route('profile');
        }

        return back()->with('error', 'Неверные почта или пароль');
    }

    public function loginAdmin(Request $request)
    {
        $data = $request->all();
        $data['remember_me'] = isset($data['remember_me']) ? 1 : 0;

        $validator = Validator::make($data, [
            'login' => 'required',
            'password' => 'required'
        ], [
            'login.required' => 'Поле логина не может быть пустым',
            'password.required' => 'Поле пароля не может быть пустым'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $credentials = [
            'login' => $data['login'],
            'password' => $data['password']
        ];

        if (Auth::guard('admin')->attempt($credentials, $data['remember_me'])) {
            $request->session()->regenerate();

            return redirect()->route('admin_index');
        }

        return back()->with('error', 'Неверные почта или пароль');
    }

    public function logoutUser(Request $request)
    {
        Auth::guard('web')->logout();

        return back();
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();

        return back();
    }

}
