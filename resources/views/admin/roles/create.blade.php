@extends('admin.master')

@section('title',isset($role) ?  __('web/role.edit'): __('web/role.create'))


@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' =>  __('web/role.list'),'route' => route('admin.roles.index'),'active' => 0],
                            ['title' => isset($role) ?  __('web/role.edit'): __('web/role.create') ,'route' => isset($role) ? route('admin.roles.edit',['role' => $role->id]):route('admin.roles.create'),'active' => 1],
                        ]
                    ])
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <form role="form" method="POST" action="{{isset($role) ? route('admin.roles.update',['role' => $role->id]) :route('admin.roles.store') }}">
                        @csrf
                        @if(isset($role))
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <p class="text-uppercase text-sm">{{isset($role) ?  __('web/role.edit'): __('web/role.create')}}</p>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name" class="form-control-label">{{ __('web/role.form.name')}}</label>
                                        <input class="form-control {{$errors->has('name') ? 'border-danger':''}}" type="text" name="name" id="name" value="{{isset($role) ? $role->name : old('name')}}" autocomplete="off" placeholder="{{ __('web/role.form.name')}}">
                                        @error('name') <div class="text-danger text-14">{{$message}}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row w-100 m-0 p-0 row-gap-2">
                                        <div class="col-12">
                                            @error('permissions') <div class="text-danger text-14">{{$message}}</div> @enderror
                                        </div>
                                        @foreach(\App\Enums\Role\PermissionEnum::Models() as $modelName => $model)
                                            @php $slug = \Illuminate\Support\Str::slug($modelName, '-') @endphp
                                            <div class="col-12 p-0 card-role" data-model="{{ $slug }}">
                                                <span class="bg-warning w-100 d-flex p-2 text-white">
                                                    {{ \App\Enums\Role\PermissionEnum::ModelsTitle[$modelName] }}
                                                </span>
                                                <div class="items">
                                                    <div class="item">
                                                        <div class="form-check form-switch p-0 flex-column justify-content-start align-items-start" dir="rtl">
                                                            <label class="form-check-label m-0">{{ __('web/role.form.all')}}</label>
                                                            <input class="form-check-input btn-select-all" type="checkbox" role="switch" dir="ltr">
                                                        </div>
                                                    </div>

                                                    @foreach($model['actions'] as $actionName => $action)
                                                        <div class="item">
                                                            <div class="form-check form-switch p-0 flex-column justify-content-start align-items-start" dir="rtl">
                                                                <label class="form-check-label m-0">{{ $action }}</label>
                                                                <input class="form-check-input permission" type="checkbox" role="switch" dir="ltr"
                                                                       name="permissions[]"
                                                                       value="{{ $actionName .' '. $modelName }}"
                                                                       @if(isset($role) && in_array($actionName .' '. $modelName, $role->getAllPermissionNames())) checked @endif
                                                                >
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr class="w-100">
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-start align-items-center gap-2">
                                        @if(isset($role))
                                            @can('update role')
                                                <button class="btn bg-gradient-success">{{ __('web/role.edit')}}</button>
                                            @endcan
                                        @else
                                            @can('store role')
                                                <button class="btn bg-gradient-success">{{ __('web/role.store')}}</button>
                                            @endcan
                                        @endif
                                            @can('index role')
                                                <a href="{{route('admin.roles.index')}}" class="btn bg-gradient-warning">{{ __('web/role.back')}}</a>
                                            @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(document).on('change', '.card-role .btn-select-all', function() {
                var $container = $(this).closest('.card-role');
                var checked = $(this).is(':checked');
                $container.find('.permission').prop('checked', checked);
            });
            $(document).on('change', '.card-role .permission', function() {
                var $container = $(this).closest('.card-role');
                var allChecked = $container.find('.permission').length === $container.find('.permission:checked').length;
                $container.find('.btn-select-all').prop('checked', allChecked);
            });
            $('.card-role').each(function() {
                var allChecked = $(this).find('.permission').length === $(this).find('.permission:checked').length;
                $(this).find('.btn-select-all').prop('checked', allChecked);
            });
        });
    </script>
@endsection
