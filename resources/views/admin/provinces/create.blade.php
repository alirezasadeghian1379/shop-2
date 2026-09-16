@extends('admin.master')

@section('title',isset($province) ? __('web/province.edit'):__('web/province.create'))

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/province.list'),'route' => route('admin.provinces.index'),'active' => 0],
                            ['title' => isset($province) ? __('web/province.edit'):__('web/province.create'),'route' => isset($province) ? route('admin.provinces.edit',['province' => $province->id]):route('admin.provinces.create'),'active' => 1],
                        ]
                    ])
                </div>
            </div>

            <div class="col-md-12">
                <form role="form" method="POST" action="{{isset($province) ? route('admin.provinces.update',['province' => $province->id]):route('admin.provinces.store')}}">
                    @csrf
                    @if(isset($province))
                        @method('PUT')
                    @endif

                    <div class="row w-100 m-0 p-0">
                        <div class="col-md-8 order-2 order-md-1 p-2">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-uppercase text-sm">{{isset($province) ? __('web/province.edit'):__('web/province.create')}}</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="form-control-label">{{__('web/province.form.name')}}</label>
                                                <input class="form-control {{$errors->has('name') ? 'border-danger':''}}" type="text" name="name" id="name" value="{{isset($province) ? $province->name:old('name')}}" autocomplete="off" placeholder="{{__('web/province.form.name')}}">
                                                @error('name') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="latitude" class="form-control-label">{{__('web/province.form.latitude')}}</label>
                                                <input class="form-control {{$errors->has('latitude') ? 'border-danger':''}}" type="text" name="latitude" id="latitude" value="{{isset($province) ? $province->latitude:old('latitude')}}" autocomplete="off" placeholder="{{__('web/province.form.latitude')}}">
                                                @error('latitude') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="longitude" class="form-control-label">{{__('web/province.form.longitude')}}</label>
                                                <input class="form-control {{$errors->has('longitude') ? 'border-danger':''}}" type="text" name="longitude" id="longitude" value="{{isset($province) ? $province->longitude:old('longitude')}}" autocomplete="off" placeholder="{{__('web/province.form.longitude')}}">
                                                @error('longitude') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>





                                        <div class="col-12">
                                            <hr class="w-100">
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-start align-items-center gap-2">
                                                @if(isset($province))
                                                    @can('update province')
                                                        <button class="btn bg-gradient-success">{{__('web/province.edit')}}</button>
                                                    @endcan
                                                @else
                                                    @can('store province')
                                                        <button class="btn bg-gradient-success">{{__('web/province.store')}}</button>
                                                    @endcan
                                                @endif
                                                @can('index province')
                                                    <a href="{{route('admin.provinces.index')}}" class="btn bg-gradient-warning">{{__('web/province.back')}}</a>
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
                                                <div class="form-check form-switch p-0 gap-2">
                                                    <input class="form-check-input m-0" type="checkbox" name="is_active" dir="ltr" id="is_active" {{isset($province) && $province->is_active ? 'checked':''}}>
                                                    <label class="form-check-label m-0" for="is_active">{{__('web/province.form.is_active')}}</label>
                                                </div>
                                                @error('is_active') <div class="text-danger text-14">{{$message}}</div> @enderror
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
