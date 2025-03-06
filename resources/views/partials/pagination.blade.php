@if ($paginator->hasPages())
<nav class="mt-3 d-flex justify-content-between align-items-center" aria-label="Page navigation">
    <div>
        <p class="text-muted mb-0">
            Đang xem
            <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
            đến
            <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
            trong tổng số
            <span class="fw-semibold">{{ $paginator->total() }}</span>
            bản ghi
        </p>
    </div>
    <ul class="pagination justify-content-end mb-0 pagination-custom">
        @if ($paginator->onFirstPage())
            <li class="page-item prev disabled">
                <a class="page-link bg-gray-lighter" href="#"><i class="fa fa-angle-left"></i></a>
            </li>
        @else
            <li class="page-item prev">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-angle-left"></i></a>
            </li>
        @endif

        @if($paginator->currentPage() > 3)
            <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
        @endif
        @if($paginator->currentPage() > 4)
            <li class="page-item"><a class="page-link">...</a></li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li class="page-item active"><a class="page-link">{{ $i }}</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li class="page-item"><a class="page-link">...</a></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif

        @if ($paginator->hasMorePages())
            <li class="page-item next">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-angle-right"></i></a>
            </li>
        @else
            <li class="page-item next disabled">
                <a class="page-link bg-gray-lighter" href="#"><i class="fa fa-angle-right"></i></a>
            </li>
        @endif
    </ul>
</nav>
@endif
