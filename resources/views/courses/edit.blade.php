@extends('admin.layouts.app')
@section('title', 'Редактирование курса')

@section('content')
    @include('admin.modals.add_lesson')
    @include('admin.modals.add_test')

    <div class="row mt-5"></div>
    <div class="row mb-3">
        <h1>Редактирование курса {{ $course->caption }}</h1>
        <hr>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="accordion" id="courseAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#courseInfo" aria-expanded="false" aria-controls="collapseTwo">
                            Информация
                        </button>
                    </h2>
                    <div id="courseInfo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#courseAccordion">
                        <div class="accordion-body">
                            <div class="container-fluid">
                                <form method="POST" action="{{ route('course_update', $course) }}">
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3">
                                            <label class="form-label">Название курса</label>
                                            <input type="text" name="caption" class="form-control @error('caption') is-invalid @enderror mb-3" value="{{ $course->caption }}">
                                            @error('caption')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Краткое описание</label>
                                            <input type="text" name="short_description" class="form-control @error('short_description') is-invalid @enderror mb-3" value="{{ $course->short_description }}">
                                            @error('short_description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="d-flex justify-content-center">
                                                <img src="{{ $course->getImageSrc() }}" class="img-fluid w-50">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="form-label">Описание: </label>
                                            <textarea name="description" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror">{{ $course->description }}</textarea>
                                            @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-outline-primary" type="submit">
                                                    Сохранить
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#courseLessons" aria-expanded="false" aria-controls="collapseTwo">
                            Уроки
                        </button>
                    </h2>
                    <div id="courseLessons" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#courseAccordion">
                        <div class="accordion-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Тема урока</th>
                                    <th>Содержание урока</th>
                                    <th>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#addLessonModal">Добавить урок</button>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($course->getLessons() as $lesson)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $lesson->caption }}</td>
                                        <td>{{ $lesson->content }}</td>
                                        <td>
                                            <a></a>
                                            <form class="m-0 p-0" method="POST" action="{{ route('lesson_delete', $lesson->id) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger" type="submit" onclick="return confirm('Удалить урок?')">
                                                    Удалить
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#courseTests" aria-expanded="false" aria-controls="collapseTwo">
                            Тесты
                        </button>
                    </h2>
                    <div id="courseTests" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#courseAccordion">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Название</th>
                                            <th>Курс</th>
                                            <th>Вопросы</th>
                                            <th>Дата создания</th>
                                            <th>
                                                <div class="d-flex justify-content-end">
                                                    <a type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#addTestModal">
                                                        Добавить тест
                                                    </a>
                                                </div>
                                            </th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tests as $test)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>{{ $test->caption }}</td>
                                                <td>{{ is_null($test->getCourse()) ? 'курс был удалён' : $test->getCourse()->caption }}</td>
                                                <td>
                                                    <ul>
                                                        @foreach($test->getQuestions() as $question)
                                                            <li>{{ $question }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    {{ $test->getCreatedAt() }}
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('tests.destroy', $test) }}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn btn-danger" type="submit" onclick="return confirm('Удалить тес?')">
                                                            Удалить
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
