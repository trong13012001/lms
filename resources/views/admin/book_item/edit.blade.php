<x-admin-layout>
    <x-slot name="title">
        Sửa sách
    </x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.book.item.edit',$bookItem->book,$bookItem->id) }}
    </x-slot>
    <form method="POST" action="{{ route('admin.book.item.update', ['book' => $bookItem->book->id, 'item' => $bookItem->id]) }}" enctype="multipart/form-data" id="book-form">
        @csrf
        @method('PUT')
        <input type="hidden" name="book_id" value="{{$bookItem->book->id}}">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="authors[]">Nhà xuất bản<span
                                            class="text-danger">*</span></label>
                                            <select class="choices form-select" name="publisher_id">
                                                <option placeholder>Tìm kiếm hoặc chọn nhà xuất bản</option>
                                                @foreach ($publishers as $item)
                                                <option value="{{ $item['id'] }}" {{ $bookItem->publisher_id == $item['id'] ? 'selected' : '' }}>
                                                    {{ $item['name'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                    @error('publisher_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="book_code">Mã sách<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('book_code') is-invalid @enderror"
                                        id="book_code" name="book_code" placeholder="Nhập mã sách "
                                        value="{{ old('book_code',$bookItem->book_code) }}" />
                                    @error('book_code')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="location">Vị trí để sách<span
                                            class="text-danger">*</span></label>
                                            <input class="form-control @error('location') is-invalid @enderror" name="location" id="location" placeholder="Nhập vị trí để sách" value="{{old('location',$bookItem->location) }}">


                                    @error('location')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">

                                    <label class="form-label" for="published_at">Vị trí để sách<span
                                            class="text-danger">*</span></label>
                                            <input type="text" class="js-flatpickr form-control" name="published_at"
                                            placeholder="Y-m-d" value="{{ old('published_at',$bookItem->published_at) }}">

                                    @error('published_at')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-2 px-5" id="submitButton">Sửa sách</button>
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
