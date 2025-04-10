<x-admin-layout>
    <x-slot name="title">Thông tin tài khoản</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('edit-profile') }}
    </x-slot>
    <div class="edit-profile">
        <form method="POST" action="{{ route('update-profile', auth()->user()->id) }}">
            @csrf
            @method('PUT')
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Thay đổi thông tin</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center py-sm-3 py-md-5">
                        <div class="col-sm-10 col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Tên tài khoản</label>
                                <input type="text" class="form-control" name="username" placeholder="Nhập tên tài khoản" value="{{ $user['username'] }}"/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" name="name" placeholder="Nhập họ và tên" value="{{ $user['name'] }}"/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control @if(auth()->user()->hasRole('admin'))@else bg-gray-light @endif" name="email" placeholder="Nhập email" value="{{ $user['email'] }}" @if(auth()->user()->hasRole('admin'))@else readonly @endif/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ngày sinh</label>
                                <input type="text" class="form-control js-masked-date" name="birthday" id="birthday" placeholder="dd/mm/yyyy" value="{{ $user['birthday'] }}"/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Giới tính</label>
                                <select class="form-select" name="gender">
                                    <option value="" disabled selected hidden>Chọn giới tính</option>
                                    <option value="1" {{ $user['gender'] == 1 ? 'selected' : '' }}>Nam</option>
                                    <option value="2" {{ $user['gender'] == 2 ? 'selected' : '' }}>Nữ</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Chức vụ</label>
                                <input type="text" class="form-control" name="position" placeholder="Nhập chức vụ" value="{{ $user['position'] }}" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nơi làm việc</label>
                                <input type="text" class="form-control" name="work_place" placeholder="Nhập nơi làm việc" value="{{ $user['work_place'] }}"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light text-center">
                    <button type="submit" class="btn btn-primary btn-hero btn-sm" data-toggle="click-ripple">
                        <i class="fa fa-check opacity-50 me-1"></i> Xác nhận
                    </button>
                </div>
            </div>
        </form>
        <form method="POST" action="{{ route('change-password') }}">
            @csrf
            @method('PUT')
            <div class="block block-rounded mt-5">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Thay đổi mật khẩu</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center py-sm-3 py-md-5">
                        <div class="col-sm-10 col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu hiện tại</label>
                                <input type="password" class="form-control" name="old_password" placeholder="Nhập mật khẩu hiện tại"/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu mới"/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control" name="confirm_password" placeholder="Nhập lại mật khẩu mới"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light text-center">
                    <button type="submit" class="btn btn-primary btn-hero btn-sm" data-toggle="click-ripple">
                        <i class="fa fa-check opacity-50 me-1"></i> Xác nhận
                    </button>
                </div>
            </div>
        </form>
    </div>
    <x-slot name="css">
        <style>
            .bg-custom {
                background-color: transparent !important;
                box-shadow: none !important;
            }
        </style>
    </x-slot>
</x-admin-layout>
