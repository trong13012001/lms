<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trung Ương Cục Miền Nam</title>
    @notifyCss
    <link rel="stylesheet" href="/themes/css/dashmix.min.css">
    <link rel="stylesheet" href="/themes/css/flatpickr.min.css">
    <link rel="stylesheet" href="/themes/css/choices.min.css">

    <link href="/assets/css/select2.min.css" rel="stylesheet">

    @vite(['resources/vitejs/scss/app.scss'])
    @stack('css')
</head>
<body>
    <x-notify::notify />
    <div id="twc-app">
        @yield('content')
    </div>
    @notifyJs
    <script src="/themes/js/dashmix.app.min.js"></script>
    <script src="/themes/js/jquery.min.js"></script>
    <script src="/themes/js/filter-url.js"></script>

    <script src="/themes/js/flatpickr.min.js"></script>
    <script src="/themes/js/choices.min.js"></script>

    <script src="/themes/js/select-form.js"></script>

    {{-- <script src="/themes/js/select2.full.min.js"></script> --}}
    <script src="/themes/js/jquery.maskedinput.min.js"></script>

    <script>Dashmix.helpersOnLoad(['jq-select2', 'jq-masked-inputs','js-flatpickr']);</script>
    @vite(['resources/vitejs/vue/app.js'])
    @stack('js')

    {{-- light theme --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const htmlElement = document.querySelector("html");
            htmlElement.className = '';
        });
    </script>

</body>
</html>
