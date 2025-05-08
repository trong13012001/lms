<x-admin-layout>
    <x-slot name="title">Thông tin tài khoản</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.users.show', $user) }}
    </x-slot>
    <div class="edit-user">
        <form method="POST" action="{{ route('update-profile', $user->id) }}">
            @csrf
            @method('PUT')
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Thay đổi thông tin tài khoản</h3>
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
                                <label class="form-label ">Tên tài khoản <span class="text-danger" aria-hidden="true">*</span></label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Nhập tên tài khoản" value="{{old('username',$user['username'])  }}"/>
                            </div>
                            @error('username')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                            <div class="mb-3">
                                <label class="form-label ">Họ và tên <span class="text-danger" aria-hidden="true">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nhập họ và tên" value="{{ old('name',$user['name'])  }}"/>
                            </div>
                            @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                            <div class="mb-3">
                                <label class="form-label ">Email <span class="text-danger" aria-hidden="true">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror @if(auth()->user()->hasRole('admin'))@else bg-gray-light @endif" name="email" placeholder="Nhập email" value="{{ old('email',$user['email']) }}" @if(auth()->user()->hasRole('admin'))@else readonly @endif/>
                            </div>
                            @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                            <div class="mb-3">
                                <label class="form-label">Ngày sinh</label>
                                <input type="text" class="form-control js-masked-date" name="birthday" id="birthday" placeholder="dd/mm/yyyy" value="{{ old('birthday',$user['birthday'])  }}"/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Giới tính</label>
                                <select class="form-select" name="gender">
                                    <option value="" disabled selected hidden>Chọn giới tính</option>
                                    <option value="1" {{ old('gender',$user['gender']) == 1 ? 'selected' : '' }}>Nam</option>
                                    <option value="2" {{  old('gender',$user['gender']) ? 'selected' : '' }}>Nữ</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Chức vụ</label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror" name="position" placeholder="Nhập chức vụ" value="{{  old('position',$user['position'])}}" />
                                @error('position')
                                     <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nơi làm việc</label>
                                <input type="text" class="form-control @error('work_place') is-invalid @enderror" name="work_place" placeholder="Nhập nơi làm việc" value="{{  old('work_place',$user['work_place']) }}"/>
                                @error('work_place')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
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
                <h3 class="block-title">Vai trò tài khoản</h3>
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
                                                <p class="my-4 text-lg fw-bold">Bạn chắc chắn muốn gỡ vai trò này khỏi tài khoản ?</p>
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
                        <p class="mb-0 text-sm mt-2">tài khoản chưa có vai trò nào</p>
                    @endforelse
                @endif
                <div class="mt-5">
                    <div class="row">
                        <div class="col-6">
                            <div class="fw-bold text-sm mb-2">Thêm vai trò cho tài khoản:</div>
                            <form method="POST" action="{{ route('admin.users.roles', $user->id) }}">
                            @csrf
                                <select class="form-select @error('role') is-invalid @enderror" name="role">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
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
                <form id="password-reset-form" action="{{ route('admin.resetPasswordUser', $user->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <label for="input-password">Mật khẩu</label>
                        <div class="input-group mb-2">
                            <input id="password-reset" type="text" name="password" placeholder="Nhập mật khẩu mới" class="form-control bg-gray-light">
                            <button type="button" class="btn btn-warning text-white" onclick="genPassword()" data-toggle="click-ripple">Tạo MK ngẫu nhiên</button>
                        </div>
                        <p class="error-message mb-0" id="error-password"></p>
                        <button type="submit" class="btn btn-hero btn-primary btn-sm mt-3">Đặt lại mật khẩu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="css">
        <style>
            .bg-custom {
                background-color: transparent !important;
                box-shadow: none !important;
            }
        </style>
    </x-slot>
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const passwordResetForm = document.getElementById('password-reset-form');
                const modal = document.getElementById('changePassword');
                const bootstrapModal = new bootstrap.Modal(modal);

                passwordResetForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const errorElement = document.getElementById('error-password');
                    const submitButton = this.querySelector('button[type="submit"]');

                    submitButton.disabled = true;
                    errorElement.textContent = '';

                    fetch(this.action, {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            bootstrapModal.hide();
                            showNotify('success', data.message);
                            this.reset();
                        } else if (data.errors && data.errors.password) {
                            errorElement.textContent = data.errors.password[0];
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        submitButton.disabled = false;
                    });
                });

                modal.addEventListener('hidden.bs.modal', function() {
                    const form = document.getElementById('password-reset-form');
                    const errorElement = document.getElementById('error-password');
                    form.reset();
                    errorElement.textContent = '';
                });

                function showNotify(type, message) {
                    const notifyContainer = document.createElement('div');
                    notifyContainer.className = 'notifyjs-wrapper';
                    notifyContainer.innerHTML = `
                        <div x-data="{ show:  true  }" x-init="setTimeout(() => { show = true }, 500)" x-show="show" x-transition:enter="transform ease-out duration-300 transition" x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="pointer-events-auto w-full max-w-sm overflow-hidden shadow-lg rounded-lg border-l-4 bg-white border-green-500" style="width: 380px;/* height: 75px; */position: fixed;right: 20px;top: 70px;">
                            <div class="relative rounded-lg shadow-xs overflow-hidden">
                                <div style="padding: 1rem">
                                    <div class="flex items-start">
                                        <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <div class="ml-4 w-0 flex-1">
                                            <p class="text-sm leading-5 font-medium capitalize text-slate-900" style="margin-bottom: 0;">Thông báo</p>
                                            <p class="mt-1 text-sm leading-5 text-slate-500" style="margin-bottom: 0;">${message}</p>
                                        </div>
                                    <div class="ml-4 flex shrink-0">
                                        <button @click="show = false;" class="inline-flex rounded-md text-slate-400 hover:text-slate-500 focus:outline-none">
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                    document.body.appendChild(notifyContainer);

                    setTimeout(() => {
                        notifyContainer.remove();
                    }, 3000);
                }
            });
        </script>
    </x-slot>
</x-admin-layout>
