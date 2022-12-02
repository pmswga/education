<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function registerUser(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'secondname' => 'required',
            'sex' => 'required',
            'birthdate' => 'required',
            'email' => 'required',
            'password' => 'required'
        ], [
            'name.required' => 'Поле имя не может быть пустым',
            'secondname.required' => 'Поле фамилия не может быть пустым',
            'sex.required' => 'Поле пола не может быть пустым',
            'birthdate.required' => 'Поле даты рождения не может пустым',
            'email.required' => 'Поле почта не может пустым',
            'password.required' => 'Поле пароля не может быть пустым'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $user = new User();
        $user->name = $data['name'];
        $user->secondname = $data['secondname'];
        $user->sex = $data['sex'];
        $user->birthdate = $data['birthdate'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);

        try
        {
            if (!$user->save()) {
                return back()->with('error', 'Не удалось вас зарегестрировать. Так как возникла ошибка записи в базу данных');
            }
        }
        catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return back()->with('error', 'Такой пользователь уже зарегистрирован');
            }

            return back()->with('error', 'Неизвестная ошибка');
        } catch (\Exception $e) {
            return back()->with('error', 'Неизвестная ошибка');
        }

        return back()->with('success', 'Вы успешно зарегистрировались');
    }

    public function destroy(User $user)
    {
        if (!$user->delete()) {
            return back()->with('error', 'Не удалось удалить пользователя');
        }

        return back()->with('success', 'Пользователь удалён');
    }

}
