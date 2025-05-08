<x-admin-layout>
    <x-slot name="title">Thêm tài khoản</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.users.create') }}
    </x-slot>
    <div class="create-users">
        <form action="{{ route('admin.register-users') }}" method="post" id="regForm">
            @csrf
            <div class="block block-rounded">
                <div class="block-content">
                    <div class="row justify-content-center py-3">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label class="form-label">Tên tài khoản <span class="text-danger" aria-hidden="true">*</span></label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Nhập tên tài khoản" value="{{ old('username') }}"/>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Họ và tên <span class="text-danger" aria-hidden="true">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nhập họ và tên" value="{{ old('name') }}"/>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger" aria-hidden="true">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Nhập email" value="{{ old('email') }}"/>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ngày sinh</label>
                                <input type="text" class="form-control js-masked-date" name="birthday" id="birthday" placeholder="dd/mm/yyyy" value="{{ old('birthday') }}"/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Giới tính</label>
                                <select class="form-select" name="gender">
                                    <option value="" disabled selected hidden>Chọn giới tính</option>
                                    <option value="1">Nam</option>
                                    <option value="2">Nữ</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Chức vụ</label>
                                <input type="text" class="form-control" name="position" placeholder="Nhập chức vụ" value="{{ old('position') }}"/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nơi làm việc</label>
                                <input type="text" class="form-control" name="work_place" placeholder="Nhập nơi làm việc" value="{{ old('work_place') }}"/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu <span class="text-danger" aria-hidden="true">*</span></label>
                                <div class="input-group">
                                    <input id="input-pass" type="text" class="form-control bg-gray-light  @error('password') is-invalid @enderror" name="password" placeholder="Nhập mật khẩu" readonly value="{{ old('password') }}"/>
                                    <button class="btn btn-warning text-white btn-password" type="button" onclick="genPassword()" data-toggle="click-ripple">Tạo MK ngẫu nhiên</button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Xác nhận mật khẩu <span class="text-danger" aria-hidden="true">*</span></label>
                                <input id="input-password" type="text" class="form-control bg-gray-light @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Xác nhận mật khẩu" readonly value="{{ old('password_confirmation') }}"/>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light text-center">
                    <button type="submit" class="btn btn-hero btn-success btn-sm" data-toggle="click-ripple">
                        Xác nhận
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
            .btn-password {
                border-radius: 0 5px 5px 0 !important;
            }
        </style>
    </x-slot>
    <x-slot name="scripts">
        <script>
            function genPassword() {
                var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                var passwordLength = 12;
                var password = "";
                for (var i = 0; i <= passwordLength; i++) {
                    var randomNumber = Math.floor(Math.random() * chars.length);
                    password += chars.substring(randomNumber, randomNumber + 1);
                }
                document.getElementById("input-pass").value = password;
                document.getElementById("input-password").value = password;
            }
        </script>
    </x-slot>
</x-admin-layout>
