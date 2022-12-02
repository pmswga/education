@extends('layouts.app')
@section('title', 'Прохождение теста')


@section('content')

    <div class="row mt-5"></div>

    @if(Auth::user()->isTestPassed($test->id))
        <div class="row">
            <div class="col">
                @php $test_progress = \App\Models\TestProgress::all()->where('test', '=', $test->id)->first() @endphp
                @isset($test_progress)
                    <p>
                        <b>Твоя оценка:</b> {{ $test_progress->mark }}
                    </p>
                    <p>
                        <b>Комментарий:</b> {{ $test_progress->comment }}
                    </p>
                @endisset
            </div>
        </div>
    @else
        <div class="row mb-3">
            <h1>Тесту по курсу - {{ $test->getCourse()->caption }}</h1>
            <hr>
        </div>
        <div class="row mb-3">
            <form method="POST" action="{{ route('tests_progress.store') }}">
                <input type="hidden" name="test" value="{{ $test->id }}">
                @csrf
                @foreach ($test->getQuestions() as $question)
                    <div class="mb-3">
                        <label>{{ $question }}</label>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control @error('answers[]') is-invalid @enderror" name="answers[]" cols="30" rows="10">{{ @old('answers[]') }}</textarea>
                        @error('answers[]')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                @endforeach
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">Завершить</button>
                </div>
            </form>
        </div>
    @endif



@endsection
