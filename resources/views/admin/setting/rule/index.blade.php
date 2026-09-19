@extends('admin.master')

@section('title',__('web/setting.rule.title'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/setting.title'),'route' => route('admin.settings.index'),'active' => 0],
                            ['title' => __('web/setting.rule.title'),'route' => route('admin.settings.rule.index'),'active' => 1],
                        ]
                    ])
                </div>
            </div>

            <div class="col-md-12">
                <form role="form" method="POST" action="{{route('admin.settings.rule.update')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row w-100 m-0 p-0">
                        <div class="col-md-12 p-2">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-uppercase text-sm">{{__('web/setting.rule.title')}}</p>
                                    <div class="row bb-item-wrapper-custom">


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="rule_title" class="form-control-label">{{__('web/setting.rule.form.title')}}</label>
                                                <input class="form-control {{$errors->has('rule_title') ? 'border-danger':''}}" type="text" name="settings[rule_title]" id="rule_title" value="{{isset($setting) && isset($setting['rule_title']) ? $setting['rule_title']:old('rule_title')}}" autocomplete="off" placeholder="{{__('web/setting.rule.form.title')}}">
                                                @error('rule_title') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="rule_text" class="form-control-label">{{__('web/setting.rule.form.text')}}</label>
                                                <textarea name="settings[rule_text]" autocomplete="off" id="rule_text" class="form-control tinyMce {{$errors->has('rule_text') ? 'border-danger':''}}" cols="30" rows="5">{{isset($setting) && isset($setting['rule_text']) ? $setting['rule_text']:old('rule_text')}}</textarea>
                                                @error('rule_text') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <hr class="w-100">
                                        </div>



                                        <div class="col-12">
                                            <div class="d-flex justify-content-start align-items-center gap-2">
                                                @can('ruleUpdate setting')
                                                    <button class="btn bg-gradient-success">{{__('web/setting.edit')}}</button>
                                                @endcan
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
