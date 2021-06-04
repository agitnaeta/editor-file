<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="{{ asset('css/app.css') }}"  rel="stylesheet">
    <!-- load css -->
    <link rel="stylesheet" href="//unpkg.com/videojs-record/dist/css/videojs.record.min.css">

    <!-- load script -->
    <link href="//unpkg.com/video.js@7.11.8/dist/video-js.min.css" rel="stylesheet">
    <link href="//unpkg.com/videojs-record/dist/css/videojs.record.min.css" rel="stylesheet">

    <script src="//unpkg.com/video.js@7.11.8/dist/video.min.js"></script>
    <script src="//unpkg.com/recordrtc/RecordRTC.js"></script>
    <script src="//unpkg.com/webrtc-adapter/out/adapter.js"></script>

    <script src="//unpkg.com/videojs-record/dist/videojs.record.min.js"></script>

    <style>
        body {
            font-style: normal;
            font-family: Arial,Helvetica,sans-serif;
        }

        @media (prefers-color-scheme: light) {
            body {
                background-color: #f5f5f5;
            }
        }

        @media (prefers-color-scheme: dark) {
            body {
                background-color: #1e1e1e;
                color: white;
            }
        }
    </style>

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

    @include('ckeditor')
    @include('audiorecorder')
    @include('videorecorder')

    @include('videorecorder-rtc')
    @yield('script')
</body>
</html>
