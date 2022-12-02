<?php

namespace App\Http\Controllers;

use App\Models\CourseProgress;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'course' => 'required',
            'caption' => 'required',
            'content' => 'required'
        ], [
            'course.required' => 'Не выбран курс',
            'caption.required' => 'Поле название не может быть пустым',
            'content.required' => 'Поле содержание не может быть пустым'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $lesson = new Lesson();
        $lesson->course = $data['course'];
        $lesson->caption = $data['caption'];
        $lesson->content = $data['content'];

        if (!$lesson->save()) {
            return back()->with('error', 'Не удалось создать урок');
        }

        return back()->with('success', 'Урок создан');
    }

    public function completeLesson(Lesson $lesson)
    {
        $courseProgress = new CourseProgress();

        $courseProgress->user = Auth::user()->id;
        $courseProgress->lesson = $lesson->id;

        if (!$courseProgress->save()) {
            return back()->with('error', 'Не удалось отметить урок пройденным');
        }

        return back()->with('success', 'Урок отмечен как пройденный');
    }

    public function destroy(Lesson $lesson)
    {
        if (!$lesson->delete()) {
            return back()->with('error', 'Не удалось удалить урок');
        }

        return back()->with('success', 'Урок удалён');
    }

}
