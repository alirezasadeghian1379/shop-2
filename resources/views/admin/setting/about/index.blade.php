@extends('admin.master')

@section('title',__('web/setting.about.title'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/setting.title'),'route' => route('admin.settings.index'),'active' => 0],
                            ['title' => __('web/setting.about.title'),'route' => route('admin.settings.about.index'),'active' => 1],
                        ]
                    ])
                </div>
            </div>

            <div class="col-md-12">
                <form role="form" method="POST" action="{{route('admin.settings.about.update')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row w-100 m-0 p-0">
                        <div class="col-md-8 order-2 order-md-1 p-2">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-uppercase text-sm">{{__('web/setting.about.title')}}</p>
                                    <div class="row bb-item-wrapper-custom">


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="about_title" class="form-control-label">{{__('web/setting.about.form.title')}}</label>
                                                <input class="form-control {{$errors->has('about_title') ? 'border-danger':''}}" type="text" name="settings[about_title]" id="about_title" value="{{isset($setting) && isset($setting['about_title']) ? $setting['about_title']:old('about_title')}}" autocomplete="off" placeholder="{{__('web/setting.about.form.title')}}">
                                                @error('about_title') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="about_text" class="form-control-label">{{__('web/setting.about.form.text')}}</label>
                                                <textarea name="settings[about_text]" autocomplete="off" id="about_text" class="form-control tinyMce {{$errors->has('about_text') ? 'border-danger':''}}" cols="30" rows="5">{{isset($setting) && isset($setting['about_text']) ? $setting['about_text']:old('about_text')}}</textarea>
                                                @error('about_text') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <hr class="w-100">
                                        </div>



                                        <div class="col-12">
                                            <div class="d-flex justify-content-start align-items-center gap-2">
                                                @can('aboutUpdate setting')
                                                    <button class="btn bg-gradient-success">{{__('web/setting.edit')}}</button>
                                                @endcan
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 order-1 order-md-2 p-2">
                            <div class="row w-100 p-0 m-0 row-gap-2">
                                <div class="col-12 p-0">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="row w-100 p-0 m-0">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="hidden" name="settings[about_image]">
                                                        <label for="about_image" class="form-control-label">{{__('web/setting.about.form.image')}}</label>
                                                        <input class="d-none select-image form-control {{$errors->has('about_image') ? 'border-danger':''}}" type="file" name="about_image" id="about_image" autocomplete="off" placeholder="{{__('web/setting.about.form.image')}}">
                                                        @error('about_image') <div class="text-danger text-14">{{$message}}</div> @enderror
                                                        <label for="about_image" class="form-control parent_images d-flex justify-content-center align-items-center">
                                                            @if(count($setting)  && isset($setting['about_image']))
                                                                <img src="{{asset('storage/'.$setting['about_image'])}}" alt="user-image">
                                                            @else
                                                                <i class="bi bi-upload"></i>
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>
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
        .btn-transparent {
            background-color: transparent;
            border-radius: 5px;
            border: 1px solid lightgrey;
            padding: 10px 20px;
        }
        .bb-item-wrapper-custom .bb-custom + .bb-custom {
            border-top: 1px solid #e5e7eb;
            padding: 10px 0;
        }
    </style>
@endsection
