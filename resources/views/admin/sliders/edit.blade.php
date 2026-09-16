@extends('admin.master')

@section('title',isset($slider) ? __('web/slider.edit'):__('web/slider.create'))

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/slider.list'),'route' => route('admin.sliders.index'),'active' => 0],
                            ['title' => isset($slider) ? __('web/slider.edit'):__('web/slider.create'),'route' => isset($slider) ? route('admin.sliders.edit',['slider' => $slider->id]):route('admin.sliders.create'),'active' => 1],
                        ]
                    ])
                </div>
            </div>

            <div class="col-md-12">
                <form role="form" method="POST" action="{{isset($slider) ? route('admin.sliders.update',['slider' => $slider->id]):route('admin.sliders.store')}}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($slider))
                        @method('PUT')
                    @endif

                    <div class="row w-100 p-0 m-0">
                        <div class="col-md-8 order-2 order-md-1 p-2">
                            <div class="card h-100">
                                <div class="card-body">
                                    <p class="text-uppercase text-sm">{{isset($slider) ? __('web/slider.edit'):__('web/slider.create')}}</p>
                                    <div class="row w-100 m-0 px-0 py-2">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="title" class="form-control-label">{{__('web/slider.form.title')}}</label>
                                                <input class="form-control {{$errors->has('title') ? 'border-danger':''}}" type="text" name="title" id="title" value="{{isset($slider) ? $slider->title:old('title')}}" autocomplete="off" placeholder="{{__('web/slider.form.title')}}">
                                                @error('title') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="link" class="form-control-label">{{__('web/slider.form.link')}}</label>
                                                <input class="form-control {{$errors->has('link') ? 'border-danger':''}}" type="text" dir="ltr" name="link" id="link" value="{{isset($slider) ? $slider->link:old('link')}}" autocomplete="off" placeholder="{{__('web/slider.form.link')}}">
                                                @error('link') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="expired_at" class="form-control-label">{{__('web/slider.form.expired_at')}}</label>
                                                <input class="form-control {{$errors->has('expired_at') ? 'border-danger':''}}" data-jdp type="text" name="expired_at" id="expired_at" value="{{isset($slider) ? $slider->getExpiredAt():old('expired_at')}}" autocomplete="off" placeholder="{{__('web/slider.form.expired_at')}}">
                                                @error('expired_at') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description" class="form-control-label">{{__('web/slider.form.description')}}</label>
                                                <textarea name="description" id="description" cols="30" rows="5" class="form-control {{$errors->has('description') ? 'border-danger':''}}">{{isset($slider) ? $slider->description:old('description')}}</textarea>
                                                @error('description') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr class="w-100">
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-start align-items-center gap-2">
                                                @if(isset($slider))
                                                    @can('update slider')
                                                        <button class="btn bg-gradient-success">{{__('web/slider.edit')}}</button>
                                                    @endcan
                                                @else
                                                    @can('store slider')
                                                        <button class="btn bg-gradient-success">{{__('web/slider.store')}}</button>
                                                    @endcan
                                                @endif
                                                    @can('index slider')
                                                        <a href="{{route('admin.sliders.index')}}" class="btn bg-gradient-warning">{{__('web/slider.back')}}</a>
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
                                    <div class="row h-100 w-100 m-0 p-0">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="image" class="form-control-label">{{__('web/slider.form.image')}}</label>
                                                <input class="d-none select-image form-control {{$errors->has('image') ? 'border-danger':''}}" type="file" name="image" id="image" autocomplete="off" placeholder="{{__('web/slider.form.image')}}">
                                                @error('image') <div class="text-danger text-14">{{$message}}</div> @enderror
                                                <label for="image" class="form-control parent_images d-flex justify-content-center align-items-center">
                                                    @if(isset($slider) && $slider->getImageExists())
                                                        <img src="{{$slider->getImageUrl()}}" alt="user-image">
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
                                                    <input class="form-check-input m-0" type="checkbox" name="active" dir="ltr" id="active" {{isset($slider) && $slider->active ? 'checked':''}}>
                                                    <label class="form-check-label m-0" for="active">{{__('web/slider.form.active')}}</label>
                                                </div>
                                                @error('active') <div class="text-danger text-14">{{$message}}</div> @enderror
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
