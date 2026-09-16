@extends('admin.master')

@section('title',__('web/user.list'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/user.list'),'route' => route('admin.users.index'),'active' => 1],
                        ]
                    ])
                    @can('create user')
                        <a href="{{route('admin.users.create')}}" class="btn bg-gradient-danger">{{__('web/user.create')}}</a>
                    @endcan
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>{{__('web/user.title')}}</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <x-table :headers="array_values(__('web/user.table'))" :items="$users">
                                @foreach($users->items as $key => $user)
                                    <tr>
                                        <td class="text-center">{{$users->firstItem() + $key}}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="parent-image-table">
                                                    @if($user->getAvatarExists())
                                                        <a href="{{$user->getAvatarUrl()}}" target="_blank" class="w-100 h-100 d-flex">
                                                            <img src="{{$user->getAvatarUrl()}}" alt="">
                                                        </a>
                                                    @else
                                                        <span>{{ mb_substr($user->first_name ?? '-', 0, 1, 'UTF-8') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{$user->getFullName()}}</td>
                                        <td class="text-center">{{$user->phone}}</td>
                                        <td class="text-center">{{$user->email ?? '-'}}</td>
                                        <td class="text-center">
                                            @if($user->active)
                                                <span class="badge badge-pill bg-gradient-success">{{__('web/user.table_options.active_value')}}</span>
                                            @else
                                                <span class="badge badge-pill bg-gradient-danger">{{__('web/user.table_options.deActive_value')}}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{$user->getJalaliCreatedAt()}}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                                                @can('edit user')
                                                    <a href="{{route('admin.users.edit',['user' => $user->id])}}" class="btn btn-sm btn-warning m-0">{{__('web/user.edit')}}</a>
                                                @endcan
                                                @can('destroy user')
                                                        <a href="{{route('admin.users.destroy',['user' => $user->id])}}" class="btn btn-sm btn-danger m-0" data-confirm-delete="true">{{__('web/user.destroy')}}</a>
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
