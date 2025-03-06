<x-admin-layout>
    <x-slot name="title">Vai trò</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.roles.index') }}
    </x-slot>
    <div class="roles px-3 py-4">
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-hero btn-success me-1 mb-3" data-toggle="click-ripple"
                data-bs-toggle="modal" data-bs-target="#createRole">
                <i class="si si-user-follow me-1"></i>Thêm vai trò
            </button>
        </div>
        <div class="table-responsive">
            <form method="GET" action="{{ route('admin.roles.index') }}">
                <div class="d-flex align-items-center mb-3">
                    <div class="col-4">
                        <input type="text" class="form-control" name="name" value="{{ Request::get('name') }}" placeholder="Tìm kiếm tên vai trò"/>
                    </div>
                    <div class="ms-3">
                        <button type="submit" class="btn btn-primary me-1 px-3" data-toggle="click-ripple"><i class="fa fa-filter me-1"></i>Lọc</button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary ms-1 px-3" data-toggle="click-ripple"><i class="fa fa-filter-circle-xmark me-1"></i>Bỏ lọc</a>
                    </div>
                </div>
            </form>
            <table class="table table-bordered table-striped table-vcenter mb-0">
                <thead>
                    <tr>
                        <th>Tên vai trò</th>
                        <th class="text-center" style="width: 200px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" href="{{ route('admin.roles.edit', $item->id) }}">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled"
                                        data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $item->id }}">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                                <x-modal-del id="{{ $item->id }}" name="vai trò" route="admin.roles.destroy"/>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $roles->links() !!}
        </div>
    </div>
    <div class="modal fade text-left" id="createRole" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white">Thêm vai trò</h5>
                </div>
                <form action="{{ route('admin.roles.store') }}" method="post">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="mb-3">
                            <label class="form-label">Tên vai trò</label>
                            <input type="text" class="form-control" name="name" placeholder="Nhập tên vai trò" />
                        </div>
                        @error('name')
                            @php
                                notify()->error('Tên vai trò không được để trống hoặc nhỏ hơn 3 kí tự','Thông báo');
                            @endphp
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-hero btn-light" data-bs-dismiss="modal" data-toggle="click-ripple">
                            <span class="d-none d-sm-block">Huỷ</span>
                        </button>
                        <button type="submit" class="btn btn-hero btn-success btn-sm" data-bs-dismiss="modal" data-toggle="click-ripple">
                            <span class="d-none d-sm-block">Thêm vai trò</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
