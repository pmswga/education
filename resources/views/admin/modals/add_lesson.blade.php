<div class="modal fade" id="addLessonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="m-0 p-0" method="POST" action="{{ route('lesson_store') }}" enctype="multipart/form-data">
                @isset($course)
                    <input type="hidden" name="course" value="{{ $course->id }}">
                @endisset
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Добавление урока</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Название</label>
                        <input type="text" name="caption" class="form-control @error('caption') is-invalid @enderror">
                        @error('caption')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Описание</label>
                        <textarea name="content" cols="30" rows="10" class="form-control @error('content') is-invalid @enderror"></textarea>
                        @error('content')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Добавить урок</button>
                </div>
            </form>
        </div>
    </div>
</div>
