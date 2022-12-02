@extends('layouts.app')
@section('title')
    {{ $course->caption }}
@endsection

@section('content')
    <div class="mt-5 mb-3"></div>
    <div class="row">
        <h1>{{ $course->caption }}</h1>
        <hr>
    </div>
    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-center">
                <img src="{{ $course->getImageSrc() }}" class="img-fluid">
            </div>
        </div>
        <div class="col">
            {{ $course->description }}
        </div>
    </div>
    <div class="row">
        <div class="col">
            <hr>
            <h3>Уроки</h3>
        </div>
    </div>
    @auth('web')
        <div class="row">
            <div class="col">
                <div class="accordion" id="courseLessons">
                    @foreach($course->getLessons() as $lesson)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#lesson_{{ $loop->index+1 }}" aria-expanded="false" aria-controls="collapseTwo">

                                    @if(Auth::user()->isLessonCompleted($lesson->id))
                                        <label class="me-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                            </svg>
                                        </label>
                                    @endif
                                    Урок №{{ $loop->index+1 }}. {{ $lesson->caption }}
                                </button>
                            </h2>
                            <div id="lesson_{{ $loop->index+1 }}" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#courseLessons">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        {!! $lesson->content !!}
                                    </div>
                                    <div>
                                        <div class="d-flex justify-content-end">
                                            @if(!Auth::user()->isLessonCompleted($lesson->id))
                                                <form method="POST" action="{{ route('complete_lesson', $lesson) }}">
                                                    @csrf
                                                    <button class="btn btn-outline-primary" title="Пометить пройденным">
                                                        Отметить пройденным
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endauth
    <div class="row">
        <div class="col">
            <hr>
            <h3>Доступные тесты</h3>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Курс</th>
                    <th>Вопросы</th>
                    <th>Дата создания</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($course->getTests() as $test)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
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
                        <td>
                            @if(Auth::user()->isTestPassed($test->id))
                                @php $test_progress = \App\Models\TestProgress::all()->where('test', '=', $test->id)->first() @endphp
                                @isset($test_progress)
                                    @if($test_progress->status === "TO CHECK")
                                        Твой тест отпарвлен на проверку
                                    @elseif($test_progress->status === "CHECKING")
                                        Твой тест проверяют
                                    @elseif($test_progress->status === "CHECKED")
                                        Твоя оценка по тесту: {{ $test_progress->mark }}
                                    @endif
                                @endisset
                            @else
                                <a class="btn btn-primary" href="{{ route('passing_test', $test) }}">Пройти тест</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
