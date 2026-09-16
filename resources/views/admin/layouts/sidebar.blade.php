<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-end me-4 rotate-caret" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute start-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{route('admin.index')}}">
            <img src="{{app('logo')}}" class="navbar-brand-img h-100" alt="{{app('siteName')}}">
            <span class="px-2">{{app('siteName')}}</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse px-0 w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">



            @if(in_array('index dashboard',app('permissions')))
                <li class="nav-item">
                    <a class="nav-link " href="{{route('admin.index')}}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center ms-2 d-flex align-items-center justify-content-center">
                            <i class="bi bi-speedometer2 text-primary text-lg opacity-10"></i>
                        </div>
                        <span class="nav-link-text me-1">{{  __('web/dashboard.dashboard')}}</span>
                    </a>
                </li>
            @endif

            @if(in_array('index user',app('permissions')) || in_array('index admin',app('permissions')) || in_array('index role',app('permissions')))
                <li class="nav-item">
                    <a class="nav-link cursor-pointer" data-bs-toggle="collapse" data-bs-target="#userCollapse" aria-expanded="false">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center ms-2 d-flex align-items-center justify-content-center">
                            <i class="bi bi-people-fill text-primary text-lg opacity-10"></i>
                        </div>
                        <span class="nav-link-text me-1">{{  __('web/dashboard.user')}}</span>
                    </a>
                    <div class="collapse" id="userCollapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            @can('index user')
                                <li>
                                    <a href="{{route('admin.users.index')}}" class="link-dark rounded d-flex justify-content-start align-items-center gap-2">
                                        <i class="bi bi-circle d-flex text-icon-sm text-primary"></i>
                                        <span>{{  __('web/dashboard.user')}}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('index admin')
                                    <li>
                                        <a href="{{route('admin.admins.index')}}" class="link-dark rounded d-flex justify-content-start align-items-center gap-2">
                                            <i class="bi bi-circle d-flex text-icon-sm text-primary"></i>
                                            <span>{{  __('web/dashboard.admin')}}</span>
                                        </a>
                                    </li>
                            @endcan
                            @can('index role')
                                    <li>
                                        <a href="{{route('admin.roles.index')}}" class="link-dark rounded d-flex justify-content-start align-items-center gap-2">
                                            <i class="bi bi-circle d-flex text-icon-sm text-primary"></i>
                                            <span>{{  __('web/dashboard.role')}}</span>
                                        </a>
                                    </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif

{{--            @if(in_array('index category-restaurant',app('permissions')) || in_array('index category-menu',app('permissions')))--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link cursor-pointer" data-bs-toggle="collapse" data-bs-target="#categoryCollapse" aria-expanded="false">--}}
{{--                            <div--}}
{{--                                class="icon icon-shape icon-sm border-radius-md text-center ms-2 d-flex align-items-center justify-content-center">--}}
{{--                                <i class="bi bi-book text-primary text-lg opacity-10"></i>--}}
{{--                            </div>--}}
{{--                            <span class="nav-link-text me-1">{{ __('dashboard::app.category')}}</span>--}}
{{--                        </a>--}}
{{--                        <div class="collapse" id="categoryCollapse">--}}
{{--                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">--}}
{{--                                @can('index category-restaurant')--}}
{{--                                    <li>--}}
{{--                                        <a href="{{route('admin.categories-restaurants.index')}}" class="link-dark rounded d-flex justify-content-start align-items-center gap-2">--}}
{{--                                            <i class="bi bi-circle d-flex text-icon-sm text-primary"></i>--}}
{{--                                            <span>{{ __('dashboard::app.category_restaurant')}}</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                @endcan--}}
{{--                                @can('index category-menu')--}}
{{--                                    <li>--}}
{{--                                        <a href="{{route('admin.categories-menus.index')}}" class="link-dark rounded d-flex justify-content-start align-items-center gap-2">--}}
{{--                                            <i class="bi bi-circle d-flex text-icon-sm text-primary"></i>--}}
{{--                                            <span>{{ __('dashboard::app.category_menu')}}</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                @endcan--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                @endif--}}


            @if(in_array('index province',app('permissions')) || in_array('index city',app('permissions')))
                <li class="nav-item">
                    <a class="nav-link cursor-pointer" data-bs-toggle="collapse" data-bs-target="#stateCollapse" aria-expanded="false">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center ms-2 d-flex align-items-center justify-content-center">
                            <i class="bi bi-geo-fill text-primary text-lg opacity-10"></i>
                        </div>
                        <span class="nav-link-text me-1">{{ __('web/dashboard.state')}}</span>
                    </a>
                    <div class="collapse" id="stateCollapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            @can('index province')
                                <li>
                                    <a href="{{route('admin.provinces.index')}}" class="link-dark rounded d-flex justify-content-start align-items-center gap-2">
                                        <i class="bi bi-circle d-flex text-icon-sm text-primary"></i>
                                        <span>{{ __('web/dashboard.province')}}</span>
                                    </a>
                                </li>
                            @endcan
                                @can('index city')
                                    <li>
                                        <a href="{{route('admin.cities.index')}}" class="link-dark rounded d-flex justify-content-start align-items-center gap-2">
                                            <i class="bi bi-circle d-flex text-icon-sm text-primary"></i>
                                            <span>{{ __('web/dashboard.city')}}</span>
                                        </a>
                                    </li>
                                @endcan
                        </ul>
                    </div>
                </li>
            @endif


{{--            @if(in_array('index slider',app('permissions')))--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link " href="{{route('admin.sliders.index')}}">--}}
{{--                        <div--}}
{{--                            class="icon icon-shape icon-sm border-radius-md text-center ms-2 d-flex align-items-center justify-content-center">--}}
{{--                            <i class="bi bi-images text-primary text-lg opacity-10"></i>--}}
{{--                        </div>--}}
{{--                        <span class="nav-link-text me-1">{{ __('dashboard::app.slider')}}</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endif--}}
            @if(in_array('index setting',app('permissions')))
                <li class="nav-item">
                    <a class="nav-link " href="{{route('admin.settings.index')}}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center ms-2 d-flex align-items-center justify-content-center">
                            <i class="bi bi-gear-fill text-primary text-lg opacity-10"></i>
                        </div>
                        <span class="nav-link-text me-1">{{  __('web/dashboard.setting')}}</span>
                    </a>
                </li>
            @endif
{{--            @if(in_array('index question',app('permissions')))--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link " href="{{route('admin.questions.index')}}">--}}
{{--                        <div--}}
{{--                            class="icon icon-shape icon-sm border-radius-md text-center ms-2 d-flex align-items-center justify-content-center">--}}
{{--                            <i class="bi bi-question-lg text-primary text-lg opacity-10"></i>--}}
{{--                        </div>--}}
{{--                        <span class="nav-link-text me-1">{{ __('dashboard::app.question')}}</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endif--}}
{{--            @if(in_array('index notification',app('permissions')))--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link " href="{{route('admin.notifications.index')}}">--}}
{{--                        <div--}}
{{--                            class="icon icon-shape icon-sm border-radius-md text-center ms-2 d-flex align-items-center justify-content-center">--}}
{{--                            <i class="bi bi-bell-fill text-primary text-lg opacity-10"></i>--}}
{{--                        </div>--}}
{{--                        <span class="nav-link-text me-1">{{ __('dashboard::app.notification')}}</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endif--}}

{{--            @if(in_array('index app-version',app('permissions')))--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link " href="{{route('admin.app-versions.index')}}">--}}
{{--                        <div--}}
{{--                            class="icon icon-shape icon-sm border-radius-md text-center ms-2 d-flex align-items-center justify-content-center">--}}
{{--                            <i class="bi bi-terminal-dash text-primary text-lg opacity-10"></i>--}}
{{--                        </div>--}}
{{--                        <span class="nav-link-text me-1">{{ __('dashboard::app.appVersion')}}</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @endif--}}



            <li class="nav-item mt-3">
                <h6 class="ps-4 me-4 pe-2 text-uppercase text-xs font-weight-bolder opacity-6"></h6>
            </li>


        </ul>
    </div>
</aside>
