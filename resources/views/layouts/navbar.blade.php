<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">{{ \App\Models\Settings::getTitle() }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('index') }}">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('about') }}">О нас</a>
                </li>
            </ul>
            <div class="d-flex">
                @auth('web')
                    <a class="btn btn-outline-primary me-2" href="{{ route('profile') }}">Мой профиль</a>
                    <form method="POST" action="{{ route('logoutUser') }}">
                        @csrf
                        <button class="btn btn-outline-danger me-2" type="submit">Выйти</button>
                    </form>
                @else
                    <a class="btn btn-outline-success me-2" href="{{ route('login') }}">Войти</a>
                    <a class="btn btn-outline-success" href="{{ route('registration') }}">Зарегистрироваться</a>
                @endif
            </div>
        </div>
    </div>
</nav>
