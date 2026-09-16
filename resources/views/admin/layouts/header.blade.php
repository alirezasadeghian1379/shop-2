<nav class="navbar navbar-main navbar-expand-lg py-3 px-0 mx-4 shadow-none border-radius-xl">
    <div class="container-fluid parent-header p-2">
        <div class="row w-100 p-0 m-0">
            <div class="col-6 p-0 d-flex justify-content-start align-items-center">
                <div class="menu-responsive showAndHideSideMenu">
                    <i class="bi bi-list"></i>
                </div>
            </div>
            <div class="col-6 p-0 d-flex justify-content-end align-items-center">
                <div class="form-check form-switch w-custom-100px d-flex justify-content-center align-items-center px-2">
                    <input class="form-check-input mt-1 float-end mx-auto" dir="ltr" type="checkbox" id="dark-version" onclick="darkMode(this)">
                    <i class="bi bi-lightbulb-fill d-flex"></i>
                </div>
                <div class="dropdown">
                    <button class="btn bg-gradient-primary dropdown-toggle mx-0 mt-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        {{{ __('web/dashboard.profile')}}}
                    </button>
                    <ul class="dropdown-menu mt-custom" id="margin-custom" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#">{{auth()->user()->full_name}}</a></li>
                        <li><a class="dropdown-item" href="{{route('admin.index')}}">{{{ __('web/dashboard.dashboard')}}}</a></li>
                        <li><a class="dropdown-item text-danger" href="{{route('admin.logout')}}">{{{ __('web/dashboard.logout')}}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
