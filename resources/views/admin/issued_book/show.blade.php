<x-admin-layout>
    <x-slot name="title">Sách</x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.book.show',$book) }}
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
                    @if (auth()->user()->can('admin.book_item.store'))
                        <div>
                            <button type="button" class="btn bg-gd-aqua text-white text-sm mb-0" data-bs-toggle="modal"
                                data-bs-target="#createBook">
                                <i class="tf-icons fa fa-circle-plus me-1"></i>
                                Thêm sách
                            </button>
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
                                <th>Năm xuất bản</th>
                                <th class="text-center" style="width:150px">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{ $item->book_code }}</td>
                                    <td>{{ $item->location }}</td>
                                    <td>{{$item->published_at}}</td>
                                    <td>
                                        <div class="btn-group" style="gap: 10px;">
                                            @if (auth()->user()->can('admin.issued_book.store'))
                                            <button type="button"
                                                class="btn btn-sm btn-alt-success js-bs-tooltip-enabled rounded-0"
                                                data-bs-target="#modal-issued-book-{{ $item->id }}"
                                                data-bs-toggle="modal">
                                                <i class="fa fa-pencil-alt"></i>
                                            </button>
                                        @endif
                                            @if (auth()->user()->can('admin.book_item.update'))
                                                <button type="button"
                                                    class="btn btn-sm btn-alt-success js-bs-tooltip-enabled rounded-0"
                                                    data-bs-target="#editBookItem-{{ $item->id }}"
                                                    data-bs-toggle="modal">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </button>
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
                                            <x-modal-del id="{{ $item->id }}"  params="{{ $item->id }}" name="sách"
                                            route="admin.book_item.destroy" />
                                            <div class="modal fade text-left" id="editBookItem-{{ $item->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-popout modal-dialog-centered modal-dialog-scrollable modal-custom modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-gd-sea-op">
                                                            <h4 class="modal-title text-white">Sửa sách</h4>
                                                        </div>
                                                        <form id="tag-update-form-{{ $item->id }}"
                                                            action="{{ route('admin.book_item.update', $item->id) }}"
                                                            method="post">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="modal-body pb-0">
                                                                <div class="mb-3">
                                                                    <input type="hidden" name="book_id" value="{{$book->id}}">
                                                                    <label class="form-label">Nhà xuất bản</label>
                                                                    <select class="choices form-select" name="publisher_id" required>
                                                                        <option placeholder value="">Tìm hoặc chọn nhà xuất bản</option>
                                                                        @foreach ($publishers as $publisher)
                                                                            <option value="{{ $publisher['id'] }}" {{ $item->publisher_id == $publisher['id'] ? 'selected' : '' }}>
                                                                                {{ $publisher['name'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Mã sách</label>
                                                                    <input id="name-{{ $item->id }}" type="text" class="form-control" name="book_code"
                                                                        placeholder="Nhập mã sách" value="{{ old('book_code', $item->book_code) }}" />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Vị trí để sách</label>
                                                                    <input class="form-control" name="location" id="location-{{ $item->id }}" placeholder="Nhập vị trí để sách" value="{{ $item->location }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Năm xuất bản</label>
                                                                    <input type="text" class="js-flatpickr form-control" name="published_at"
                                                                    placeholder="Y-m-d" value="{{ old('published_at', $item->published_at) }}">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-label-secondary me-1"
                                                                    data-bs-dismiss="modal">
                                                                    <span class="d-none d-sm-block">Huỷ</span>
                                                                </button>
                                                                <button type="submit" id="submitUpdateButton-{{ $item->id }}"
                                                                    class="btn bg-gd-sea-op text-white ms-1">
                                                                    <span class="d-none d-sm-block">Sửa sách</span>
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
                                    <td colspan='5' class="text-center text-gray-500">Không tìm thấy dữ liệu</td>
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
    <div class="modal fade text-left" id="createBook" tabindex="-1">
        <div class="modal-dialog modal-dialog-popout modal-dialog-centered modal-dialog-scrollable modal-custom modal-xl"
            role="document">
            <div class="modal-content">
                <div class="modal-header bg-gd-sea-op">
                    <h4 class="modal-title text-white">Thêm sách</h4>
                </div>
                <form id="tag-form" action="{{ route('admin.book_item.store') }}" method="post">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="mb-3">
                            <input type="hidden" name="book_id" value="{{$book->id}}">
                            <label class="form-label">Nhà xuất bản</label>
                            <select class="choices form-select" name="publisher_id" required>
                                <option placeholder value="">Tìm hoặc chọn nhà xuất bản</option>
                                @foreach ($publishers as $item)
                                    <option value="{{ $item['id'] }}">
                                        {{ $item['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mã sách</label>
                            <input id="name" type="text" class="form-control" name="book_code"
                                placeholder="Nhập mã sách" value="{{old('book_code')}}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Vị trí để sách</label>
                            <input class="form-control" name="location" id="location" placeholder="Nhập vị trí để sách"></input>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Năm xuất bản</label>
                            <input type="text" class="js-flatpickr form-control" name="published_at"
                            placeholder="Y-m-d"  value="{{ old('published_at') }}">                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary me-1" data-bs-dismiss="modal">
                            <span class="d-none d-sm-block">Huỷ</span>
                        </button>
                        <button type="submit" id="submitButton" class="btn bg-gd-sea-op text-white ms-1">
                            <span class="d-none d-sm-block">Thêm sách</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- <x-slot name="scripts">
        <script src="/themes/js/vldTH.js"></script>

        <script>
            const fields_create = [{
                input: 'name',
                error: 'error-name'
            }, ];
            document.addEventListener('DOMContentLoaded', function(event) {
                vldTH('tag-form', fields_create, 'submitButton');

            })

            @foreach ($items as $item)
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
    </x-slot> --}}
</x-admin-layout>
