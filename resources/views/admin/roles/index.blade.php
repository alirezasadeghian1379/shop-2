@extends('admin.master')
@section('title', __('web/role.list'))
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' =>  __('web/role.list'),'route' => route('admin.roles.index'),'active' => 1],
                        ]
                    ])
                    @can('create role')
                        <a href="{{route('admin.roles.create')}}" class="btn bg-gradient-danger">{{ __('web/role.create')}}</a>
                    @endcan
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>{{ __('web/role.title')}}</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            @php $headers = array_values( __('web/role.table')); @endphp
                            <x-table :headers="$headers" :items="$roles">
                                @foreach($roles->items as $key => $role)
                                    <tr>
                                        <td class="text-center">{{$roles->firstItem() + $key}}</td>
                                        <td class="text-center">{{$role->name}}</td>
                                        <td class="text-center">{{$role->getPermissionsCount()}}</td>
                                        <td class="text-center">{{$role->getAllUsersCount()}}</td>
                                        <td class="text-center">{{$role->getJalaliCreatedAt()}}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                                                @can('edit role')
                                                    <a href="{{route('admin.roles.edit',['role' => $role->id])}}" class="btn btn-sm btn-warning m-0">{{ __('web/role.edit')}}</a>
                                                @endcan
                                                @can('destroy role')
                                                        <a href="{{route('admin.roles.destroy',['role' => $role->id])}}" class="btn btn-sm btn-danger m-0" data-confirm-delete="true">{{ __('web/role.destroy')}}</a>
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
