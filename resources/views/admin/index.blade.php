@extends('layouts.admin')
@section('content')
    <div class="dashboard-twc">
        <div id="page-container"
            class="sidebar-o enable-page-overlay side-scroll page-header-fixed side-trans-enabled">
            <!-- Sidebar -->
            <nav id="sidebar" aria-label="Main Navigation">
                <!-- Side Header -->
                <div class="bg-header-light">
                    <div class="content-header bg-white-5">
                        <!-- Logo -->
                        <a class="fw-semibold text-white tracking-wide" href="/">
                            <span class="smini-hidden">
                                <span class="text-danger">ThangLong </span>
                                <span class="text-primary">University</span>
                            </span>
                        </a>
                        <!-- END Logo -->
                    </div>
                </div>
                <!-- END Side Header -->

                <!-- Sidebar Scrolling -->
                <div class="js-sidebar-scroll">
                    <!-- Side Navigation -->
                    <div class="content-side">
                        <ul class="nav-main">
                            <x-sidebar :submenu="false" :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="si si-home" name="Trang chủ"/>
                                <x-parent-sidebar icon="si si-folder" name="Quản lý sách  ">
                                    @if (auth()->user()->can('admin.author.index'))
                                    <x-sidebar :submenu="false" :href="route('admin.author.index')" :active="request()->routeIs('admin.author.index')" icon="" name="Tác giả"/>
                                    @endif
                                    @if (auth()->user()->can('admin.publisher.index'))
                                    <x-sidebar :submenu="false" :href="route('admin.publisher.index')" :active="request()->routeIs('admin.publisher.index')" icon="" name="Nhà xuất bản"/>
                                    @endif
                                    @if (auth()->user()->can('admin.genre.index'))
                                    <x-sidebar :submenu="false" :href="route('admin.genre.index')" :active="request()->routeIs('admin.genre.index')" icon="" name="Thể loại"/>
                                    @endif
                                    @if(auth()->user()->can('admin.tag.index'))
                                        <x-sidebar :submenu="false" :href="route('admin.tag.index')" :active="request()->routeIs('admin.tag.index')" icon="" name="Nhãn"/>
                                    @endif
                                    @if (auth()->user()->can('admin.book.index'))
                                    <x-sidebar :submenu="false" :href="route('admin.book.index')" :active="request()->routeIs('admin.book.index')" icon="" name="Đầu sách"/>
                                    @endif
                                    @if (auth()->user()->can('admin.issued_book.index'))
                                    <x-sidebar :submenu="false" :href="route('admin.issued_book.index')" :active="request()->routeIs('admin.issued_book.index')" icon="" name="Sách đang mượn"/>
                                    @endif
                                    @if (auth()->user()->can('admin.returned_book.index'))
                                    <x-sidebar :submenu="false" :href="route('admin.returned_book.index')" :active="request()->routeIs('admin.returned_book.index')" icon="" name="Sách đã trả"/>
                                    @endif

                                    @if(auth()->user()->hasRole('admin'))


                                    @endif


                                </x-parent-sidebar>
                                <x-sidebar :submenu="false" :href="route('admin.customer.index')" :active="request()->routeIs('admin.customer.index')" icon="si si-user" name="Khách hàng"/>
                                    <x-sidebar :submenu="false" :href="route('file-manager-index')" :active="request()->routeIs('file-manager-index')" icon="si si-folder" name="Quản lý tập tin"/>

                            @role('admin')
                                <li class="nav-main-heading">Tài khoản</li>
                                <x-sidebar :submenu="false" :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.index')" icon="si si-users" name="Vai trò" />
                                <x-sidebar :submenu="false" :href="route('admin.permissions.index')" :active="request()->routeIs('admin.permissions.index')" icon="si si-users" name="Phân quyền" />
                                <x-sidebar :submenu="false" :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')" icon="si si-users" name="Tài khoản" />
                                <x-sidebar :submenu="false" target="_blank" href="user-activity" :active="null" icon="si si-screen-desktop" name="Lịch sử hoạt động" />
                            @endrole
                            {{-- <li class="nav-main-heading">Base</li> <!-- title --> --}}
                            {{-- submenu
                            <li class="nav-main-item">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                    <i class="nav-main-link-icon fa fa-border-all"></i>
                                    <span class="nav-main-link-name">Blocks</span>
                                </a>
                                <ul class="nav-main-submenu">
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="be_blocks_styles.html">
                                            <span class="nav-main-link-name">Styles</span>
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}
                        </ul>
                    </div>
                    <!-- END Side Navigation -->
                </div>
                <!-- END Sidebar Scrolling -->
            </nav>
            <!-- END Sidebar -->

            <!-- Header -->
            <header id="page-header">
                <!-- Header Content -->
                <div class="content-header">
                    <!-- Left Section -->
                    <div class="space-x-1">
                        <!-- Toggle Sidebar -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
                        <button type="button" class="btn btn-alt-secondary" data-toggle="layout"
                            data-action="sidebar_toggle">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>
                        <!-- END Toggle Sidebar -->
                    </div>
                    <!-- END Left Section -->

                    <!-- Right Section -->
                    <div class="space-x-1">
                        <!-- User Dropdown -->
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn btn-alt-secondary" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-fw fa-user d-sm-none"></i>
                                <span class="d-none d-sm-inline-block">{{ auth()->user()->email }}</span>
                                <i class="fa fa-fw fa-angle-down opacity-50 ms-1 d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end p-0"
                                aria-labelledby="page-header-user-dropdown">
                                <div class="bg-primary-dark rounded-top fw-semibold text-white text-center p-3">
                                    {{ auth()->user()->name }}
                                </div>
                                <div class="p-2">
                                    <a class="dropdown-item" href="{{ route('edit-profile') }}">
                                        <i class="far fa-fw fa-user me-1"></i> Thông tin tài khoản
                                    </a>

                                    <div role="separator" class="dropdown-divider"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="far fa-fw fa-arrow-alt-circle-left me-1"></i> Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- END User Dropdown -->
                    </div>
                    <!-- END Right Section -->
                </div>
                <!-- END Header Content -->
            </header>
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">
                <!-- Hero -->
                <div class="bg-body-light">
                    <div class="content content-full py-3">
                        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                            <div class="flex-grow-1 fw-semibold fs-5">{{ $title ?? '' }}</div>
                            {{ $breadcrumb ?? '' }}
                        </div>
                    </div>
                </div>
                <!-- END Hero -->

                <!-- Page Content -->
                <div class="content">
                    <div class="block block-rounded bg-custom">
                        <div class="block-content p-0">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
        </div>
    </div>
@endsection
@push('js')
    {{ $scripts ?? '' }}
@endpush
@push('css')
    {{ $css ?? '' }}
@endpush
