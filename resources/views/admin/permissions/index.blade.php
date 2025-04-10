<x-admin-layout>
    <x-slot name="title">Phân quyền</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.permissions.index') }}
    </x-slot>
    <div class="card">
        <div class="roles px-3 py-4">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn bg-gd-aqua text-white text-sm mb-0" data-toggle="click-ripple"
                    data-bs-toggle="modal" data-bs-target="#createPermissions">
                    <i class="si si-user-follow me-1"></i>Thêm phân quyền
                </button>
            </div>
            <div class="table-responsive">
                <form method="GET" action="{{ route('admin.permissions.index') }}">
                    <div class="d-flex align-items-center mb-3">
                        <div class="col-4">
                            <input type="text" class="form-control" name="des" value="{{ Request::get('des') }}" placeholder="Tìm kiếm mô tả phân quyền"/>
                        </div>
                        <div class="ms-3">
                            <button type="submit" class="btn btn-primary me-1 px-3" data-toggle="click-ripple"><i class="fa fa-filter me-1"></i>Lọc</button>
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary ms-1 px-3" data-toggle="click-ripple"><i class="fa fa-filter-circle-xmark me-1"></i>Bỏ lọc</a>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered table-striped table-vcenter mb-0">
                    <thead>
                        <tr>
                            <th style="width: 350px">Tên phân quyền</th>
                            <th>Mô tả</th>
                            <th class="text-center" style="width: 200px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permissions as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" href="{{ route('admin.permissions.edit', $item->id) }}">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled"
                                            data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $item->id }}">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                    <x-modal-del id="{{ $item->id }}"  params="{{ $item->id }}"  name="phân quyền" route="admin.permissions.destroy"/>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-gray-500">Không tìm thấy dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $permissions->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="createPermissions" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white">Thêm phân quyền</h5>
                </div>
                <form action="{{ route('admin.permissions.store') }}" method="post">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="mb-3">
                            <label class="form-label">Chọn tên quyền</label>
                            <select class="form-select" name="name">
                                <option value="" disabled selected hidden>Chọn tên quyền</option>
                                @foreach ($listRoute as $route)
                                    <option value="{{ $route }}">{{ $route }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả quyền</label>
                            <input type="text" class="form-control" name="description" placeholder="Nhập mô tả quyền" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-hero btn-light" data-bs-dismiss="modal" data-toggle="click-ripple">
                            <span class="d-none d-sm-block">Huỷ</span>
                        </button>
                        <button type="submit" class="btn btn-hero btn-success btn-sm" data-bs-dismiss="modal" data-toggle="click-ripple">
                            <span class="d-none d-sm-block">Thêm phân quyền</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
