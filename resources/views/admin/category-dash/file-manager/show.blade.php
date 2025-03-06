@extends('layouts.filemanager')

@section('content')
    <div class="d-flex justify-content-center align-items-center category-files">
        <div class="menu">
            <div class="text-center title">Danh mục quản lý tập tin</div>
            @foreach($categories as $item)
                <a href="{{ route('unisharp.lfm.show') }}?type={{ $item['folder_name'] }}" class="btn btn-category shadow-sm">
                    <p class="mb-0 fs-4"><i class="{{ $item['icon'] }}"></i></p>
                    <p class="fs-5 mb-0">{{ $item['title'] }}</p>
                </a>
            @endforeach
        </div>
    </div>
    <div>

    </div>
@endsection
@push('css')
    <style>
        .category-files {
            height: 100vh;
            width: 100vw;
        }
        .title {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 40px;
        }
        .btn-category {
            background: rgba(26,92,255,1) !important;
            color: #fff !important;
            width: 150px;
            margin-right: 20px;
        }
        .btn-category:last-child {
            margin: 0 !important;
        }
        .btn-category:hover {
            box-shadow: 0 10px 20px -10px rgba(26,92,255,1) !important;
            transform: translateY(-3px);
        }
    </style>
@endpush
