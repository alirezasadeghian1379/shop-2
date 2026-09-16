@extends('admin.master')
@section('title',__('web/city.list'))
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/city.list'),'route' => route('admin.cities.index'),'active' => 1],
                        ]
                    ])
                    @can('create city')
                        <a href="{{route('admin.cities.create')}}" class="btn bg-gradient-danger">{{__('web/city.create')}}</a>
                    @endcan
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>{{__('web/city.title')}}</h6>
                        <hr class="w-100">
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            @php $headers = array_values(__('web/city.table')); @endphp
                            <x-table :headers="$headers" :items="$cities">
                                @foreach($cities->items as $key => $city)
                                    <tr>
                                        <td class="text-center">{{$cities->firstItem() + $key}}</td>
                                        <td class="text-center">{{$city->name}}</td>
                                        <td class="text-center">{{$city->slug}}</td>
                                        <td class="text-center">{{$city->province->name}}</td>
                                        <td class="text-center">
                                            @if($city->is_active)
                                                <span class="badge badge-pill bg-gradient-success">{{__('web/city.active_options.active_value')}}</span>
                                            @else
                                                <span class="badge badge-pill bg-gradient-danger">{{__('web/city.active_options.deActive_value')}}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{$city->getJalaliCreatedAt()}}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                                                @can('edit city')
                                                    <a href="{{route('admin.cities.edit',['city' => $city->id])}}" class="btn btn-sm btn-warning m-0">{{__('web/city.edit')}}</a>
                                                @endcan
                                                @can('destroy city')
                                                    <a href="{{route('admin.cities.destroy',['city' => $city->id])}}" class="btn btn-sm btn-danger m-0" data-confirm-delete="true">{{__('web/city.destroy')}}</a>
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
