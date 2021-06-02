<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="{{ asset('css/app.css') }}"  rel="stylesheet">
    <style>

        audio {
            margin: 0 auto !important;
            display: block !important;
            width: 100%;
        }
    </style>

    <title>@yield('title')</title>
</head>
<body>
    
    @yield('content')

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('ckeditor/adapters/jquery.js') }}"></script>
    @yield('script')
</body>
</html>
