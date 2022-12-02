<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CourseProgress extends Model
{
    use HasFactory;

    protected $table = 'courses_progress';

    public static function getProgressPrecentByCourse(int $course)
    {
        $course = Course::all()->where('id', '=', $course)->first();

        $count_course_lesson = $course->getLessons()->count();

        $user_progress = User::getCourseProgressByUser(Auth::user()->id);

        $count_completed_lesson = count($user_progress[$course->id]);

        return (int)(($count_completed_lesson / $count_course_lesson)*100);
    }

    public function getLesson()
    {
        return $this->hasOne(Lesson::class, 'id', 'lesson')->first();
    }

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user')->first();
    }
}
