@extends('admin.layouts.app')
@section('title', 'Тесты')


@section('content')

    <div class="row mt-5"></div>
    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Проверка тестов
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Пользователь</th>
                            <th>Тест</th>
                            <th>Вопросы</th>
                            <th>Ответы</th>
                            <th>Статус</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tests_progress as $test_progress)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $test_progress->getUser()->getFio() }}</td>
                                <td>{{ $test_progress->getTest()->caption }}</td>
                                <td>
                                    <ul>
                                        @foreach($test_progress->getTest()->getQuestions() as $question)
                                            <li>{{ $question }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        @foreach($test_progress->getAnswers() as $answer)
                                            <li>{{ $answer }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $test_progress->status }}</td>
                                <td>
                                    @if($test_progress->status === "TO CHECK")
                                        <form method="POST" action="{{ route('test_progress_set_status', $test_progress) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="CHECKING">
                                            <button class="btn btn-primary">Проверяю</button>
                                        </form>
                                    @elseif($test_progress->status === "CHECKING")
                                        <form method="POST" action="{{ route('test_progress_set_mark', $test_progress) }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">Оценка</label>
                                                <input class="form-control @error('mark') is-invalid @enderror" type="number" min="1" max="10" value="1" name="mark">
                                                @error('mark')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Комментарий</label>
                                                <input class="form-control" type="text" name="comment">
                                            </div>
                                            <button class="btn btn-primary" type="submit">Проверил</button>
                                        </form>
                                    @elseif($test_progress->status === "CHECKED")
                                        Оценка по тесту {{ $test_progress->mark }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Добавление теста
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('tests.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Название</label>
                            <input type="text" name="caption" class="form-control @error('caption') is-invalid @enderror" value="{{ old('caption') }}">
                            @error('caption')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Курс</label>
                            <select class="form-control @error('course') is-invalid @enderror" name="course">
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->caption }}</option>
                                @endforeach
                            </select>
                            @error('course')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Вопросы</label>
                            <textarea name="questions" class="form-control @error('questions') is-invalid @enderror" cols="30" rows="10">{{ old('questions') }}</textarea>
                            @error('questions')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-primary">Добавить тест</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($tests as $test)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $test->caption }}</td>
                            <td>{{ $test->getCourse()->caption }}</td>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
