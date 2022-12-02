@extends('layouts.app')
@section('title', 'Мой профиль')

@section('content')

    <div class="row mt-5 mb-3">
        <div class="col">
            <div class="d-flex justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table">
                <tbody>
                    <tr>
                        <td>Имя</td>
                        <td>{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <td>Фамилия</td>
                        <td>{{ Auth::user()->secondname }}</td>
                    </tr>
                    <tr>
                        <td>Пол</td>
                        <td>{{ Auth::user()->getTextSex() }}</td>
                    </tr>
                    <tr>
                        <td>Дата рождения</td>
                        <td>{{ Auth::user()->getBirthdate() }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ Auth::user()->email }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <h1>Мой прогресс</h1>
        <hr>
    </div>
    @foreach(Auth::user()->getCourseProgress() as $course_id => $lessons)
        @php $course = \App\Models\Course::all()->where('id', '=', $course_id)->first() @endphp
        @isset($course)
            <div class="row">
                <div class="col">
                    <h3>{{ $course->caption }}</h3>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-label="Example with label" style="width: {{ \App\Models\CourseProgress::getProgressPrecentByCourse($course_id) }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ \App\Models\CourseProgress::getProgressPrecentByCourse($course_id) }}%</div>
                    </div>
                </div>
                <div class="col">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Урок</th>
                                <th>Время отметки</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lessons as $lesson)
                                <tr>
                                    <td>{{ $lesson['lesson_caption'] }}</td>
                                    <td>{{ \Illuminate\Support\Carbon::make($lesson['created_at'])->format('d.m.Y H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endisset
    @endforeach
    <div class="row">
        <h1>Мой достижения</h1>
        <hr>
    </div>

@endsection
