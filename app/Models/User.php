<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = [
        'password'
    ];

    public function getTextSex()
    {
        switch ($this->sex)
        {
            case 'MALE':
                return 'Мужской';
            case 'FEMALE':
                return 'Женский';
        }
    }

    public function getFio()
    {
        return $this->secondname . ' ' . $this->name;
    }

    public function getBirthdate()
    {
        return Carbon::make($this->birthdate)->format('d.m.Y');
    }

    public function isLessonCompleted(int $lesson)
    {
        $lesson = CourseProgress::all()
            ->where('user', '=', $this->id)
            ->where('lesson', '=', $lesson)
            ->first();

        return $lesson;
    }

    public function getCourseProgress()
    {
        $course_progress = \App\Models\CourseProgress::all()->where('user', '=', $this->id);

        $course_progress = $course_progress->map(function ($course_progress) {
            $lesson = $course_progress->getLesson();

            if ($lesson) {
                $course = $lesson->getCourse();

                if ($course) {
                    $course_progress->course = is_null($lesson) ? 0 : $lesson->getCourse()->id;
                    $course_progress->lesson_caption = is_null($lesson) ? '' : $lesson->caption;
                }
            }

            return $course_progress;
        })->groupBy('course')->toArray();

        return $course_progress;
    }

    public static function getCourseProgressByUser(int $user)
    {
        $course_progress = \App\Models\CourseProgress::all()->where('user', '=', $user);

        $course_progress = $course_progress->map(function ($course_progress) {
            $lesson = $course_progress->getLesson();

            if ($lesson) {
                $course = $lesson->getCourse();

                if ($course) {
                    $course_progress->course = is_null($lesson) ? 0 : $lesson->getCourse()->id;
                    $course_progress->lesson_caption = is_null($lesson) ? '' : $lesson->caption;
                }
            }

            return $course_progress;
        })->groupBy('course')->toArray();

        return $course_progress;
    }

    public function isTestPassed(int $test)
    {
        $passed_test = TestProgress::all()
            ->where('user', '=', $this->id)
            ->where('test', '=', $test)
            ->first();

        if ($passed_test) {
            return true;
        }

        return false;
    }

}
