@extends('admin.master')

@section('title',isset($city) ? __('web/city.edit'):__('web/city.create'))

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/city.list'),'route' => route('admin.cities.index'),'active' => 0],
                            ['title' => isset($city) ? __('web/city.edit'):__('web/city.create'),'route' => isset($city) ? route('admin.cities.edit',['city' => $city->id]):route('admin.cities.create'),'active' => 1],
                        ]
                    ])
                </div>
            </div>

            <div class="col-md-12">
                <form role="form" method="POST" action="{{isset($city) ? route('admin.cities.update',['city' => $city->id]):route('admin.cities.store')}}">
                    @csrf
                    @if(isset($city))
                        @method('PUT')
                    @endif

                    <div class="row w-100 m-0 p-0">
                        <div class="col-md-8 order-2 order-md-1 p-2">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-uppercase text-sm">{{isset($city) ? __('web/city.edit'):__('web/city.create')}}</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="form-control-label">{{__('web/city.form.name')}}</label>
                                                <input class="form-control {{$errors->has('name') ? 'border-danger':''}}" type="text" name="name" id="name" value="{{isset($city) ? $city->name:old('name')}}" autocomplete="off" placeholder="{{__('web/city.form.name')}}">
                                                @error('name') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group {{$errors->has('province_id') ? 'border-danger':''}}">
                                                <label for="province_id" class="form-control-label">{{__('web/city.form.province_id')}}</label>
                                                <select name="province_id" id="province_id" class="form-control select2 changeProvince">
                                                    <option value="" disabled selected>{{__('web/city.state.default')}}</option>
                                                    @foreach($provinces as $province)
                                                        <option value="{{$province->id}}" @selected(isset($city) && $city->province->id == $province->id)>{{$province->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('province_id') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="latitude" class="form-control-label">{{__('web/city.form.latitude')}}</label>
                                                <input class="form-control {{$errors->has('latitude') ? 'border-danger':''}}" type="text" name="latitude" id="latitude" value="{{isset($city) ? $city->latitude:old('latitude')}}" autocomplete="off" placeholder="{{__('web/city.form.latitude')}}">
                                                @error('latitude') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="longitude" class="form-control-label">{{__('web/city.form.longitude')}}</label>
                                                <input class="form-control {{$errors->has('longitude') ? 'border-danger':''}}" type="text" name="longitude" id="longitude" value="{{isset($city) ? $city->longitude:old('longitude')}}" autocomplete="off" placeholder="{{__('web/city.form.longitude')}}">
                                                @error('longitude') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>





                                        <div class="col-12">
                                            <hr class="w-100">
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-start align-items-center gap-2">
                                                @if(isset($city))
                                                    @can('update city')
                                                        <button class="btn bg-gradient-success">{{__('web/city.edit')}}</button>
                                                    @endcan
                                                @else
                                                    @can('store city')
                                                        <button class="btn bg-gradient-success">{{__('web/city.store')}}</button>
                                                    @endcan
                                                @endif
                                                    @can('index city')
                                                        <a href="{{route('admin.cities.index')}}" class="btn bg-gradient-warning">{{__('web/city.back')}}</a>
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
                                                    <input class="form-check-input m-0" type="checkbox" name="is_active" dir="ltr" id="is_active" {{isset($city) && $city->is_active ? 'checked':''}}>
                                                    <label class="form-check-label m-0" for="is_active">{{__('web/city.form.is_active')}}</label>
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
