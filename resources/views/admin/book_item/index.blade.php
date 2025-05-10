<x-admin-layout>
    <x-slot name="title">Danh sách sách</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.book.item.index',$book) }}
    </x-slot>
    <div class="card">
        <div class="card-body">
            <div class="header-card mb-3">
                <div class="book-details d-flex align-items-start">
                    <div class="book-image me-3">
                        <img class="img-fluid" style="max-width: 263px; max-height: 263px; object-fit: cover;"
                             src="{{ image($book['image'] ? $book['image'] : '/assets/no-image.png', 263, 0) }}"
                             alt="{{ $book['name'] }}" />
                    </div>
                    <div class="book-info">
                        <h5 class="mb-2">{{ $book['name'] }}</h5>
                        <div>
                            <b>Tác giả:</b> @foreach ($book->authors as $author)
                            {{ $author->name }}@if (!$loop->last), @endif
                        @endforeach
                        </div>
                        <div>
                            <b>Thể loại:</b> @foreach ($book->genres as $genre)
                            {{ $genre->name }}@if (!$loop->last), @endif
                        @endforeach
                        </div>
                        <div>
                            <b>Nhãn:</b> @foreach ($book->tags as $tag)
                            {{ $tag->name }}@if (!$loop->last), @endif
                        @endforeach
                        </div>
                        <div>
                            <b>Phát hành lần đầu:</b>
                            @if($book['published_on'] instanceof \DateTime)
                                {{ $book['published_on']->format('d-m-Y') }}
                            @elseif(is_string($book['published_on']))
                                {{ \Carbon\Carbon::parse($book['published_on'])->format('d-m-Y') }}
                            @else
                                N/A
                            @endif
                        </div>
                        <div><b>Nội dung:</b> {!! $book['description'] !!}</div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"></h5>
                    @if (auth()->user()->can('admin.book.item.store'))
                        <div>
                            <a href="{{ route('admin.book.item.create', ['book' => $book->id]) }}" class="btn bg-gd-aqua text-white text-sm mb-0">
                                <i class="tf-icons fa fa-circle-plus me-1"></i>
                                Thêm mới
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="body-card">
                <form method="GET" action="{{ route('admin.book.show',$book) }}" id="filterForm">
                    <div class="row align-items-center mb-3">
                        <div class="col-4">
                            <input type="text" class="form-control" name="book_code" value="{{ Request::get('book_code') }}"
                                placeholder="Tìm kiếm sách" />
                        </div>
                        <div class="col-5">
                            <button type="submit" class="btn bg-gd-sea-op text-white me-2"><i
                                    class="fa fa-filter me-1"></i>Lọc</button>
                                    <a href="{{ url('/book/' . $book->id) }}" class="btn bg-gd-fruit-op text-white ms-2"><i
                                        class="fa fa-filter-circle-xmark me-1"></i>Bỏ lọc</a>


                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th width="15px">#</th>
                                <th>Mã sách</th>
                                <th>Vị trí để sách</th>
                                <th>Nhà xuất bản</th>
                                <th>Năm xuất bản</th>
                                <th>Trạng thái</th>
                                <th style="width:150px">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{ $item->book_code }}</td>
                                    <td>{{ $item->location }}</td>
                                    <td>{{$item->publisher->name}}</td>
                                    <td>{{$item->published_at}}</td>
                                    <td>@if ($item->status==1)
                                        <span class="text-success">Khả dụng</span>
                                    @else
                                        <span class="text-warning">Đang mượn</span>

                                    @endif</td>
                                    {{-- {{-- <td>{{$item->issuedBooks}}</td> --}}
                                    <td>

                                        <div class="btn-group" style="gap: 10px;">
                                            @if ($item->status==1)
                                            @if (auth()->user()->can('admin.issued_book.store'))
                                            <button type="button"
                                                class="btn btn-sm btn-alt-primary js-bs-tooltip-enabled rounded-0"
                                                data-bs-target="#modal-issued-book-{{ $item->id }}"
                                                data-bs-toggle="modal">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                            @endif
                                        @endif
                                            @if (auth()->user()->can('admin.book.item.edit'))
                                            <a href="{{ route('admin.book.item.edit', ['book' => $book->id, 'item' => $item->id]) }}"
                                                class="btn btn-sm btn-alt-success js-bs-tooltip-enabled rounded-0">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                            @endif
                                            @if (auth()->user()->can('admin.book_item.destroy'))
                                                <button type="button"
                                                    class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled rounded-0"
                                                    data-bs-toggle="modal" aria-label="Delete"
                                                    data-bs-target="#modal-delete-{{ $item->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                        <x-modal-issued-book :id="$item->id" :customers="$customers"/>
                                            <x-modal-del id="{{ $item->id }}" name="sách" route="admin.book.item.destroy" :params="['book' => $book->id, 'item' => $item->id]"/>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan='7' class="text-center text-gray-500">Không tìm thấy dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="db-pagination">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
