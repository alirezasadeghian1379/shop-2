@extends('admin.master')
@section('title',__('web/province.list'))
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/province.list'),'route' => route('admin.provinces.index'),'active' => 1],
                        ]
                    ])
                    @can('create province')
                        <a href="{{route('admin.provinces.create')}}" class="btn bg-gradient-danger">{{__('web/province.create')}}</a>
                    @endcan
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>{{__('web/province.title')}}</h6>
                        <hr class="w-100">
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            @php $headers = array_values(__('web/province.table')); @endphp
                            <x-table :headers="$headers" :items="$provinces">
                                @foreach($provinces->items as $key => $province)
                                    <tr>
                                        <td class="text-center">{{$provinces->firstItem() + $key}}</td>
                                        <td class="text-center">{{$province->name}}</td>
                                        <td class="text-center">{{$province->slug}}</td>
                                        <td class="text-center">{{$province->cities->count()}}</td>
                                        <td class="text-center">
                                            @if($province->is_active)
                                                <span class="badge badge-pill bg-gradient-success">{{__('web/province.active_options.active_value')}}</span>
                                            @else
                                                <span class="badge badge-pill bg-gradient-danger">{{__('web/province.active_options.deActive_value')}}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{$province->getJalaliCreatedAt()}}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                                                @can('edit province')
                                                    <a href="{{route('admin.provinces.edit',['province' => $province->id])}}" class="btn btn-sm btn-warning m-0">{{__('web/province.edit')}}</a>
                                                @endcan
                                                @can('destroy province')
                                                        <a href="{{route('admin.provinces.destroy',['province' => $province->id])}}" class="btn btn-sm btn-danger m-0" data-confirm-delete="true">{{__('web/province.destroy')}}</a>
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
