<x-admin-layout>
    <x-slot name="title">Nhãn</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.tag.index') }}
    </x-slot>
    <div class="card">
        <div class="card-body">
            <div class="header-card mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"></h5>
                    @if (auth()->user()->can('admin.tag.store'))
                        <div>
                            <button type="button" class="btn bg-gd-aqua text-white text-sm mb-0" data-bs-toggle="modal"
                                data-bs-target="#createBook">
                                <i class="tf-icons fa fa-circle-plus me-1"></i>
                                Thêm nhãn
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="body-card">
                <form method="GET" action="{{ route('admin.tag.index') }}" id="filterForm">
                    <div class="row align-items-center mb-3">
                        <div class="col-4">
                            <input type="text" class="form-control" name="name" value="{{ Request::get('name') }}"
                                placeholder="Tìm kiếm nhãn" />
                        </div>
                        <div class="col-5">
                            <button type="submit" class="btn bg-gd-sea-op text-white me-2"><i
                                    class="fa fa-filter me-1"></i>Lọc</button>
                            <a href="{{ route('admin.tag.index') }}" class="btn bg-gd-fruit-op text-white ms-2"><i
                                    class="fa fa-filter-circle-xmark me-1"></i>Bỏ lọc</a>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th width="15px">#</th>
                                <th>Nhãn</th>
                                <th class="text-center" style="width:150px">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($tags as $item)
                                <tr>
                                    <td>{{ ($tags->currentPage() - 1) * $tags->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <div class="btn-group" style="gap: 10px;">
                                            @if (auth()->user()->can('admin.tag.update'))
                                                <button type="button"
                                                    class="btn btn-sm btn-alt-success js-bs-tooltip-enabled rounded-0"
                                                    data-bs-target="#editBook-{{ $item->id }}"
                                                    data-bs-toggle="modal">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </button>
                                            @endif
                                            @if (auth()->user()->can('admin.tag.destroy'))
                                                <button type="button"
                                                    class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled rounded-0"
                                                    data-bs-toggle="modal" aria-label="Delete"
                                                    data-bs-target="#modal-delete-{{ $item->id }}">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                        <x-modal-del id="{{ $item->id }}"  params="{{ $item->id }}" name="nhãn"
                                            route="admin.tag.destroy" />
                                        <div class="modal fade text-left" id="editBook-{{ $item->id }}"
                                            tabindex="-1">
                                            <div class="modal-dialog modal-dialog-popout modal-dialog-centered modal-dialog-scrollable modal-custom"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-gd-sea-op">
                                                        <h4 class="modal-title text-white">Sửa nhãn</h4>
                                                    </div>
                                                    <form id="tag-update-form-{{ $item->id }}"
                                                        action="{{ route('admin.tag.update', $item->id) }}"
                                                        method="post">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-body pb-0">
                                                            <div class="mb-3">
                                                                <label class="form-label">Nhãn</label>
                                                                <input id="name-{{ $item->id }}" type="text"
                                                                    class="form-control" name="name"
                                                                    value="{{ $item->name }}"
                                                                    placeholder="Nhập nhãn" />
                                                                <p id="error-name-{{ $item->id }}"
                                                                    class="error-message"
                                                                    style="color: red; display: none;">
                                                                    Nhãn không được bỏ trống</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-label-secondary me-1"
                                                                data-bs-dismiss="modal">
                                                                <span class="d-none d-sm-block">Huỷ</span>
                                                            </button>
                                                            <button type="submit" id="submitUpdateButton"
                                                                class="btn bg-gd-sea-op text-white ms-1">
                                                                <span class="d-none d-sm-block">Sửa nhãn</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-gray-500">Không tìm thấy dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="db-pagination">
                    {{ $tags->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="createBook" tabindex="-1">
        <div class="modal-dialog modal-dialog-popout modal-dialog-centered modal-dialog-scrollable modal-custom"
            role="document">
            <div class="modal-content">
                <div class="modal-header bg-gd-sea-op">
                    <h4 class="modal-title text-white">Thêm nhãn</h4>
                </div>
                <form id="tag-form" action="{{ route('admin.tag.store') }}" method="post">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="mb-3">
                            <label class="form-label">Nhãn</label>
                            <input id="name" type="text" class="form-control" name="name"
                                placeholder="Nhập nhãn" />
                            <p id="error-name" class="error-message" style="color: red; display: none;">
                                Nhãn không được bỏ trống</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary me-1" data-bs-dismiss="modal">
                            <span class="d-none d-sm-block">Huỷ</span>
                        </button>
                        <button type="submit" id="submitButton" class="btn bg-gd-sea-op text-white ms-1">
                            <span class="d-none d-sm-block">Thêm nhãn</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script src="/themes/js/vldTH.js"></script>

        <script>
            const fields_create = [{
                input: 'name',
                error: 'error-name'
            }, ];
            document.addEventListener('DOMContentLoaded', function(event) {
                vldTH('tag-form', fields_create, 'submitButton');

            })

            @foreach ($tags as $item)
                const fields_update_{{ $item->id }} = [{
                    input: 'name-{{ $item->id }}',
                    error: 'error-name-{{ $item->id }}'
                }, ];
                document.addEventListener('DOMContentLoaded', function(event) {
                    vldTH('tag-update-form-{{ $item->id }}', fields_update_{{ $item->id }},
                        'submitUpdateButton');
                })
            @endforeach
        </script>
    </x-slot>
</x-admin-layout>
