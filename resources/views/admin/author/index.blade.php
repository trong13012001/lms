<x-admin-layout>
    <x-slot name="title">Tác giả</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.author.index') }}
    </x-slot>
    <div class="card">
        <div class="card-body">
            <div class="header-card mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"></h5>
                    @if (auth()->user()->can('admin.author.create'))
                        <div>
                            <a href="{{ route('admin.author.create') }}" class="btn bg-gd-aqua text-white text-sm mb-0">
                                <i class="fa fa-circle-plus me-1"></i>
                                Thêm tác giả
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="body-card">
                <form method="GET" action="{{ route('admin.author.index') }}" id="filterForm">
                    <div class="row align-items-center mb-3">
                        <div class="col-4">
                            <input type="text" class="form-control" name="name" value="{{ Request::get('name') }}"
                                placeholder="Tìm kiếm tác giả" />
                        </div>
                        <div class="col-5">
                            <button type="submit" class="btn bg-gd-sea-op text-white me-2"><i
                                    class="fa fa-filter me-1"></i>Lọc</button>
                            <a href="{{ route('admin.author.index') }}" class="btn bg-gd-fruit-op text-white ms-2"><i
                                    class="fa fa-filter-circle-xmark me-1"></i>Bỏ lọc</a>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th width="15px">#</th>
                                <th style="width:150px">Ảnh</th>
                                <th>Tác giả</th>
                                <th class="text-center" style="width:150px">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($authors as $item)
                                <tr>
                                    <td>{{ ($authors->currentPage() - 1) * $authors->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        <img class="img-table" src="{{image($item->image ? $item->image : '/assets/no-image.png', 120, 0)}}" alt="{{ $item->image }}"/>
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" style="gap: 10px;">
                                            @if (auth()->user()->can('admin.author.update'))
                                            <a class="btn btn-sm btn-alt-success rounded-0" href="{{ route('admin.author.edit', $item->id) }}">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                            @endif
                                            @if (auth()->user()->can('admin.author.destroy'))
                                                <button type="button"
                                                    class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled rounded-0"
                                                    data-bs-toggle="modal" aria-label="Delete"
                                                    data-bs-target="#modal-delete-{{ $item->id }}">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                        <x-modal-del id="{{ $item->id }}"  params="{{ $item->id }}"  name="tác giả" route="admin.author.destroy"/>
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
                    {{ $authors->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
