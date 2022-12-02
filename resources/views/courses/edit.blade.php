@extends('admin.layouts.app')
@section('title', 'Редактирование курса')

@section('content')
    @include('admin.modals.add_lesson')

    <div class="row mt-5 mb-3">
        <div class="col">
            <div class="accordion" id="courseAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#courseInfo" aria-expanded="false" aria-controls="collapseTwo">
                            Информация о курсе
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
                                    <div class="row">
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-center">
                                                <img src="{{ $course->getImageSrc() }}" class="img-fluid w-50">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <textarea name="description" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror">{{ $course->description }}</textarea>
                                                @error('description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="d-flex justify-content-center">
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
            </div>
        </div>
    </div>

@endsection
