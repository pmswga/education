@extends('admin.layouts.app')
@section('title', 'Главная страница')


@section('content')
    @include('admin.modals.add_course')

    <div class="row mt-5"></div>
    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Курсы
                </div>
                <div class="card-body">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>Картинка</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $course->caption }}</td>
                                <td>{{ $course->short_description }}</td>
                                <td><img src="{{ \Illuminate\Support\Facades\Storage::url('cover/' .  basename($course->image))  }}" class="img-fluid" alt="course"></td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <div class="d-grid gap-2">
                                            <a class="btn btn-outline-info" href="{{ route('course_edit', $course) }}">Редактировать</a>
                                            <form method="POST" action="{{ route('course_delete', $course->id) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger w-100" type="submit" onclick="return confirm('Удалить курс?')">
                                                    Удалить
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                {{ $courses->links() }}
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Пользователи
                </div>
                <div class="card-body">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Фамилия</th>
                                <th>Имя</th>
                                <th>Пол</th>
                                <th>Дата рождения</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $user->secondname }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->getTextSex() }}</td>
                                    <td>{{ $user->getBirthdate() }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <form class="m-0 p-0" method="POST" action="{{ route('user_delete', $user->id) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger" type="submit" onclick="return confirm('Удалить пользователя?')">
                                                    Удалить
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    {{ $users->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

