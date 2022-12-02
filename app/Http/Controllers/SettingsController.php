<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{

    public function updateTitle(Settings $settings, Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required'
        ], [
            'title.required' => 'Поле название не может быть пустым'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $settings->title = $data['title'];

        if (!$settings->update()) {
            return back()->with('error', 'Не удалось изменить название сайта');
        }

        return back()->with('success', 'Назавание сайта успешно изменено');
    }

    public function updatePassword(Admin $admin, Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'password' => 'required'
        ], [
            'password.required' => 'Поле пароля не может быть пустым'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $admin->password = Hash::make($data['password']);

        if (!$admin->update()) {
            return back()->with('error', 'Не удалось изменить пароль');
        }

        return back()->with('success', 'Пароль успешно изменён');
    }

}
