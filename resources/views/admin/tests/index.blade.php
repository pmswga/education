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
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tests_progress as $test_progress)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ is_null($test_progress->getUser()) ? 'пользователь был удалён' : $test_progress->getUser()->getFio(); }}</td>
                                <td>{{ is_null($test_progress->getTest()) ? 'тест был удалён' : $test_progress->getTest()->caption; }}</td>
                                <td>
                                    <ul>
                                        @if($test_progress->getTest())
                                            @foreach($test_progress->getTest()->getQuestions() as $question)
                                            <li>{{ $question }}</li>
                                            @endforeach
                                        @endif
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
                                <td>
                                    <form method="POST" action="{{ route('tests_progress.destroy', $test_progress) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger" type="submit" onclick="return confirm('Действительно удалить пройденный тест?')">
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

@endsection
