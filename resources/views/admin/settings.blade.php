@extends('admin.layouts.app')
@section('title', 'Настройки')

@section('content')

    <div class="row mt-5"></div>
    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Название сайта
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('title_update', \App\Models\Settings::getSettings()) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Текущее название сайта</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ \App\Models\Settings::getTitle() }}">
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Изменить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Изменить пароль админа
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password_update', Auth::user()) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Новый пароль</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Изменить пароль</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
