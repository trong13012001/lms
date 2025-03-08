<x-admin-layout>
    <x-slot name="title">Sách</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.issued_book.index') }}
    </x-slot>
    <div class="card">
        <div class="card-body">
            <div class="header-card mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"></h5>
                    @if (auth()->user()->can('admin.issued_book.store'))
                        <div>
                            <a href="{{ route('admin.issued_book.create') }}" class="btn bg-gd-aqua text-white text-sm mb-0">
                                <i class="fa fa-circle-plus me-1"></i>
                                Thêm sách
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="body-card">
                <form method="GET" action="{{ route('admin.issued_book.index') }}" id="filterForm">
                    <div class="row align-items-center mb-3">
                        <div class="col-4">
                            <input type="text" class="form-control" name="name" value="{{ Request::get('name') }}"
                                placeholder="Tìm kiếm sách" />
                        </div>
                        <div class="col-5">
                            <button type="submit" class="btn bg-gd-sea-op text-white me-2"><i
                                    class="fa fa-filter me-1"></i>Lọc</button>
                            <a href="{{ route('admin.issued_book.index') }}" class="btn bg-gd-fruit-op text-white ms-2"><i
                                    class="fa fa-filter-circle-xmark me-1"></i>Bỏ lọc</a>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th width="15px">#</th>
                                <th>Ảnh</th>
                                <th>Sách</th>
                                <th>Mã sách</th>
                                <th>Ngày mượn</th>
                                <th>Ngày phải trả</th>
                                <th>Ngày trả</th>
                                <th>Người mượn</th>
                                <th>Trạng thái</th>
                                <th style="width:150px">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($issuedBooks as $item)
                                <tr>
                                    <td>{{ ($issuedBooks->currentPage() - 1) * $issuedBooks->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        <img class="img-table" src="{{image($item->bookItem->book->image ? $item->bookItem->book->image : '/assets/no-image.png', 120, 0)}}" alt="{{ $item->image }}"/>
                                    </td>
                                    <td>{{ $item->bookItem->book->name  }}</td>
                                    <td>{{ $item->bookItem->book_code }}</td>
                                    <td>{{ $item->issued_date }}</td>
                                    <td>{{ $item->return_date }}</td>
                                    <td>{{ $item->returned_date }}</td>
                                    <td>{{ $item->customer->name }}</td>
                                    {{-- <td>{{$item->id}}</td> --}}
                                    <td>
                                        @php
                                            $now = now();
                                            $isOverdue = !$item->returned_date && $now->gt($item->return_date);
                                        @endphp

                                        @if ($isOverdue)
                                            <span class="text-danger">Đã quá hạn</span>
                                        @elseif ($item->status==1)
                                            <span class="text-warning">Đang mượn</span>
                                        @elseif ($item->status==0)
                                            <span class="text-success">Đã trả</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" style="gap: 10px;">
                                            @if (!$item->returned_date)
                                                <button type="button"
                                                    class="btn btn-sm btn-alt-primary js-bs-tooltip-enabled rounded-0"
                                                    data-bs-target="#modal-returned-book-{{$item->id}}"
                                                     data-bs-toggle="modal"
                                                    >
                                                    <i class="fa fa-undo"></i>
                                                </button>
                                            @endif
                                        </div>
                                        <x-modal-returned-book :id="$item->id" :item="$item" :customer="$item->customer" />
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-gray-500">Không tìm thấy dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="db-pagination">
                    {{ $issuedBooks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
