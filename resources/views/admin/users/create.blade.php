@extends('admin.master')

@section('title',isset($user) ? __('web/user.edit'):__('web/user.create'))

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/user.list'),'route' => route('admin.users.index'),'active' => 0],
                            ['title' => isset($user) ? __('web/user.edit'):__('web/user.create'),'route' => isset($user) ? route('admin.users.edit',['user' => $user->id]):route('admin.users.create'),'active' => 1],
                        ]
                    ])
                </div>
            </div>

            <div class="col-md-12">
                <form role="form" method="POST" action="{{isset($user) ? route('admin.users.update',['user' => $user->id]):route('admin.users.store')}}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif
                    <div class="row w-100 p-0 m-0">
                        <div class="col-md-8 order-2 order-md-1 p-2">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-uppercase text-sm">{{isset($user) ? __('web/user.edit'):__('web/user.create')}}</p>
                                    <div class="row h-100 w-100 m-0 py-2 px-0">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="first_name" class="form-control-label">{{__('web/user.form.first_name')}}</label>
                                                <input class="form-control {{$errors->has('first_name') ? 'border-danger':''}}" type="text" name="first_name" id="first_name" value="{{isset($user) ? $user->first_name:old('first_name')}}" autocomplete="off" placeholder="{{__('web/user.form.first_name')}}">
                                                @error('first_name') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name" class="form-control-label">{{__('web/user.form.last_name')}}</label>
                                                <input class="form-control {{$errors->has('last_name') ? 'border-danger':''}}" type="text" name="last_name" id="last_name" value="{{isset($user) ? $user->last_name:old('last_name')}}" autocomplete="off" placeholder="{{__('web/user.form.last_name')}}">
                                                @error('last_name') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone" class="form-control-label">{{__('web/user.form.phone')}}</label>
                                                <input class="form-control {{$errors->has('phone') ? 'border-danger':''}}" oninput="this.value = this.value.replace(/[^0-9]/g,'').replace(/(\..*)\./g,'$1');" maxLength="11" type="text" name="phone" id="phone" value="{{isset($user) ? $user->phone:old('phone')}}" autocomplete="off" placeholder="{{__('web/user.form.phone')}}">
                                                @error('phone') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-control-label">{{__('web/user.form.email')}}</label>
                                                <input class="form-control {{$errors->has('email') ? 'border-danger':''}}" type="text" name="email" id="email" value="{{isset($user) ? $user->email:old('email')}}" autocomplete="off" placeholder="{{__('web/user.form.email')}}">
                                                @error('email') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <hr class="w-100">
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-start align-items-center gap-2">
                                                @if(isset($user))
                                                    @can('update user')
                                                        <button class="btn bg-gradient-success">{{__('web/user.edit')}}</button>
                                                    @endcan
                                                @else
                                                    @can('store user')
                                                        <button class="btn bg-gradient-success">{{__('web/user.store')}}</button>
                                                    @endcan
                                                @endif
                                                    @can('index user')
                                                        <a href="{{route('admin.users.index')}}" class="btn bg-gradient-warning">{{__('web/user.back')}}</a>
                                                    @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 order-1 order-md-2 p-2">
                            <div class="card h-100 p-4">
                                <div class="row w-100 p-0 m-0">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="avatar" class="form-control-label">{{__('web/user.form.avatar')}}</label>
                                            @if(isset($user) && $user->getAvatarExists())
                                                <a href="{{$user->getAvatarUrl()}}" download="{{$user->phone.'-'.$user->getFullName()}}" class="badge bg-gradient-info text-white">{{__('web/user.auth.download')}}</a>
                                            @endif
                                            <input class="d-none select-image form-control {{$errors->has('avatar') ? 'border-danger':''}}" type="file" name="avatar" id="avatar" autocomplete="off" placeholder="{{__('web/user.form.avatar')}}">
                                            @error('avatar') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            <label for="avatar" class="form-control parent_images d-flex justify-content-center align-items-center">
                                                @if(isset($user) && $user->getAvatarExists())
                                                    <img src="{{$user->getAvatarUrl()}}" alt="user-image">
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
                                                <input class="form-check-input m-0" type="checkbox" name="active" dir="ltr" id="active" {{isset($user) && $user->active ? 'checked':''}}>
                                                <label class="form-check-label m-0" for="active">{{__('web/user.form.active')}}</label>
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
