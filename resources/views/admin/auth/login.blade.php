<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="apple-touch-icon" sizes="76x76" href="">
    <link rel="icon" type="image/png" href="">
    <title> {{ __('web/dashboard.auth.titlePage')}} </title>

    <link href="{{asset('assets/css/bootstrap-icons.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/jalalidatepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/argon-dashboard.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet" />
    @yield('style')
</head>
<body>
<main class="main-content  mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-justify">
                                <h4 class="font-weight-bolder">{{ __('web/dashboard.auth.titlePage')}}</h4>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{route('admin.login')}}">
                                    @csrf
                                    <div class="flex flex-col mb-3">
                                        <input type="email" name="email" class="form-control form-control-lg {{$errors->has('email') ? 'border-danger':''}}" value="{{ old('email') }}" aria-label="Email" placeholder="{{ __('web/dashboard.auth.form.email')}}">
                                        @error('email') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                    </div>
                                    <div class="flex flex-col mb-3">
                                        <input type="password" name="password" class="form-control form-control-lg {{$errors->has('password') ? 'border-danger':''}}" aria-label="Password" placeholder="{{ __('web/dashboard.auth.form.password')}}">
                                        @error('password') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                    </div>
                                    <div class="flex my-3">
                                        <div class="captcha-parent mb-2 w-100 d-flex justify-content-center align-items-center gap-2">
                                            <img src="{{captcha_src('flat')}}" alt="" class="replaceCaptcha">
                                            <button class="btn btn-warning reloadCaptcha" type="button">
                                                <i class="bi bi-arrow-clockwise d-flex"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="captcha" class="form-control form-control-lg {{$errors->has('captcha') ? 'border-danger':''}}" aria-label="captcha" placeholder="{{ __('web/dashboard.auth.form.captcha')}}">
                                        @error('captcha') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">{{ __('web/dashboard.auth.form.loginBtn')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('/assets/images/signin-ill.jpg'); background-size: cover;">
                            <span class="mask bg-gradient-primary opacity-6"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<script src=" {{asset('assets/js/jquery.min.js')}}"></script>
<script src=" {{asset('assets/js/select2.min.js')}}"></script>
<script src=" {{asset('assets/js/jalalidatepicker.min.js')}}"></script>
<script src="{{asset('assets/js/core/popper.min.js')}}"></script>
<script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/argon-dashboard.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>

<script>
    $('.reloadCaptcha').on('click',(e)=>{
        e.preventDefault()
        $('.replaceCaptcha').attr('src', '/captcha/flat?' + Date.now());
    })
</script>
@yield('script')
@include('sweetalert::alert')
</body>
</html>
