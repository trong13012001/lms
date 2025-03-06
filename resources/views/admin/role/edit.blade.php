<x-admin-layout>
    <x-slot name="title">Thông tin vai trò</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.roles.show', $role) }}
    </x-slot>
    <div class="role-edit">
        <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
            @csrf
            @method('PUT')
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Sửa vai trò</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center py-sm-3 py-md-5">
                        <div class="col-sm-10 col-md-8">
                            <div class="mb-4">
                                <label class="form-label">Tên vai trò</label>
                                <input type="text" class="form-control" name="name" placeholder="Nhập tên vai trò" value="{{ $role->name }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light text-end">
                    <button type="submit" class="btn btn-primary btn-hero btn-sm" data-toggle="click-ripple">
                        <i class="fa fa-check opacity-50 me-1"></i> Xác nhận
                    </button>
                </div>
            </div>
        </form>

        <div class="block block-rounded mt-5">
            <div class="block-header block-header-default">
                <h3 class="block-title">Phân quyền vai trò</h3>
            </div>
            <div class="block-content pb-4">
                <div class="fw-bold text-sm">Các quyền hiện tại:</div>
                @if ($role->permissions)
                    @forelse ($role->permissions as $role_permission)
                        <span class="badge bg-gd-primary mt-2 me-3"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#del-role-{{ $role_permission->id }}">
                            {{ $role_permission->description }}
                            <i class="fa fa-xmark ms-2 fs-6"></i>
                        </span>
                        <div class="modal fade modal-del" id="del-role-{{ $role_permission->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="block block-rounded block-themed block-transparent mb-0">
                                        <div class="block-header bg-danger p-3">
                                            <h5 class="modal-title text-white">Gỡ quyền</h5>
                                        </div>
                                        <div class="block-content">
                                            <div class="text-center" style="margin-top: 20px">
                                                <i class="si si-info text-danger" style="font-size: 60px"></i>
                                                <p class="my-4 text-lg fw-bold">Bạn chắc chắn muốn gỡ quyền này khỏi vai trò ?</p>
                                            </div>
                                        </div>
                                        <div class="block-content block-content-full bg-body d-flex justify-content-end p-3">
                                            <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">
                                                <span class="d-none d-sm-block">Huỷ</span>
                                            </button>
                                            <form method="POST" action="{{ route('admin.roles.permissions.revoke', [$role->id, $role_permission->id]) }}">
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
                        <p class="mb-0 text-sm mt-2">Chưa có quyền nào</p>
                    @endforelse
                @endif
                <div class="mt-5">
                    <div class="row">
                        <div class="col-6">
                            <div class="fw-bold text-sm mb-2">Thêm quyền cho vai trò:</div>
                            <form method="POST" action="{{ route('admin.roles.permissions', $role->id) }}">
                            @csrf
                                <select class="form-select" name="permission">
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}">{{ $permission->name }} - {{ $permission->description }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary btn-hero btn-sm mt-3">Thêm quyền</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
