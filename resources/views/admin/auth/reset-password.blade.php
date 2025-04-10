<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trung Ương Cục Miền Nam - Đổi mật khẩu</title>
    @notifyCss
    <link rel="stylesheet" href="/themes/css/dashmix.min.css">
    <style>
        input:focus {
            box-shadow: none !important;
        }
        #laravel-notify p {
            margin-bottom: 0;
        }
        #laravel-notify .relative .p-4 {
            padding: 16px !important;
        }
        #laravel-notify .notify{
            z-index: 10000 !important;
        }
    </style>
</head>

<body>
    <x-notify::notify />
    <div id="page-container">

        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="bg-image" style="background-image: url('/assets/bg-login.png');">
                <div class="row g-0 justify-content-center bg-black-75">
                    <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
                        <!-- Reminder Block -->
                        <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
                            <div
                                class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-body-extra-light">
                                <!-- Header -->
                                <div class="mb-2 text-center">
                                    <a class="link-fx fw-bold fs-1" href="/admin">
                                        <span class="text-dark">TWC</span><span class="text-primary">MN</span>
                                    </a>
                                    <p class="text-uppercase fw-bold fs-sm text-muted">Đổi mật khẩu</p>
                                </div>
                                <!-- END Header -->

                                <!-- Reminder Form -->
                                <form action="{{ route('admin.reset-password-post') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input type="hidden" name="email" value="{{ $email }}"/>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" name="password" placeholder="Mật khẩu mới" required>
                                    </div>
                                    <div class="mb-4">
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Xác nhận mật khẩu mới" required>
                                    </div>
                                    <div class="text-center mb-4">
                                        <button type="submit" class="btn btn-hero btn-primary">
                                            Xác nhận
                                        </button>
                                    </div>
                                </form>
                                <!-- END Reminder Form -->
                            </div>
                        </div>
                        <!-- END Reminder Block -->
                    </div>
                </div>
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
    </div>
    @notifyJs
</body>

</html>
