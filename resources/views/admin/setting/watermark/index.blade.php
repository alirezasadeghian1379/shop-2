@extends('admin.master')

@section('title',__('web/setting.watermark.title'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/setting.title'),'route' => route('admin.settings.index'),'active' => 0],
                            ['title' => __('web/setting.watermark.title'),'route' => route('admin.settings.watermark.index'),'active' => 1],
                        ]
                    ])
                </div>
            </div>

            <div class="col-md-12">
                <form role="form" method="POST" action="{{route('admin.settings.watermark.update')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="settings[watermark_ids]">

                    <div class="row w-100 m-0 p-0">
                        <div class="col-md-8 order-2 order-md-1 p-2">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-uppercase text-sm">{{__('web/setting.watermark.title')}}</p>
                                    <hr class="w-100">
                                    <div class="row bb-item-wrapper-custom">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-check form-switch p-0 gap-2">
                                                    <input type="hidden" name="settings[active_watermark]" value="0">
                                                    <input class="form-check-input m-0" type="checkbox" value="1" name="settings[active_watermark]" dir="ltr" id="active_watermark" {{isset($setting) && isset($setting['active_watermark']) && $setting['active_watermark'] ? 'checked':''}}>
                                                    <label class="form-check-label m-0" for="active_watermark">{{__('web/setting.form.active_watermark')}}</label>
                                                </div>
                                                @error('active_watermark') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="watermark_ids" class="form-control-label">{{__('web/setting.form.watermark_ids')}}</label>
                                                <select class="form-control select2 {{$errors->has('watermark_ids') ? 'border-danger':''}}" name="settings[watermark_ids][]" id="watermark_ids" multiple>
                                                    @foreach(\App\Enums\Gallery\StorageTypeEnum::getAccessWaterMarkTypes() as $type)
                                                        <option value="{{$type}}" {{isset($setting) && isset($setting['watermark_ids']) && in_array($type,json_decode($setting['watermark_ids'],true)) ? 'selected' : ''}}>{{\App\Enums\Gallery\StorageTypeEnum::getTypesPersian()[$type]}}</option>
                                                    @endforeach
                                                </select>
                                                @error('watermark_ids') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr class="w-100">
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-start align-items-center gap-2">
                                                @can('watermarkUpdate setting')
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
                                                        <input type="hidden" name="settings[watermark]">
                                                        <label for="watermark" class="form-control-label">{{__('web/setting.form.watermark')}}</label>
                                                        <input class="d-none select-image form-control {{$errors->has('watermark') ? 'border-danger':''}}" type="file" name="watermark" id="watermark" autocomplete="off" placeholder="{{__('web/setting.form.watermark')}}">
                                                        @error('watermark') <div class="text-danger text-14">{{$message}}</div> @enderror
                                                        <label for="watermark" class="form-control parent_images d-flex justify-content-center align-items-center">
                                                            @if(count($setting) && isset($setting['watermark']))
                                                                <img src="{{asset('storage/'.$setting['watermark'])}}" alt="user-image">
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
