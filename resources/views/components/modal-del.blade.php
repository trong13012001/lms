@props(['id', 'name', 'route'])

<div class="modal fade modal-del" id="modal-delete-{{ $id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-danger p-3">
                    <h5 class="modal-title text-white">Xoá {{ $name }}</h5>
                </div>
                <div class="block-content">
                    <div class="text-center" style="margin-top: 20px">
                        <i class="si si-info text-danger" style="font-size: 60px"></i>
                        <p class="my-4 text-lg fw-bold">Bạn chắc chắn muốn xoá {{ $name }} này ?</p>
                    </div>
                </div>
                <div class="block-content block-content-full bg-body d-flex justify-content-end p-3">
                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">
                        <span class="d-none d-sm-block">Huỷ</span>
                    </button>
                    <form method="POST" action="{{ route($route, $id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger ms-1" data-bs-dismiss="modal">
                            <span class="d-none d-sm-block">Xác nhận</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
