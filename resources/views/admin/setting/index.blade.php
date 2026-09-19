@extends('admin.master')

@section('title',__('web/setting.title'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/setting.title'),'route' => route('admin.settings.index'),'active' => 1],
                        ]
                    ])
                </div>
            </div>

            <div class="col-md-12">
                <form role="form" method="POST" action="{{route('admin.settings.update')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row w-100 m-0 p-0">
                        <div class="col-md-8 order-2 order-md-1 p-2">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-uppercase text-sm">{{__('web/setting.title')}}</p>
                                    <div class="row bb-item-wrapper-custom">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="titleSite" class="form-control-label">{{__('web/setting.form.titleSite')}}</label>
                                                <input class="form-control {{$errors->has('titleSite') ? 'border-danger':''}}" type="text" name="settings[titleSite]" id="titleSite" value="{{isset($setting) && isset($setting['titleSite']) ? $setting['titleSite']:old('titleSite')}}" autocomplete="off" placeholder="{{__('web/setting.form.titleSite')}}">
                                                @error('titleSite') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="copyRight" class="form-control-label">{{__('web/setting.form.copyRight')}}</label>
                                                <input class="form-control {{$errors->has('copyRight') ? 'border-danger':''}}" type="text" name="settings[copyRight]" id="copyRight" value="{{isset($setting) && isset($setting['copyRight']) ? $setting['copyRight']:old('copyRight')}}" autocomplete="off" placeholder="{{__('web/setting.form.copyRight')}}">
                                                @error('copyRight') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone" class="form-control-label">{{__('web/setting.form.phone')}}</label>
                                                <input class="form-control {{$errors->has('phone') ? 'border-danger':''}}"
                                                       maxlength="11"
                                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                       type="text" name="settings[phone]" id="phone" value="{{isset($setting) && isset($setting['phone']) ? $setting['phone']:old('phone')}}" autocomplete="off" placeholder="{{__('web/setting.form.phone')}}">
                                                @error('phone') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-control-label">{{__('web/setting.form.email')}}</label>
                                                <input class="form-control {{$errors->has('email') ? 'border-danger':''}}"
                                                       type="text" name="settings[email]" id="email" value="{{isset($setting) && isset($setting['email']) ? $setting['email']:old('email')}}" autocomplete="off" placeholder="{{__('web/setting.form.email')}}">
                                                @error('email') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="short_description" class="form-control-label">{{__('web/setting.form.short_description')}}</label>
                                                <input class="form-control {{$errors->has('short_description') ? 'border-danger':''}}"
                                                       type="text" name="settings[short_description]" id="short_description" value="{{isset($setting) && isset($setting['short_description']) ? $setting['short_description']:old('short_description')}}" autocomplete="off" placeholder="{{__('web/setting.form.short_description')}}">
                                                @error('short_description') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="link_sticky" class="form-control-label">{{__('web/setting.form.link_sticky')}}</label>
                                                <input class="form-control {{$errors->has('link_sticky') ? 'border-danger':''}}"
                                                       type="text" name="settings[link_sticky]" id="link_sticky" value="{{isset($setting) && isset($setting['link_sticky']) ? $setting['link_sticky']:old('link_sticky')}}" autocomplete="off" placeholder="{{__('web/setting.form.link_sticky')}}">
                                                @error('link_sticky') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <hr class="w-100">
                                        </div>


                                        <div class="col-12">
                                            <div class="d-flex justify-content-start align-items-center gap-2">
                                                @can('update setting')
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
                                                        <input type="hidden" name="settings[logo]">
                                                        <label for="logo" class="form-control-label">{{__('web/setting.form.logo')}}</label>
                                                        <input class="d-none select-image form-control {{$errors->has('logo') ? 'border-danger':''}}" type="file" name="logo" id="logo" autocomplete="off" placeholder="{{__('web/setting.form.logo')}}">
                                                        @error('logo') <div class="text-danger text-14">{{$message}}</div> @enderror
                                                        <label for="logo" class="form-control parent_images d-flex justify-content-center align-items-center">
                                                            @if(count($setting)  && isset($setting['logo']))
                                                                <img src="{{asset('storage/'.$setting['logo'])}}" alt="user-image">
                                                            @else
                                                                <i class="bi bi-upload"></i>
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="hidden" name="settings[icon]">
                                                        <label for="icon" class="form-control-label">{{__('web/setting.form.icon')}}</label>
                                                        <input class="d-none select-image form-control {{$errors->has('icon') ? 'border-danger':''}}" type="file" name="icon" id="icon" autocomplete="off" placeholder="{{__('web/setting.form.icon')}}">
                                                        @error('icon') <div class="text-danger text-14">{{$message}}</div> @enderror
                                                        <label for="icon" class="form-control parent_images d-flex justify-content-center align-items-center">
                                                            @if(count($setting) && isset($setting['icon']))
                                                                <img src="{{asset('storage/'.$setting['icon'])}}" alt="user-image">
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
        .parent_videos {
            cursor: pointer !important;
            video {
                height: 75% !important;
                object-fit: cover;
                border-radius: 10px;
            }
        }
        #map-address {
            width: 100%;
            height: 250px;
            border-radius: 10px;
        }
        .mapp-logo {
            display: none !important;
        }

        .bb-item-wrapper-custom .bb-custom + .bb-custom {
            border-top: 1px solid #e5e7eb;
            padding: 10px 0;
        }

        .removeRuleItem,
        .removeSkillItem,
        .removeHelpItem {
            color: red;
            font-size: 22px;
            font-weight: 800;
            position: absolute;
            bottom: 50%;
            transform: translateY(50%);
            left: 5px;
            cursor: pointer;
            z-index: 9999;
        }
    </style>
@endsection
@section('script')
    <script>
        let api_token = @json(config('mapIr.api_token'));
        const defaultLat = $('#location-latitude').val();
        const defaultLng = $('#location-longitude').val();
        $(document).ready(function() {
            var app = new Mapp({
                element: '#map-address',
                presets: {
                    latlng: {
                        lat: defaultLat,
                        lng: defaultLng,
                    },
                    zoom: 14,
                },
                apiKey: api_token
            });
            app.addLayers();
            app.addMarker({
                name: 'advanced-marker',
                latlng: {
                    lat: defaultLat,
                    lng: defaultLng
                },
                icon: app.icons.red,
                popup: false
            });
            app.map.on('click', function(e) {
                let lat = e.latlng.lat;
                let lng = e.latlng.lng;
                app.addMarker({
                    name: 'advanced-marker',
                    latlng: {
                        lat: lat,
                        lng: lng
                    },
                    icon: app.icons.red,
                    popup: false
                });
                $('#location-latitude').val(lat)
                $('#location-longitude').val(lng)
            });
        });
    </script>
    <script>
        let number = @json(isset($setting['ruleOptions']) ? count(json_decode($setting['ruleOptions'],true)['general']):0);
        $('.addRuleItem').on('click',(e)=>{
            let wrapper = $(e.currentTarget).parent().parent().children('div.parentRuleItemsWrapper').children('div#parentRuleItems')
            let dataType = $(e.currentTarget).attr('data-type')
            number++
            let item =
                `<div class="col-md-6">
                    <div class="form-group position-relative">
                        <input class="form-control" type="text" name="settings[ruleOptions][${dataType}][${number}]" id="work_title" autocomplete="off">
                        <span class="removeRuleItem"><i class="bi bi-x d-flex"></i></span>
                    </div>
                </div>`
            wrapper.append(item)
        })
        $('.parentRuleItemsWrapper').on('click','.removeRuleItem',(e) =>{
            let wrapper = $(e.currentTarget).parent().parent()
            wrapper.remove()
        })
    </script>
    <script>
        let helpNumber = @json(isset($setting) && isset($setting['help']) ? count(json_decode($setting['help'],true)) : 0);
        $('#createHelpItem').on('click',()=>{
            helpNumber++
            let item = `
            <div class="col-md-6">
                <div class="form-group position-relative">
                    <input class="form-control" type="text" name="settings[help][${helpNumber}]" value="" autocomplete="off">
                    <span class="removeHelpItem"><i class="bi bi-x d-flex"></i></span>
                </div>
            </div>
            `
            $('.parentHelpItems').append(item)
        })
        $('.parentHelpItems').on('click','.removeHelpItem',(e)=>{
            $(e.currentTarget).parent().parent().remove()
        })


        let skillNumber = @json(isset($setting) && isset($setting['skill']) ? count(json_decode($setting['skill'],true)) : 0);
        $('#createSkillItem').on('click',()=>{
            skillNumber++
            let item = `
            <div class="col-md-6">
                <div class="form-group position-relative">
                    <input class="form-control" type="text" name="settings[skill][${skillNumber}]" value="" autocomplete="off">
                    <span class="removeSkillItem"><i class="bi bi-x d-flex"></i></span>
                </div>
            </div>
            `
            $('.parentSkillItems').append(item)
        })
        $('.parentSkillItems').on('click','.removeSkillItem',(e)=>{
            $(e.currentTarget).parent().parent().remove()
        })

    </script>
    <script>
        $('.select-video').on('change', function (e) {
            let file = e.target.files[0];
            let parent_images = $(e.target).parent().children('label.parent_images')
            let reader = new FileReader()
            reader.onload = function (e) {
                let result = e.target.result
                let image = `<video src=${result} width="100%" height="100%" class="h-100 w-100" controls></video><span class="btn-transparent">تغییر</span>`
                parent_images.html(image)
            }
            reader.readAsDataURL(file)
        })

    </script>
@endsection
