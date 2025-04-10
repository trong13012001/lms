<x-admin-layout>
    <x-slot name="title">
        Thêm khách hàng
    </x-slot>
    <x-slot name="breadcrumb">
        {{ Breadcrumbs::render('admin.customer.create') }}
    </x-slot>
    <form method="POST" action="{{ route('admin.customer.store') }}" enctype="multipart/form-data" id="customer-form">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="customer_id">Mã khách hàng<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('customer_id') is-invalid @enderror"
                                        id="customer_id" name="customer_id" placeholder="Nhập mã khách hàng"
                                        value="{{ old('customer_id') }}" />
                                    @error('customer_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Khách hàng<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Nhập khách hàng"
                                        value="{{ old('name') }}" />
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Nhập email"
                                        value="{{ old('email') }}" />
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="phone">Số điện thoại<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="Nhập số điện thoại" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="address">Địa chỉ<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Nhập địa chỉ" value="{{ old('address') }}">
                                    @error('address')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-2 px-5" id="submitButton">Thêm
                                khách hàng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <x-slot name="css">
        <style>
            . {
                background-color: transparent !important;
            }

            .form-check-label {
                cursor: pointer !important;
            }
        </style>
    </x-slot>

</x-admin-layout>
