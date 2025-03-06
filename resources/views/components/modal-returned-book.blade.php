@props(['id', 'customer', 'item'])

<div class="modal fade modal-del" id="modal-returned-book-{{$id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary p-3">
                    <h5 class="modal-title text-white">Trả sách</h5>
                </div>
                <div class="block-content">
                    <div class="text-center" style="margin-top: 20px">
                        <i class="si si-info text-primary" style="font-size: 60px"></i>
                        <p class="my-4 text-lg fw-bold">Khách hàng {{$customer->name}} muốn trả sách {{ $item->bookItem->book->name}} này ?</p>
                    </div>
                </div>
                <div class="block-content block-content-full bg-body d-flex justify-content-end p-3">
                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">
                        <span class="d-none d-sm-block">Huỷ</span>
                    </button>
                    <form method="POST" action="{{ route("admin.issued_book.returned_book",  $id) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                            <span class="d-none d-sm-block">Xác nhận</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
