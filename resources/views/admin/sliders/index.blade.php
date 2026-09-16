@extends('admin.master')
@section('title',__('web/slider.list'))
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/slider.list'),'route' => route('admin.sliders.index'),'active' => 1],
                        ]
                    ])

                    @can('create slider')
                        <a href="{{route('admin.sliders.create')}}" class="btn bg-gradient-danger">{{__('web/slider.create')}}</a>
                    @endcan
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>{{__('web/slider.title')}}</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            @php $headers = array_values(__('web/slider.table')); @endphp
                            <x-table :headers="$headers" :items="$sliders">
                                @foreach($sliders->items as $key => $slider)
                                    <tr>
                                        <td class="text-center">{{$sliders->firstItem() + $key}}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="parent-image-table">
                                                    @if($slider->getImageExists())
                                                        <a href="{{$slider->getImageUrl()}}" target="_blank" class="w-100 h-100 d-flex">
                                                            <img src="{{$slider->getImageUrl()}}" alt="">
                                                        </a>
                                                    @else
                                                        <span>{{ mb_substr($slider->title, 0, 1, 'UTF-8') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{$slider->title}}</td>
                                        <td class="text-center">
                                            <a href="{{$slider->link}}" target="_blank" class="btn bg-gradient-warning btn-sm">{{__('web/slider.show')}}</a>
                                        </td>
                                        <td class="text-center">
                                            @if($slider->active)
                                                <span class="badge badge-pill bg-gradient-success">{{__('web/slider.table_options.active_value')}}</span>
                                            @else
                                                <span class="badge badge-pill bg-gradient-danger">{{__('web/slider.table_options.deActive_value')}}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($slider->type == \App\Enums\Slider\SliderTypeEnum::TOP_SITE)
                                                <span class="badge badge-pill bg-gradient-info">{{$slider->getTypePersian()}}</span>
                                            @elseif($slider->type == \App\Enums\Slider\SliderTypeEnum::BOTTOM_SITE)
                                                <span class="badge badge-pill bg-gradient-warning">{{$slider->getTypePersian()}}</span>
                                            @else
                                                <span>-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{$slider->getJalaliExpiredAt()}}</td>
                                        <td class="text-center">{{$slider->getJalaliCreatedAt()}}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                                                @can('edit slider')
                                                    <a href="{{route('admin.sliders.edit',['slider' => $slider->id])}}" class="btn btn-sm btn-warning m-0">{{__('web/slider.edit')}}</a>
                                                @endcan
                                                @can('destroy slider')
                                                        <a href="{{route('admin.sliders.destroy',['slider' => $slider->id])}}" class="btn btn-sm btn-danger m-0" data-confirm-delete="true">{{__('web/slider.destroy')}}</a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
