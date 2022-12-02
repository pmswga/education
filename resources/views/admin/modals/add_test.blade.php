<div class="modal fade" id="addTestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="m-0 p-0" method="POST" action="{{ route('tests.store') }}">
                @isset($course)
                    <input type="hidden" name="course" value="{{ $course->id }}">
                @endisset
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Добавление теста</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        @error('course')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
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
                        <label class="form-label">Вопросы</label>
                        <textarea name="questions" class="form-control @error('questions') is-invalid @enderror" cols="30" rows="10">{{ old('questions') }}</textarea>
                        @error('questions')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Добавить тест</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
