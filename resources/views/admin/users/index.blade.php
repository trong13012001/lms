<x-admin-layout>
    <x-slot name="title">Tài khoản</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.users.index') }}
    </x-slot>
    <div class="card">
        <div class="users px-3 py-4">
            <div class="d-flex justify-content-end">
                {{-- <button type="button" class="btn btn-hero btn-success me-1 mb-3" data-toggle="click-ripple"
                    data-bs-toggle="modal" data-bs-target="#createRole">
                    <i class="si si-user-follow me-1"></i>Thêm tài khoản
                </button> --}}
                <a href="{{ route('admin.users.create') }}" class="btn bg-gd-aqua text-white text-sm mb-0">
                    <i class="si si-user-follow me-1"></i>
                    Thêm tài khoản
                </a>
            </div>
            <div class="table-responsive">
                <form method="GET" action="{{ route('admin.users.index') }}">
                    <div class="d-flex align-items-center mb-3">
                        <div class="col-4">
                            <input type="text" class="form-control" name="username" value="{{ Request::get('username') }}" placeholder="Tìm kiếm tên tài khoản"/>
                        </div>
                        <div class="ms-3">
                            <button type="submit" class="btn btn-primary me-1 px-3" data-toggle="click-ripple"><i class="fa fa-filter me-1"></i>Lọc</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-1 px-3" data-toggle="click-ripple"><i class="fa fa-filter-circle-xmark me-1"></i>Bỏ lọc</a>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered table-striped table-vcenter mb-0">
                    <thead>
                        <tr>
                            <th>Tên tài khoản</th>
                            <th>Họ và Tên</th>
                            <th>Email</th>
                            <th class="text-center" style="width: 200px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $item)
                            <tr>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td class="text-center">
                                    @if ($item->id != 1)
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" href="{{ route('admin.users.show', $item->id) }}">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled"
                                            data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $item->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <x-modal-del id="{{ $item->id }}" name="Tài khoản" params="{{$item->id}}" route="admin.users.destroy" page="{{ $users->currentPage() }}" username="{{ $item->username }}"/>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500">Không tìm thấy dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {!! $users->links() !!}
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="createRole" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white">Thêm tài khoản</h5>
                </div>
                <form action="{{ route('admin.register-users') }}" method="post" id="regForm">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="mb-3">
                            <label class="form-label">Tên tài khoản <span class="text-danger" aria-hidden="true">*</span></label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Nhập tên tài khoản" />
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Họ và tên <span class="text-danger" aria-hidden="true">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nhập họ và tên" />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger" aria-hidden="true">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Nhập email" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày sinh</label>
                            <input type="text" class="form-control js-masked-date" name="birthday" id="birthday" placeholder="dd/mm/yyyy"/>
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
                            <input type="text" class="form-control" name="position" placeholder="Nhập chức vụ" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nơi làm việc</label>
                            <input type="text" class="form-control" name="work_place" placeholder="Nhập nơi làm việc" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu <span class="text-danger" aria-hidden="true">*</span></label>
                            <div class="input-group">
                                <input id="input-pass" type="text" class="form-control bg-gray-light  @error('password') is-invalid @enderror" name="password" placeholder="Nhập mật khẩu" readonly/>
                                <button class="btn btn-warning text-white" type="button" onclick="genPassword()" data-toggle="click-ripple">Tạo MK ngẫu nhiên</button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Xác nhận mật khẩu <span class="text-danger" aria-hidden="true">*</span></label>
                            <input id="input-password" type="text" class="form-control bg-gray-light @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Xác nhận mật khẩu" readonly/>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-hero btn-outline-dark" data-bs-dismiss="modal" data-toggle="click-ripple" onclick="resetForm()">
                            <span class="d-none d-sm-block">Huỷ</span>
                        </button>
                        <button type="submit" class="btn btn-hero btn-success btn-sm" data-toggle="click-ripple">
                            <span class="d-none d-sm-block">Thêm tài khoản</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
        <script>
            function resetForm() {
                document.getElementById("regForm").reset();
            }
        </script>
    </x-slot>
</x-admin-layout>
