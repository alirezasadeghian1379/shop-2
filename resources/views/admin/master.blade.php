<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <meta name="Author" content="Alireza Sadeghian">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{app('icon')}}">
    <link rel="icon" type="image/png" href="{{app('icon')}}">
    <title> {{app('siteName')}} | @section('title') {{ __('web/dashboard.dashboard')}} @show</title>
    <link href="{{asset('assets/css/bootstrap-icons.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/jalalidatepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/argon-dashboard.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/mapIr/css/mapp.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/mapIr/css/fa/style.css')}}" rel="stylesheet" />
    @yield('style')
</head>
<body>

<div class="min-height-300 bg-primary position-absolute w-100"></div>
@include('admin.layouts.sidebar')
<main class="main-content border-radius-lg">
    <div class="main-content position-relative border-radius-lg overflow-hidden pb-2">
        @include('admin.layouts.header')
        <div class="min-h-90">
            @yield('content')
        </div>
    </div>
</main>

<script src=" {{asset('assets/js/jquery.min.js')}}"></script>
<script src=" {{asset('assets/js/select2.min.js')}}"></script>
<script src=" {{asset('assets/js/jalalidatepicker.min.js')}}"></script>
<script src=" {{asset('assets/js/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>
<script src="{{asset('assets/js/core/popper.min.js')}}"></script>
<script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/argon-dashboard.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
<script async defer src="{{asset('assets/js/buttons.js')}}"></script>
<script src="{{asset('assets/mapIr/js/mapp.env.js')}}"></script>
<script src="{{asset('assets/mapIr/js/mapp.min.js')}}"></script>
<script src="{{asset('assets/js/Sortable.min.js')}}"></script>
@yield('script')
@include('sweetalert::alert')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]')['content']
        }
    })
</script>
</body>
</html>
