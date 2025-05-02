<x-admin-layout>
    <x-slot name="title">
        Chỉnh sửa sách
    </x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.book.edit', $book) }}
    </x-slot>
    <form method="POST" action="{{ route('admin.book.update', $book->id) }}" enctype="multipart/form-data" id="book-form">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Sách <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Nhập sách"
                                        value="{{ old('name', $book->name) }}" />
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="authors[]">Tác giả<span class="text-danger">*</span></label>
                                    <select class="choices form-select multiple-remove" multiple="multiple" name="authors[]">
                                        <option placeholder>Tìm kiếm hoặc chọn tác giả</option>
                                        @foreach ($authors as $author)
                                            <option value="{{ $author['id'] }}" {{ in_array($author['id'], $book->authors->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                {{ $author['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('authors[]')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="isbn">ISBN<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('isbn') is-invalid @enderror"
                                        id="isbn" name="isbn" placeholder="Nhập ISBN"
                                        value="{{ old('isbn', $book->isbn) }}" />
                                    @error('isbn')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="published_on">Ngày phát hành<span class="text-danger">*</span></label>
                                    <input type="text" class="js-flatpickr form-control" name="published_on"
                                        placeholder="Y-m-d" value="{{ old('published_on', $book->published_on) }}">
                                    @error('published_on')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="description">Giới thiệu sách</label>
                                    <textarea rows="3" class="mb-3" name="description" id="description" placeholder="Nhập giới thiệu sách">{{ old('description', $book->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-2 px-5" id="submitButton">Xác nhận</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="card">
                    <div class="card-body">
                        <div class="body-card">
                            <div class="form-group mb-3">
                                <upload-file title="Ảnh đại diện" name="image" id="image" type="image"
                                    url="{{ route('unisharp.lfm.show') }}" value="{{ old('image', $book->image) }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="header-card mb-3">
                            <h5 class="card-title mb-0">Thể loại</h5>
                        </div>
                        <div class="body-card">
                            <select class="choices form-select multiple-remove" multiple="multiple" name="genres[]">
                                <option placeholder>Tìm kiếm hoặc chọn thể loại</option>
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre['id'] }}" {{ in_array($genre['id'], $book->genres->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $genre['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('genres[]')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="header-card mb-3">
                            <h5 class="card-title mb-0">Nhãn</h5>
                        </div>
                        <div class="body-card">
                            <select class="choices form-select multiple-remove" multiple="multiple" name="tags[]">
                                <option placeholder>Tìm kiếm hoặc chọn nhãn</option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag['id'] }}" {{ in_array($tag['id'], $book->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $tag['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tags[]')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <x-slot name="scripts">
        <script src="/themes/js/ckeditor.js"></script>
        <script src="/themes/js/plugin-ck-upload-img.js"></script>
        {{-- <script src="/themes/js/choices.min.js"></script> --}}

        <script>
            Dashmix.onLoad(() => {
                ClassicEditor
                    .create(document.querySelector('#description'), {
                        extraPlugins: [Base64UploadAdapter],
                    })
                    .catch(error => {
                        console.error('First Editor Error:', error);
                    });
            });
        </script>
    </x-slot>

    <x-slot name="css">
        <style>
            . {
                background-color: transparent !important;
            }

            .form-check-label {
                cursor: pointer !important;
            }
        </style>
    </x-slot>

</x-admin-layout>
