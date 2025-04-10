<x-admin-layout>
    <x-slot name="title">
        Thêm sách
    </x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.book.item.create',$book->id) }}
    </x-slot>
    <form method="POST" action="{{ route('admin.book.item.store',$book->id) }}" enctype="multipart/form-data" id="book-form">
        @csrf
        <input type="hidden" name="book_id" value="{{$book->id}}">
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
                                                @foreach ($publishers as $publisher)
                                                    <option value="{{ $publisher['id'] }}">{{ $publisher['name'] }}</option>
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
                                        id="book_code" name="book_code" placeholder="Nhập ISBN "
                                        value="{{ old('book_code') }}" />
                                    @error('book_code')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="location">Vị trí để sách<span
                                            class="text-danger">*</span></label>
                                            <input class="form-control" name="location" id="location" placeholder="Nhập vị trí để sách" value="{{old('location') }}">


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
                                            placeholder="Y-m-d" value="{{ old('published_at') }}">

                                    @error('published_at')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-2 px-5" id="submitButton">Thêm
                                sách</button>
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
