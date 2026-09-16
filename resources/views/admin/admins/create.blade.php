@extends('admin.master')

@section('title',isset($admin) ?  __('web/admin.edit'): __('web/admin.create'))

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' =>  __('web/admin.list'),'route' => route('admin.admins.index'),'active' => 0],
                            ['title' => isset($admin) ?  __('web/admin.edit'): __('web/admin.create'),'route' => isset($admin) ? route('admin.admins.edit',['admin' => $admin->id]):route('admin.admins.create'),'active' => 1],
                        ]
                    ])
                </div>
            </div>

            <div class="col-md-12">
                <form role="form" method="POST" action="{{isset($admin) ? route('admin.admins.update',['admin' => $admin->id]):route('admin.admins.store')}}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($admin))
                        @method('PUT')
                    @endif
                    <div class="row w-100 p-0 m-0">
                        <div class="col-md-8 order-2 order-md-1 p-2">
                            <div class="card h-100">
                                <div class="card-body">
                                    <p class="text-uppercase text-sm">{{isset($admin) ?  __('web/admin.edit'): __('web/admin.create')}}</p>
                                    <div class="row w-100 h-100 px-0 py-2 m-0">

                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="first_name" class="form-control-label">{{ __('web/admin.form.first_name')}}</label>
                                                <input class="form-control {{$errors->has('first_name') ? 'border-danger':''}}" type="text" name="first_name" id="first_name" value="{{isset($admin) ? $admin->first_name:old('first_name')}}" autocomplete="off" placeholder="{{ __('web/admin.form.first_name')}}">
                                                @error('first_name') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="last_name" class="form-control-label">{{ __('web/admin.form.last_name')}}</label>
                                                <input class="form-control {{$errors->has('last_name') ? 'border-danger':''}}" type="text" name="last_name" id="last_name" value="{{isset($admin) ? $admin->last_name:old('last_name')}}" autocomplete="off" placeholder="{{ __('web/admin.form.last_name')}}">
                                                @error('last_name') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="phone" class="form-control-label">{{ __('web/admin.form.phone')}}</label>
                                                <input class="form-control {{$errors->has('phone') ? 'border-danger':''}}" oninput="this.value = this.value.replace(/[^0-9]/g,'').replace(/(\..*)\./g,'$1');" maxLength="11" type="text" name="phone" id="phone" value="{{isset($admin) ? $admin->phone:old('phone')}}" autocomplete="off" placeholder="{{ __('web/admin.form.phone')}}">
                                                @error('phone') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-control-label">{{ __('web/admin.form.email')}}</label>
                                                <input class="form-control {{$errors->has('email') ? 'border-danger':''}}" type="text" name="email" id="email" value="{{isset($admin) ? $admin->email:old('email')}}" autocomplete="off" placeholder="{{ __('web/admin.form.email')}}">
                                                @error('email') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="password" class="form-control-label">{{isset($admin) ?  __('web/admin.form.password-edit'): __('web/admin.form.password')}}</label>
                                                <div class="pass-parent-input">
                                                    <input class="form-control {{$errors->has('password') ? 'border-danger':''}}" type="password" name="password" id="password" value="{{old('password')}}" autocomplete="off" placeholder="{{ __('web/admin.form.password')}}">
                                                    <i class="bi bi-eye-fill showPass active"></i>
                                                    <i class="bi bi-eye-slash-fill showPass"></i>
                                                </div>
                                                @error('password') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>

                                        @if(auth()->check() && auth()->user()->role_type == \App\Enums\User\UserRoleTypeEnum::SUPER_ADMIN)
                                            <div class="col-12 col-md-6">
                                                <div class="form-group {{$errors->has('role_type') ? 'error-validate':''}}">
                                                    <label for="role_type" class="form-control-label">{{ __('web/admin.form.role_type')}}</label>
                                                    <select name="role_type" id="role_type" class="form-control select2">
                                                        <option value="" selected disabled>{{ __('web/admin.form.select.default')}}</option>
                                                        @foreach(\App\Enums\User\UserRoleTypeEnum::getRoleTypesPersian() as $key=>$value)
                                                            @if($key != \App\Enums\User\UserRoleTypeEnum::USER)
                                                                <option value="{{$key}}" @selected(isset($admin) && $admin->role_type == $key)>{{$value}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @error('role_type') <div class="text-danger text-14">{{$message}}</div> @enderror
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-12 col-md-6">
                                            <div class="form-group {{$errors->has('role_name') ? 'error-validate':''}}">
                                                <label for="role_name" class="form-control-label">{{ __('web/admin.form.role_name')}}</label>
                                                <select name="role_name" id="role_name" class="form-control select2">
                                                    <option value="" selected disabled>{{ __('web/admin.form.select.default')}}</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{$role->name}}" @selected(isset($admin) && $admin->role->name == $role->name)>{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('role_name') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr class="w-100">
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-start align-items-center gap-2">
                                                @if(isset($admin))
                                                    @can('update admin')
                                                        <button class="btn bg-gradient-success">{{  __('web/admin.edit')}}</button>
                                                    @endcan
                                                @else
                                                    @can('store admin')
                                                        <button class="btn bg-gradient-success">{{ __('web/admin.store')}}</button>
                                                    @endcan
                                                @endif
                                                    @can('index admin')
                                                        <a href="{{route('admin.admins.index')}}" class="btn bg-gradient-warning">{{ __('web/admin.back')}}</a>
                                                    @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 order-1 order-md-2 p-2">
                            <div class="card h-100 p-4">
                                <div class="row h-100 w-100 p-0 m-0">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="avatar" class="form-control-label">{{ __('web/admin.form.avatar')}}</label>
                                            <input class="d-none select-image form-control {{$errors->has('avatar') ? 'border-danger':''}}" type="file" name="avatar" id="avatar" autocomplete="off" placeholder="{{ __('web/admin.form.avatar')}}">
                                            @error('avatar') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            <label for="avatar" class="form-control parent_images d-flex justify-content-center align-items-center">
                                                @if(isset($admin) && $admin->getAvatarExists())
                                                    <img src="{{$admin->getAvatarUrl()}}" alt="user-image">
                                                @else
                                                    <i class="bi bi-upload"></i>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <hr class="w-100">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-check form-switch p-0 gap-2">
                                                <input class="form-check-input m-0" type="checkbox" name="active" dir="ltr" id="active" {{isset($admin) && $admin->active ? 'checked':''}}>
                                                <label class="form-check-label m-0" for="active">{{ __('web/admin.form.active')}}</label>
                                            </div>
                                            @error('active') <div class="text-danger text-14">{{$message}}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
