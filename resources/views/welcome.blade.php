@extends('layouts.app')
@section('title', 'Главная страница')


@section('content')

    <div class="mt-5 mb-3"></div>
    <div class="row">
        <h1>Курсы</h1>
        <hr>
    </div>
    <div class="row">
        <div class="container text-center">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                @foreach($courses as $course)
                    <div class="col mb-3">
                        <div class="d-flex justify-content-center">
                            <div class="card" style="width: 18rem;">
                                <img src="{{ \Illuminate\Support\Facades\Storage::url('cover/' .  basename($course->image))  }}" class="card-img-top" alt="course">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $course->caption }}</h5>
                                    <p class="card-text">{{ $course->short_description }}</p>
                                    <a href="{{ route('course_show', $course) }}" class="btn btn-primary">Перейти</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col">
        </div>
    </div>

@endsection

