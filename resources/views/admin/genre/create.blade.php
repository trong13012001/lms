<x-admin-layout>
    <x-slot name="title">
        Thêm thể loại
    </x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.genre.create') }}
    </x-slot>
    <form method="POST" action="{{ route('admin.genre.store') }}" enctype="multipart/form-data" id="book-form" >
        @csrf
        <div class="row">
            <div class="col-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            {{-- <model-add :relic="{{ json_encode($relic) }}" :exhibit="{{ json_encode($exhibit) }}" name="Loại tài liệu"></model-add> --}}

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Thể loại <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                        placeholder="Nhập thể loại " value="{{ old('name') }}" />
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Giới thiệu thể loại</label>
                                    <textarea rows="3" class="mb-3 d-none" name="description" id="description" placeholder="Nhập giới thiệu thể loại ">{{ old('description') }}</textarea>
                                </div>
                            </div>

                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-2 px-5" id="submitButton">Thêm thể loại</button>
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
