<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('admin_index') }}">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('tests.index') }}">Тесты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('admin_settings') }}">Настройки</a>
                </li>
            </ul>
            <div class="d-flex">
                <a type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                    Добавить курс
                </a>
                @auth('admin')
                    <form method="POST" action="{{ route('logoutAdmin') }}">
                        @csrf
                        <button class="btn btn-outline-danger me-2" type="submit">Выйти</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</nav>
