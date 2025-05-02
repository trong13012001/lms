<x-admin-layout>
    <x-slot name="title">Thông tin phân quyền</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.permissions.show', $permission) }}
    </x-slot>
    <div class="role-edit">
        <form method="POST" action="{{ route('admin.permissions.update', $permission) }}">
            @csrf
            @method('PUT')
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Sửa phân quyền</h3>
                </div>
                <div class="block-content">
                    <div class="row justify-content-center py-sm-3 py-md-5">
                        <div class="col-sm-10 col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Tên phần quyền</label>
                                <select class="form-select" name="name" value="{{ $permission->name }}">
                                    @foreach ($listRoute as $route)
                                        <option value="{{ $route }}">{{ $route }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mô tả quyền</label>
                                <input type="text" class="form-control" name="description" placeholder="Nhập mô tả quyền" value="{{ $permission->description }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light text-end">
                    <button type="submit" class="btn btn-primary btn-hero btn-sm" data-toggle="click-ripple">
                        <i class="fa fa-check opacity-50 me-1"></i>Xác nhận
                    </button>
                </div>
            </div>
        </form>

        {{-- <div class="block block-rounded mt-5">
            <div class="block-header block-header-default">
                <h3 class="block-title">Quyền thuộc vai trò</h3>
            </div>
            <div class="block-content pb-4">
                <div class="fw-bold text-sm">Các vai trò có quyền này:</div>
                @if ($permission->roles)
                    @forelse ($permission->roles as $permission_role)
                        <span class="badge bg-gd-primary mt-2 me-3"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#del-role-{{ $permission_role->id }}">
                            {{ $permission_role->name }}
                            <i class="fa fa-xmark ms-2 fs-6"></i>
                        </span>
                        <div class="modal fade modal-del" id="del-role-{{ $permission_role->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="block block-rounded block-themed block-transparent mb-0">
                                        <div class="block-header bg-danger p-3">
                                            <h5 class="modal-title text-white">Gỡ vai trò</h5>
                                        </div>
                                        <div class="block-content">
                                            <div class="text-center" style="margin-top: 20px">
                                                <i class="si si-info text-danger" style="font-size: 60px"></i>
                                                <p class="my-4 text-lg fw-bold">Bạn chắc chắn muốn gỡ vai trò này ?</p>
                                            </div>
                                        </div>
                                        <div class="block-content block-content-full bg-body d-flex justify-content-end p-3">
                                            <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">
                                                <span class="d-none d-sm-block">Huỷ</span>
                                            </button>
                                            <form method="POST" action="{{ route('admin.permissions.roles.remove', [$permission->id, $permission_role->id]) }}">
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
                        <p class="mb-0 text-sm mt-2">Chưa có vai trò nào</p>
                    @endforelse
                @endif
                <div class="mt-5">
                    <div class="row">
                        <div class="col-6">
                            <div class="fw-bold text-sm mb-2">Thêm vai trò cho quyền:</div>
                            <form method="POST" action="{{ route('admin.permissions.roles', $permission->id) }}">
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
        </div> --}}
    </div>

</x-admin-layout>
