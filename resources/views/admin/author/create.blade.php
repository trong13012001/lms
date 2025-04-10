<x-admin-layout>
    <x-slot name="title">
        Thêm tác giả
    </x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.author.create') }}
    </x-slot>
    <form method="POST" action="{{ route('admin.author.store') }}" enctype="multipart/form-data" id="book-form" >
        @csrf
        <div class="row">
            <div class="col-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Tên tác giả <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                        placeholder="Nhập tên tác giả " value="{{ old('name') }}" />
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Giới thiệu tác giả</label>
                                    <textarea rows="3" class="mb-3 d-none" name="description" id="description" placeholder="Nhập giới thiệu tác giả ">{{ old('description') }}</textarea>
                                </div>
                            </div>

                        </div>
                        @if(auth()->user()->can('admin.author.store'))
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-2 px-5" id="submitButton">Thêm tác giả</button>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="card">
                    <div class="card-body">
                        <div class="body-card">
                            <div class="form-group mb-3">
                                <upload-file title="Ảnh đại diện" name="image" id="image" type="image"
                                    url="{{ route('unisharp.lfm.show') }}" value="{{ old('image') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <x-slot name="scripts">
        <script src="/themes/js/ckeditor.js"></script>
        <script src="/themes/js/plugin-ck-upload-img.js"></script>
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
