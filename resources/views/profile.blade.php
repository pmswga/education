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
    <div class="row mb-3">
        <h1>Мой достижения</h1>
        <hr>
    </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    {{-- Какя-нибудь хуйня. Подумай как можно добавить классные иконки для достижений --}}
                    <th></th>
                    <th>Достижение</th>
                    <th>Когда получено</th>
                </tr>
            </thead>
            <tbody>
                @foreach($achievements as $achievement)
                    <tr>
                        <td>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trophy" viewBox="0 0 16 16">
                                <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935zM3.504 1c.007.517.026 1.006.056 1.469.13 2.028.457 3.546.87 4.667C5.294 9.48 6.484 10 7 10a.5.5 0 0 1 .5.5v2.61a1 1 0 0 1-.757.97l-1.426.356a.5.5 0 0 0-.179.085L4.5 15h7l-.638-.479a.501.501 0 0 0-.18-.085l-1.425-.356a1 1 0 0 1-.757-.97V10.5A.5.5 0 0 1 9 10c.516 0 1.706-.52 2.57-2.864.413-1.12.74-2.64.87-4.667.03-.463.049-.952.056-1.469H3.504z"/>
                            </svg>
                        </td>
                        <td>{{ $achievement->achievement }}</td>
                        <td>{{ $achievement->getCreatedAt() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
