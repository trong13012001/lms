<x-admin-layout>
    <x-slot name="title">Thông tin thành viên</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.users.show', $user) }}
    </x-slot>
    <div class="edit-user">
        <form method="POST" action="{{ route('update-profile', $user->id) }}">
            @csrf
            @method('PUT')
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Thay đổi thông tin thành viên</h3>
                    <div class="block-options">
                        <button type="button"
                            data-toggle="click-ripple" class="btn btn-sm btn-hero btn-danger"
                            data-bs-toggle="modal" data-bs-target="#changePassword">Đổi mật khẩu</button>
                    </div>
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
                                <input type="email" class="form-control @if(->user()->hasRole('admin'))@else bg-gray-light @endif" name="email" placeholder="Nhập email" value="{{ $user['email'] }}" @if(->user()->hasRole('admin'))@else readonly @endif/>
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
        <div class="block block-rounded mt-5">
            <div class="block-header block-header-default">
                <h3 class="block-title">Vai trò thành viên</h3>
            </div>
            <div class="block-content pb-4">
                <div class="fw-bold text-sm">Các vai trò hiện tại:</div>
                @if ($user->roles)
                    @forelse ($user->roles as $user_role)
                        <span class="badge bg-gd-primary mt-2 me-3"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#del-role-{{ $user_role->id }}">
                            {{ $user_role->name }}
                            <i class="fa fa-xmark ms-2 fs-6"></i>
                        </span>
                        <div class="modal fade modal-del" id="del-role-{{ $user_role->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="block block-rounded block-themed block-transparent mb-0">
                                        <div class="block-header bg-danger p-3">
                                            <h5 class="modal-title text-white">Gỡ vai trò</h5>
                                        </div>
                                        <div class="block-content">
                                            <div class="text-center" style="margin-top: 20px">
                                                <i class="si si-info text-danger" style="font-size: 60px"></i>
                                                <p class="my-4 text-lg fw-bold">Bạn chắc chắn muốn gỡ vai trò này khỏi thành viên ?</p>
                                            </div>
                                        </div>
                                        <div class="block-content block-content-full bg-body d-flex justify-content-end p-3">
                                            <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">
                                                <span class="d-none d-sm-block">Huỷ</span>
                                            </button>
                                            <form method="POST" action="{{ route('admin.users.roles.remove', [$user->id, $user_role->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger ms-1" data-bs-dismiss="modal">
                                                    <span class="d-none d-sm-block">Xác nhận</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="mb-0 text-sm mt-2">Thành viên chưa có vai trò nào</p>
                    @endforelse
                @endif
                <div class="mt-5">
                    <div class="row">
                        <div class="col-6">
                            <div class="fw-bold text-sm mb-2">Thêm vai trò cho thành viên:</div>
                            <form method="POST" action="{{ route('admin.users.roles', $user->id) }}">
                            @csrf
                                <select class="form-select" name="role">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary btn-hero btn-sm mt-3">Thêm vai trò</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="changePassword" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Đặt lại mật khẩu</h4>
                </div>
                <form action="{{ route('admin.resetPasswordUser', $user->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <label for="input-password">Mật khẩu</label>
                        <div class="input-group mb-2">
                            <input id="password-reset" type="text" name="password" placeholder="Nhập mật khẩu mới" class="form-control bg-gray-light">
                            <button type="button" class="btn btn-warning text-white" onclick="genPassword()" data-toggle="click-ripple">Tạo MK ngẫu nhiên</button>
                        </div>
                        <button type="submit" class="btn btn-hero btn-primary btn-sm mt-3">Đặt lại mật khẩu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script>
            var password = document.getElementById("password-reset");

            function genPassword() {
                var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                var passwordLength = 12;
                var password = "";
            for (var i = 0; i <= passwordLength; i++) {
                var randomNumber = Math.floor(Math.random() * chars.length);
                password += chars.substring(randomNumber, randomNumber +1);
            }
                document.getElementById("password-reset").value = password;
            }
        </script>
    </x-slot>
</x-admin-layout>
