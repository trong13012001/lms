@props(['id', 'customers'])

<div class="modal fade modal-del" id="modal-issued-book-{{ $id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="modal-header bg-gd-sea-op">
                    <h4 class="modal-title text-white">Mượn sách</h4>
                </div>
                <form id="tag-form" action="{{ route('admin.issued_book.store') }}" method="post">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="mb-3">
                            <div class="mb-3">
                                <b>Thủ thư:</b> {{auth()->user()->name}}
                            </div>
                            <input type="hidden" name="book_item_id" value="{{ $id }}">
                            <label for="customer_id" class="form-label">Khách hàng</label>
                            <select class="choices form-select" name="customer_id" id="customer_id" required>
                                <option placeholder value="">Tìm hoặc chọn khách hàng</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer['id'] }}">
                                        {{ $customer['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="return_date" class="form-label">Ngày trả</label>
                            <input type="text" class="js-flatpickr form-control" id="return_date" name="return_date"
                                placeholder="Y-m-d" value="{{ old('return_date') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary me-1" data-bs-dismiss="modal">
                            <span class="d-none d-sm-block">Huỷ</span>
                        </button>
                        <button type="submit" id="submitButton" class="btn bg-gd-sea-op text-white ms-1">
                            <span class="d-none d-sm-block">Mượn sách</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
