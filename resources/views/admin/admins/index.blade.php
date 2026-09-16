@extends('admin.master')

@section('title', __('web/admin.list'))

@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' =>  __('web/admin.list'),'route' => route('admin.admins.index'),'active' => 1],
                        ]
                    ])
                    @can('create admin')
                        <a href="{{route('admin.admins.create')}}" class="btn bg-gradient-danger">{{ __('web/admin.create')}}</a>
                    @endcan
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>{{ __('web/admin.title')}}</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <x-table :headers="array_values( __('web/admin.table'))" :items="$admins">
                                @foreach($admins->items as $key => $admin)
                                    <tr>
                                        <td class="text-center">{{$admins->firstItem() + $key}}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="parent-image-table">
                                                    @if($admin->getAvatarExists())
                                                        <a href="{{$admin->getAvatarUrl()}}" target="_blank" class="w-100 h-100 d-flex">
                                                            <img src="{{$admin->getAvatarUrl()}}" alt="">
                                                        </a>
                                                    @else
                                                        <span>{{ mb_substr($admin->first_name, 0, 1, 'UTF-8') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{$admin->getFullName()}}</td>
                                        <td class="text-center">{{$admin->phone}}</td>
                                        <td class="text-center">{{$admin->email}}</td>
                                        <td class="text-center">{{$admin->role->name}}</td>
                                        <td class="text-center">
                                            @if($admin->active)
                                                <span class="badge badge-pill bg-gradient-success">{{ __('web/admin.table_options.active_value')}}</span>
                                            @else
                                                <span class="badge badge-pill bg-gradient-danger">{{ __('web/admin.table_options.deActive_value')}}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{$admin->getJalaliCreatedAt()}}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                                                @can('edit admin')
                                                    <a href="{{route('admin.admins.edit',['admin' => $admin->id])}}" class="btn btn-sm btn-warning m-0">{{ __('web/admin.edit')}}</a>
                                                @endcan
                                                @can('destroy admin')
                                                    <a href="{{route('admin.admins.destroy',['admin' => $admin->id])}}" class="btn btn-sm btn-danger m-0" data-confirm-delete="true">{{ __('web/admin.destroy')}}</a>
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
