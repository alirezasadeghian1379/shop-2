@extends('admin.master')

@section('title', __('web/dashboard.dashboard'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                @include('admin.layouts.breadcrump',[
                    'data' => [
                        ['title' =>  __('web/dashboard.dashboard'),'route' => '','active' => 1]
                    ]
                ])
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ __('web/dashboard.users_count')}}</p>
                                    <h5 class="font-weight-bolder mb-0 mt-2">
                                        0
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-start">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="bi bi-people text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ __('web/dashboard.orders_count')}}</p>
                                    <h5 class="font-weight-bolder mb-0 mt-2">
                                        0
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-start">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="bi bi-list text-lg opacity-10 d-flex justify-content-center align-items-center" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ __('web/dashboard.orders_pending_count')}}</p>
                                    <h5 class="font-weight-bolder mb-0 mt-2">
                                        0
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-start">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="bi bi-chat d-flex justify-content-center align-items-center text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ __('web/dashboard.comments_pending_count')}}</p>
                                    <h5 class="font-weight-bolder mb-0 mt-2">
                                        0
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-start">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="bi bi-chat d-flex justify-content-center align-items-center text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ __('web/dashboard.comments_pending_count')}}</p>
                                    <h5 class="font-weight-bolder mb-0 mt-2">
                                        0
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-start">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="bi bi-chat d-flex justify-content-center align-items-center text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ __('web/dashboard.comments_pending_count')}}</p>
                                    <h5 class="font-weight-bolder mb-0 mt-2">
                                        0
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-start">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="bi bi-chat d-flex justify-content-center align-items-center text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @can('clearCache dashboard')
            <div class="row w-100 m-0 p-0">
                <div class="col-12 mb-4 p-0">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ __('web/dashboard.clear_cache_text')}}</p>
                                    </div>
                                </div>
                                <div class="col-4 text-start">
                                    <form action="{{route('admin.clearCache')}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn bg-gradient-primary">{{ __('web/dashboard.clear_cache_title')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endcan


        @canany(['status whatsapp','run whatsapp'])
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card card-shadow whatsapp-card">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-lg-7">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="whatsapp-icon ms-3">
                                            <i class="bi bi-whatsapp d-flex"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">{{__('web/dashboard.whatsapp.title')}}</h5>
                                            <p class="text-sm text-muted mb-0">{{__('web/dashboard.whatsapp.description')}}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <span id="whatsapp-status-badge" class="badge bg-gradient-secondary">{{__('web/dashboard.whatsapp.status.pending')}}</span>
                                        <span id="whatsapp-phone" class="text-sm text-muted me-2"></span>
                                    </div>

                                    <ol class="text-sm text-secondary pe-3 mb-4">
                                        <li>{{__('web/dashboard.whatsapp.help.text1')}}</li>
                                        <li>{{__('web/dashboard.whatsapp.help.text2')}}</li>
                                    </ol>

                                    @can('connect whatsapp')
                                        <button type="button" id="whatsapp-connect" class="btn btn-success mb-0">
                                            <i class="bi bi-qr-code-scan ms-1"></i>
                                            {{__('web/dashboard.whatsapp.buttons.connect')}}
                                        </button>
                                    @endcan
                                    @can('disconnect whatsapp')
                                        <button type="button" id="whatsapp-disconnect" class="btn btn-outline-danger mb-0 me-2 d-none">
                                            <i class="bi bi-link-45deg ms-1"></i>
                                            {{__('web/dashboard.whatsapp.buttons.disconnect')}}
                                        </button>
                                    @endcan
                                    <p id="whatsapp-error" class="text-danger text-sm mt-3 mb-0 d-none"></p>
                                </div>

                                <div class="col-lg-5 mt-4 mt-lg-0 text-center">
                                    <div id="whatsapp-qr-placeholder" class="whatsapp-qr-placeholder w-100">
                                        <i class="bi bi-qr-code fs-1 text-muted"></i>
                                        <span class="text-sm text-muted mt-2">{{__('web/dashboard.whatsapp.image.text1')}}</span>
                                    </div>
                                    <img id="whatsapp-qr" class="whatsapp-qr d-none w-100" alt="{{__('web/dashboard.whatsapp.image.text2')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcanany



        {{--        <div class="row my-4">--}}
{{--            <div class="col-12 mb-4">--}}
{{--                <div class="card card-shadow">--}}
{{--                    <div class="card-header pb-0">--}}
{{--                        <div class="row mb-3">--}}
{{--                            <div class="col-12">--}}
{{--                                <h6>{{ __('web/dashboard.restaurants_pending_count')}}</h6>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-body p-3">--}}
{{--                        @if(count($data['pendingRestaurants']->items))--}}
{{--                            <div class="table-responsive">--}}
{{--                                <table class="table align-items-center mb-0">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('dashboard::app.pendingRestaurants.title')}}</th>--}}
{{--                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('dashboard::app.pendingRestaurants.full_name')}}</th>--}}
{{--                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('dashboard::app.pendingRestaurants.status')}}</th>--}}
{{--                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('dashboard::app.pendingRestaurants.updated_at')}}</th>--}}
{{--                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('dashboard::app.pendingRestaurants.setting')}}</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    @foreach($data['pendingRestaurants']->items as $pendingRestaurant)--}}
{{--                                        <tr>--}}
{{--                                            <td class="text-center">{{$pendingRestaurant->name}}</td>--}}
{{--                                            <td class="text-center">--}}
{{--                                                <div class="w-100 flex justify-content-center align-items-center">--}}
{{--                                                    @if($pendingRestaurant->user->is_admin)--}}
{{--                                                        <a class="text-center text-danger w-100 d-flex justify-content-center align-items-center" href="{{route('admin.admins.edit',['admin' => $pendingRestaurant->user->id])}}">{{$pendingRestaurant->user->full_name}}</a>--}}
{{--                                                    @else--}}
{{--                                                        <a class="text-center text-danger w-100 d-flex justify-content-center align-items-center" href="{{route('admin.users.edit',['user' => $pendingRestaurant->user->id])}}">{{$pendingRestaurant->user->full_name}}</a>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                            <td class="text-center">--}}
{{--                                                @if($pendingRestaurant->active)--}}
{{--                                                    <span class="badge badge-pill bg-gradient-success">{{__('restaurant::app.table_options.active_value')}}</span>--}}
{{--                                                @else--}}
{{--                                                    <span class="badge badge-pill bg-gradient-warning">{{__('restaurant::app.table_options.penActive_value')}}</span>--}}
{{--                                                @endif--}}
{{--                                            </td>--}}
{{--                                            <td class="text-center">{{$pendingRestaurant->getJalaliUpdatedAt()}}</td>--}}
{{--                                            <td>--}}
{{--                                                <div class="d-flex justify-content-center align-items-center">--}}
{{--                                                    <a class="text-center btn btn-sm btn-warning" href="{{route('admin.restaurants.edit',['restaurant' => $pendingRestaurant->id])}}">{{__('restaurant::app.edit')}}</a>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        @else--}}
{{--                            <div class="badge badge-pill bg-gradient-primary w-100 d-flex justify-content-center align-items-center p-3 text-16">{{__('dashboard::app.restaurants_pending_empty')}}</div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="row my-4">--}}
{{--            <div class="col-lg-8 col-md-6 mb-md-0 mb-4">--}}
{{--                <div class="card card-shadow">--}}
{{--                    <div class="card-header pb-0">--}}
{{--                        <div class="row mb-3">--}}
{{--                            <div class="col-12">--}}
{{--                                <h6>{{ __('web/dashboard.restaurants_new')}}</h6>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-body p-3">--}}
{{--                        @if(count($data['restaurants']))--}}
{{--                            <div class="table-responsive">--}}
{{--                                <table class="table align-items-center mb-0">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('dashboard::app.restaurants_news.title')}}</th>--}}
{{--                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('dashboard::app.restaurants_news.full_name')}}</th>--}}
{{--                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('dashboard::app.restaurants_news.status')}}</th>--}}
{{--                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('dashboard::app.restaurants_news.created_at')}}</th>--}}
{{--                                        @can('edit restaurant')--}}
{{--                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('dashboard::app.restaurants_news.setting')}}</th>--}}
{{--                                        @endcan--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    @foreach($data['restaurants'] as $restaurant)--}}
{{--                                        <tr>--}}
{{--                                            <td class="text-center">{{$restaurant->name}}</td>--}}
{{--                                            <td class="text-center">--}}
{{--                                                <div class="w-100 flex justify-content-center align-items-center">--}}
{{--                                                    @if($restaurant->user->is_admin)--}}
{{--                                                        <a class="text-center text-danger w-100 d-flex justify-content-center align-items-center" href="{{route('admin.admins.edit',['admin' => $restaurant->user->id])}}">{{$restaurant->user->full_name}}</a>--}}
{{--                                                    @else--}}
{{--                                                        <a class="text-center text-danger w-100 d-flex justify-content-center align-items-center" href="{{route('admin.users.edit',['user' => $restaurant->user->id])}}">{{$restaurant->user->full_name}}</a>--}}
{{--                                                    @endif--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                            <td class="text-center">--}}
{{--                                                @if($restaurant->active)--}}
{{--                                                    <span class="badge badge-pill bg-gradient-success">{{__('restaurant::app.table_options.active_value')}}</span>--}}
{{--                                                @else--}}
{{--                                                    <span class="badge badge-pill bg-gradient-danger">{{__('restaurant::app.table_options.deActive_value')}}</span>--}}
{{--                                                @endif--}}
{{--                                            </td>--}}
{{--                                            <td class="text-center">{{$restaurant->getJalaliCreatedAt()}}</td>--}}
{{--                                            @can('edit restaurant')--}}
{{--                                                <td class="text-center">--}}
{{--                                                    <a href="{{route('admin.restaurants.edit',['restaurant' => $restaurant->id])}}" class="btn btn-sm btn-warning">{{__('dashboard::app.restaurants_news.showBtn')}}</a>--}}
{{--                                                </td>--}}
{{--                                            @endcan--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        @else--}}
{{--                            <div class="badge badge-pill bg-gradient-primary w-100 d-flex justify-content-center align-items-center p-3 text-16">{{__('dashboard::app.restaurants_new_empty')}}</div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-4 col-md-6">--}}
{{--                <div class="card h-100 card-shadow">--}}
{{--                    <div class="card-header pb-0">--}}
{{--                        <h6>{{ __('web/dashboard.users_new')}}</h6>--}}
{{--                    </div>--}}
{{--                    <div class="card-body p-3">--}}
{{--                        @if(count($data['newUsers']))--}}
{{--                            <div class="table-responsive">--}}
{{--                                <table class="table align-items-center mb-0">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('dashboard::app.users_news.full_name')}}</th>--}}
{{--                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('dashboard::app.users_news.mobile')}}</th>--}}
{{--                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('dashboard::app.users_news.created_at')}}</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}

{{--                                    @foreach($data['newUsers'] as $newUser)--}}
{{--                                        <tr>--}}
{{--                                            <td class="text-center p-3">--}}
{{--                                                <a href="{{route('admin.users.edit',['user' => $newUser->id])}}" class="text-warning">{{$newUser->getFullName()}}</a>--}}
{{--                                            </td>--}}
{{--                                            <td class="text-center p-3">--}}
{{--                                                <span>{{$newUser->phone}}</span>--}}
{{--                                            </td>--}}
{{--                                            <td class="text-center p-3">--}}
{{--                                                <span>{{$newUser->getJalaliCreatedAt()}}</span>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}

{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        @else--}}
{{--                            <div class="badge badge-pill bg-gradient-primary w-100 d-flex justify-content-center align-items-center p-3 text-16">{{__('dashboard::app.users_empty')}}</div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection

@section('style')
    <style>
        .card-shadow {
            box-shadow: 0 0 5px #4545452e;
        }
        .whatsapp-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            color: #fff;
            background: linear-gradient(135deg, #25d366, #128c7e);
            font-size: 24px;
        }
        .whatsapp-qr,
        .whatsapp-qr-placeholder {
            width: 260px;
            height: 260px;
            max-width: 100%;
            margin: 0 auto;
            border-radius: 16px;
            background: #fff;
            border: 1px dashed #d2d6da;
        }
        .whatsapp-qr {
            object-fit: contain;
            padding: 8px;
        }
        .whatsapp-qr-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .text-16 {
            font-size: 16px !important;
        }
        .object-fit-contain {
            object-fit: cover !important;
        }
        .slider-style-wrapper {
            height: 493px !important;
            padding: 15px;
            @media screen and (max-width: 768px) {
                height: 300px !important;
            }
        }
        .carousel-caption {
            p,h5 {
                color: white;
            }
        }
        .carousel {
            border-radius: 15px;
            overflow: hidden;
        }
        .carousel-control {
            span {
                background-color: black;
                border-radius: 50%;
                background-size: 70% 70%;
            }
        }
    </style>
@endsection
@section('script')
    <script src="{{asset('assets/js/plugins/chartjs.min.js')}}"></script>
    <script>
        const goldLogs = [];


        const sortedLogs = [...goldLogs].reverse();

        const labels = sortedLogs.map(item => {

            const date = new Date(item.created_at);

            return new Intl.DateTimeFormat('fa-IR', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            }).format(date);

        });
        const prices = sortedLogs.map(item => item.amount);

        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(249,101,67,0.31)');
        gradientStroke1.addColorStop(0.2, 'rgba(249,101,67,0.22)');
        gradientStroke1.addColorStop(0, 'rgba(249,101,67,0.07)');
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                    label: "قیمت",
                    tension: 0.4,
                    pointRadius: 0,
                    borderColor: "#f96543",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: prices,
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        enabled: true,
                        titleFont: {
                            family: 'Vazir, sans-serif',
                            size: 14,
                            style: 'normal',
                            weight: 'bold',
                        },
                        bodyFont: {
                            family: 'Vazir, sans-serif',
                            size: 14,
                            style: 'normal',
                            weight: 'normal',
                        },
                        padding: 10,
                        backgroundColor: '#ffffff',
                        titleColor: '#3f3f3f',
                        bodyColor: '#3f3f3f',
                        borderColor: '#ccc',
                        borderWidth: 1,
                        cornerRadius: 6,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#f96543',
                            font: {
                                size: 14,
                                family: "Vazir, sans-serif",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f96543',
                            padding: 20,
                            font: {
                                size: 14,
                                family: "Vazir, sans-serif",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });
    </script>
@endsection
