@extends('admin.master')

@section('title',__('web/setting.social.title'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/setting.title'),'route' => route('admin.settings.index'),'active' => 0],
                            ['title' => __('web/setting.social.title'),'route' => route('admin.settings.social.index'),'active' => 1],
                        ]
                    ])
                </div>
            </div>

            <div class="col-md-12">
                <form role="form" method="POST" action="{{route('admin.settings.social.update')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="settings[social]">
                    <div class="row w-100 m-0 p-0">
                        <div class="col-md-12 p-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                                        <p class="text-uppercase text-sm m-0">{{__('web/setting.social.title')}}</p>
                                        <button class="btn bg-gradient-info" id="socialCreate" type="button">{{__('web/setting.social.add')}}</button>
                                    </div>
                                    <hr class="w-100">
                                    <div class="row bb-item-wrapper-custom">
                                        <div class="col-12 py-2" id="parentSocial">
                                            @if(isset($setting) && !empty($setting['social']))
                                                @foreach(json_decode($setting['social'],true) as $socialKey => $socialValue)
                                                    <div class="row social-item w-100 px-0 py-2 m-0 align-items-end" data-index="{{$socialKey}}">
                                                        <div class="col-md-3">
                                                            <div class="form-group m-0">
                                                                <label for="socialTitle-{{$socialKey}}" class="form-control-label">{{__('web/setting.social.form.title')}}</label>
                                                                <input class="form-control" type="text" name="settings[social][{{$socialKey}}][title]" id="socialTitle-{{$socialKey}}" value="{{$socialValue['title']}}" autocomplete="off" placeholder="{{__('web/setting.social.form.title')}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group m-0">
                                                                <label for="socialLink-{{$socialKey}}" class="form-control-label">{{__('web/setting.social.form.link')}}</label>
                                                                <input class="form-control" type="url" name="settings[social][{{$socialKey}}][link]" id="socialLink-{{$socialKey}}" value="{{$socialValue['link']}}" autocomplete="off" placeholder="{{__('web/setting.social.form.link')}}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group m-0">
                                                                <label for="socialType-{{$socialKey}}" class="form-control-label">{{__('web/setting.social.form.type')}}</label>

                                                                <select class="form-control socialTypesParent" name="settings[social][{{$socialKey}}][type]" id="socialType-{{$socialKey}}">
                                                                    <option value="" selected disabled>{{__('web/setting.selectOptions.default')}}</option>
                                                                    @foreach(\App\Enums\Setting\SettingSocialEnum::getTypesPersian() as $socialEnumKey => $socialEnumValue)
                                                                        <option value="{{$socialEnumValue['key']}}" @selected(($socialValue['type'] ?? null) === $socialEnumValue['key'])>{{$socialEnumValue['value']}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <button class="btn bg-gradient-danger w-100 removeSocialItem" type="button">{{__('web/setting.social.remove')}}</button>
                                                        </div>
                                                    </div>

                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="col-12">
                                            <hr class="w-100">
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-start align-items-center gap-2">
                                                @can('socialUpdate setting')
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
@section('script')
    <script>
        let number = @json(isset($setting) && !empty($setting['social']) ? count(json_decode($setting['social'],true)):0);

        const socialTypes = @json(\App\Enums\Setting\SettingSocialEnum::getTypesPersian());

        const translations = {
            title: @json(__('web/setting.social.form.title')),
            link: @json(__('web/setting.social.form.link')),
            type: @json(__('web/setting.social.form.type')),
            selectDefault: @json(__('web/setting.selectOptions.default')),
            remove: @json(__('web/setting.social.remove')),
        };

        function escapeHtml(value) {
            return $('<div>')
                .text(String(value))
                .html();
        }

        function createSocialTypeOptions() {
            return socialTypes
                .map((item) => `
                    <option value="${escapeHtml(item.key)}">
                        ${escapeHtml(item.value)}
                    </option>
                `)
                .join('');
        }



        $('#socialCreate').on('click',()=>{
            const index = number++;

            const item = `
                <div class="row social-item w-100 px-0 py-2 m-0 align-items-end" data-index="${index}" >
                    <div class="col-md-3">
                        <div class="form-group m-0">
                            <label for="socialTitle-${index}" class="form-control-label" > ${translations.title} </label>
                            <input class="form-control" type="text" name="settings[social][${index}][title]" id="socialTitle-${index}" autocomplete="off" placeholder="${translations.title}" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group m-0">
                            <label for="socialLink-${index}" class="form-control-label" > ${translations.link} </label>
                            <input class="form-control" type="url" name="settings[social][${index}][link]" id="socialLink-${index}" autocomplete="off" placeholder="${translations.link}" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group m-0">
                            <label for="socialType-${index}" class="form-control-label" > ${translations.type} </label>
                            <select class="form-control socialTypesParent" name="settings[social][${index}][type]" id="socialType-${index}" >
                                <option value="" selected disabled> ${translations.selectDefault} </option>
                                ${createSocialTypeOptions()}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn bg-gradient-danger w-100 removeSocialItem" type="button" > ${translations.remove} </button>
                    </div>
                </div>
            `;

            $('#parentSocial').append(item);
        })

        $('#parentSocial').on('click','.removeSocialItem',(e)=>{
            $(e.currentTarget).parent().parent().remove()
        })

    </script>
@endsection
