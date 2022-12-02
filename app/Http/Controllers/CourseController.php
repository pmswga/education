<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{

    public function show(Course $course)
    {
        return view('courses.show', [
            'course' => $course
        ]);
    }

    public function edit(Course $course)
    {
        return view('courses.edit', [
           'course' => $course,
            'tests' => Test::all()->where('course', '=', $course->id)
        ]);
    }

    public function update(Course $course, Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'caption' => 'required',
            'short_description' => 'required',
            'description' => 'required',
        ], [
            'caption.required' => 'Дайте курсу название',
            'short_description.required' => 'Дайте курсу краткое описание',
            'description.required' => 'Дайте курсу описание'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $course->caption = $data['caption'];
        $course->short_description = $data['short_description'];
        $course->description = $data['description'];

        if (!$course->update()) {
            return back()->with('error', 'Не удалось обновить курс');
        }

        return back()->with('success', 'Курс успешно обновлён');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'caption' => 'required',
            'short_description' => 'required',
            'description' => 'required',
        ], [
            'caption.required' => 'Дайте курсу название',
            'short_description.required' => 'Дайте курсу краткое описание',
            'description.required' => 'Дайте курсу описание'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $course = new Course();
        $course->caption = $data['caption'];
        $course->short_description = $data['short_description'];
        $course->description = $data['description'];
        $course->image = '';

        if (!$course->save()) {
            return back()->with('error', 'Не удалось создать курс');
        }

        if (isset($data['image'])) {
            $name = 'cover_image_' . $course->id . '.' . $request->file('image')->getClientOriginalExtension();

            $path =
                public_path()
                . DIRECTORY_SEPARATOR
                . 'storage'
                . DIRECTORY_SEPARATOR
                . 'cover';

            $file = $request->file('image')->move($path, $name);
            if ($file->getPath() !== $path) {
                return back()->with('error', 'Не удалось создать курс. Не удалось загрузить картинку курса');
            }

            $course->image = $path . DIRECTORY_SEPARATOR . $name;
        } else {
            $course->image = '';
        }

        if (!$course->update()) {
            return back()->with('error', 'Не удалось создать курс, так как произошла ошибка загрузки обложки');
        }

        return back()->with('success', 'Курс успешно создан');
    }

    public function destroy(Course $course)
    {
        if (!$course->delete()) {
            return back()->with('error', 'Не удалось удалить курс');
        }

        return back()->with('success', 'Курс удалён');
    }

}
