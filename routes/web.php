<?php

use App\Models\CourseProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'courses' => \App\Models\Course::all()->sortBy('created_at')
    ]);
})->name('index');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/login', function () {
    if (\Illuminate\Support\Facades\Auth::guard('web')->check()) {
        return back();
    }

   return view('login');
})->name('login');

Route::post('/login_user', [\App\Http\Controllers\LoginController::class, 'loginUser'])->name('loginUser');
Route::post('/logout_user', [\App\Http\Controllers\LoginController::class, 'logoutUser'])->name('logoutUser');

Route::get('/registration', function () {
    if (\Illuminate\Support\Facades\Auth::guard('web')->check()) {
        return back();
    }

    return view('registration');
})->name('registration');

Route::post('/registration_user', [\App\Http\Controllers\UserController::class, 'registerUser'])->name('registrationUser');

Route::get('/profile', function () {
   return view('profile', [
       'achievements' => \App\Models\Achievement::all()->where('user', '=', Auth::user()->id)
   ]);
})->name('profile')->middleware('auth:web');


Route::get('/course_show/{course}', [\App\Http\Controllers\CourseController::class, 'show'])->name('course_show');

Route::get('/test', function () {

});

Route::prefix('admin')->group(function () {

    Route::get('/', function() {
        return view('admin.index', [
            'users' => \App\Models\User::orderBy('secondname')->paginate(5),
            'courses' => \App\Models\Course::orderBy('created_at')->paginate(5)
        ]);
    })->name('admin_index')->middleware('auth:admin');

    Route::get('/login', function() {
        return view('admin.login');
    })->name('admin_login');

    Route::post('/login_admin', [\App\Http\Controllers\LoginController::class, 'loginAdmin'])->name('loginAdmin');
    Route::post('/logout_admin', [\App\Http\Controllers\LoginController::class, 'logoutAdmin'])->name('logoutAdmin');

    Route::get('settings', function () {
        return view('admin.settings');
    })->name('admin_settings')->middleware('auth:admin');

    Route::post('/settings/title/update/{settings}', [\App\Http\Controllers\SettingsController::class, 'updateTitle'])->name('title_update');
    Route::post('/settings/password/update/{admin}', [\App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('password_update');

    Route::delete('/user_delete/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('user_delete');

    Route::post('/course_store', [\App\Http\Controllers\CourseController::class, 'store'])->name('course_store');
    Route::put('/course_update/{course}', [\App\Http\Controllers\CourseController::class, 'update'])->name('course_update');
    Route::get('/course_edit/{course}', [\App\Http\Controllers\CourseController::class, 'edit'])->name('course_edit');
    Route::delete('/course_delete/{course}', [\App\Http\Controllers\CourseController::class, 'destroy'])->name('course_delete');


    Route::post('/lesson_complete/{lesson}', [\App\Http\Controllers\LessonController::class, 'completeLesson'])->name('complete_lesson');
    Route::post('/lesson/store', [\App\Http\Controllers\LessonController::class, 'store'])->name('lesson_store');
    Route::delete('/lesson/delete/{lesson}', [\App\Http\Controllers\LessonController::class, 'destroy'])->name('lesson_delete');

    Route::resource('/tests', \App\Http\Controllers\TestController::class);
    Route::resource('/tests_progress', \App\Http\Controllers\TestProgressController::class);

    Route::post('/test_progress_set_status/{testProgress}', [\App\Http\Controllers\TestProgressController::class, 'test_progress_set_status'])->name('test_progress_set_status');
    Route::post('/test_progress_set_mark/{testProgress}', [\App\Http\Controllers\TestProgressController::class, 'test_progress_set_mark'])->name('test_progress_set_mark');
    Route::get('/passing_test/{test}', [\App\Http\Controllers\TestController::class, 'passing_test'])->name('passing_test');

});
