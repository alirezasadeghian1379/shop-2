@extends('admin.master')

@section('title',isset($notification) ? __('web/notification.edit'):__('web/notification.create'))

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/notification.list'),'route' => route('admin.notifications.index'),'active' => 0],
                            ['title' => isset($notification) ? __('web/notification.edit'):__('web/notification.create'),'route' => isset($notification) ? route('admin.notifications.edit',['notification' => $notification->id]):route('admin.notifications.create'),'active' => 1],
                        ]
                    ])
                </div>
            </div>

            <div class="col-md-12">
                <form role="form" method="POST" action="{{isset($notification) ? route('admin.notifications.update',['notification' => $notification->id]):route('admin.notifications.store')}}">
                    @csrf
                    @if(isset($notification))
                        @method('PUT')
                    @endif

                    <div class="row w-100 m-0 p-0">
                        <div class="col-md-8 order-2 order-md-1 p-2">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-uppercase text-sm">{{isset($notification) ? __('web/notification.edit'):__('web/notification.create')}}</p>
                                    <div class="row">


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="title" class="form-control-label">{{__('web/notification.form.title')}}</label>
                                                <input class="form-control {{$errors->has('title') ? 'border-danger':''}}" {{isset($notification) ? 'disabled':''}} type="text" name="title" id="title" value="{{isset($notification) ? $notification->title:old('title')}}" autocomplete="off" placeholder="{{__('web/notification.form.title')}}">
                                                @error('title') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="message" class="form-control-label">{{__('web/notification.form.message')}}</label>
                                                <textarea name="message" class="form-control {{$errors->has('message') ? 'border-danger':''}}" {{isset($notification) ? 'disabled':''}} id="message" cols="30" rows="5">{{isset($notification) ? $notification->message:old('message')}}</textarea>
                                                @error('message') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <hr class="w-100">
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-start align-items-center gap-2">
                                                @if(isset($notification))
                                                    @can('update notification')
                                                        <button class="btn bg-gradient-success">{{__('web/notification.edit')}}</button>
                                                    @endcan
                                                @else
                                                    @can('store notification')
                                                        <button class="btn bg-gradient-success">{{__('web/notification.store')}}</button>
                                                    @endcan
                                                @endif
                                                    @can('index notification')
                                                        <a href="{{route('admin.notifications.index')}}" class="btn bg-gradient-warning">{{__('web/notification.back')}}</a>
                                                    @endcan
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 order-1 order-md-2 p-2">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row w-100 p-0 m-0">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="url" class="form-control-label">{{__('web/notification.form.url')}}</label>
                                                <input class="form-control {{$errors->has('url') ? 'border-danger':''}}" {{isset($notification) ? 'disabled':''}} dir="ltr" type="text" name="url" id="url" value="{{isset($notification) ? $notification->url:old('url')}}" autocomplete="off" placeholder="{{__('web/notification.form.url')}}">
                                                @error('url') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="type" class="form-control-label">{{__('web/notification.form.type')}}</label>
                                                <select name="type" id="type" class="form-control {{$errors->has('type') ? 'border-danger':''}}" {{isset($notification) ? 'disabled':''}}>
                                                    <option value="" selected disabled>{{__('web/notification.select_options.default')}}</option>
                                                    @foreach(\App\Enums\Notification\NotificationTypeEnum::getTypes() as $type)
                                                        <option value="{{$type}}" {{isset($notification) ? ( $notification->type == $type ? 'selected':'' ) : ( old('type') == $type ? 'selected':'' )}}>{{\App\Enums\Notification\NotificationTypeEnum::getTypesDescription()[$type]}}</option>
                                                    @endforeach
                                                </select>
                                                @error('type') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>


                                        @if(!isset($notification))
                                            <div class="col-md-12 {{ isset($notification) ? ( $notification->is_global ? 'd-block':'d-none' ):( old('is_global') ? 'd-block':'d-none' )  }}" id="selectUserWrapper">
                                                <div class="form-group {{$errors->has('user_ids') ? 'border-danger':''}}">
                                                    <label for="user_ids" class="form-control-label">{{__('web/notification.form.user_ids')}}</label>
                                                    <select name="user_ids[]" multiple id="user_ids" class="form-control select2" {{isset($notification) ? 'disabled':''}}>
                                                        <option value="" selected disabled>{{__('web/notification.select_options.default')}}</option>
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}">{{$user->getFullName()}} - {{$user->phone}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_ids') <div class="text-danger text-14">{{$message}}</div> @enderror
                                                </div>
                                            </div>
                                        @else

                                            @if(isset($userNotifications) && count($userNotifications))
                                                <p>کاربران</p>
                                                <hr class="w-100">
                                                <ul class="list-style-custom">
                                                    @foreach($userNotifications as $userNotification)
                                                        <li>
                                                            @if($userNotification->user->is_admin)
                                                                <a href="{{route('admin.admins.edit',['admin' => $userNotification->user->id])}}">{{$userNotification->user->full_name}} ( {{$userNotification->user->phone}} )</a>
                                                            @else
                                                                <a href="{{route('admin.users.edit',['user' => $userNotification->user->id])}}">{{$userNotification->user->full_name}} ( {{$userNotification->user->phone}} )</a>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                        @endif




                                        <div class="col-12">
                                            <hr class="w-100">
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-check form-switch p-0 gap-2">
                                                    <input class="form-check-input m-0" type="checkbox" name="is_global" dir="ltr" id="is_global" {{isset($notification) ? 'disabled':''}} {{isset($notification) ? ( $notification->is_global ? 'checked':'' ): ( old('is_global') ? 'checked':''  )}}>
                                                    <label class="form-check-label m-0" for="is_global">{{__('web/notification.form.is_global')}}</label>
                                                </div>
                                                @error('is_global') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
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

@section('style')
    <style>
        .list-style-custom {
            display: flex;
            justify-content: start;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            width: 100%;
            margin: 0;
            padding: 0;
            list-style: none;
            li {
                padding: 4px 15px;
                background-color: rgba(211, 211, 211, 0.36);
                border-radius: 15px;
            }
        }
        .select2 {
            width: 100% !important;
        }
        .border-danger {
            .select2-selection {
                border: 1px solid red !important;
            }
        }
    </style>
@endsection

@section('script')
    <script>
        $('#is_global').on('change', (e) => {
            const isChecked = $(e.target).prop('checked');
            if(isChecked){
                $('#selectUserWrapper').removeClass('d-none')
                $('#selectUserWrapper').addClass('d-block')
            } else {
                $('#selectUserWrapper').addClass('d-none')
                $('#selectUserWrapper').removeClass('d-block')
            }
        });
    </script>
@endsection
