<x-admin-layout>
    <x-slot name="title">Khách hàng</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.customer.index') }}
    </x-slot>
    <div class="card">
        <div class="card-body">
            <div class="header-card mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"></h5>
                    @if (auth()->user()->can('admin.customer.store'))
                        <div>
                            <a href="{{ route('admin.customer.create') }}" class="btn bg-gd-aqua text-white text-sm mb-0">
                                <i class="fa fa-circle-plus me-1"></i>
                                Thêm khách hàng
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="body-card">
                <form method="GET" action="{{ route('admin.customer.index') }}" id="filterForm">
                    <div class="row align-items-center mb-3">
                        <div class="col-4">
                            <input type="text" class="form-control" name="name" value="{{ Request::get('name') }}"
                                placeholder="Tìm kiếm khách hàng" />
                        </div>
                        <div class="col-5">
                            <button type="submit" class="btn bg-gd-sea-op text-white me-2"><i
                                    class="fa fa-filter me-1"></i>Lọc</button>
                            <a href="{{ route('admin.customer.index') }}" class="btn bg-gd-fruit-op text-white ms-2"><i
                                    class="fa fa-filter-circle-xmark me-1"></i>Bỏ lọc</a>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th width="15px">#</th>
                                <th>Mã khách hàng</th>
                                <th>Khách hàng</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th class="text-center" style="width:150px">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($customers as $item)
                                <tr>
                                    <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{ $item->customer_id }}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->phone}}</td>
                                    <td>{{$item->address}}</td>

                                    <td class="text-center">
                                        <div class="btn-group" style="gap: 10px;">
                                            @if(auth()->user()->can('admin.customer.show'))
                                            <a class="btn btn-sm bg-xpro-lighter rounded-0 btn-edit" href="{{ route('admin.customer.show', $item->id) }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @endif

                                            @if (auth()->user()->can('admin.customer.edit'))
                                            <a class="btn btn-sm btn-alt-success rounded-0" href="{{ route('admin.customer.edit', $item->id) }}">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                            @endif
                                            @if (auth()->user()->can('admin.customer.destroy'))
                                                <button type="button"
                                                    class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled rounded-0"
                                                    data-bs-toggle="modal" aria-label="Delete"
                                                    data-bs-target="#modal-delete-{{ $item->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                        <x-modal-del id="{{ $item->id }}"  params="{{ $item->id }}" name="khách hàng"
                                            route="admin.customer.destroy" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-gray-500">Không tìm thấy dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="db-pagination">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
