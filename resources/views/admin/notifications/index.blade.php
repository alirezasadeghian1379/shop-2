@extends('admin.master')
@section('title',__('web/notification.list'))
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/notification.list'),'route' => route('admin.notifications.index'),'active' => 1],
                        ]
                    ])
                    @can('create notification')
                        <a href="{{route('admin.notifications.create')}}" class="btn bg-gradient-danger">{{__('web/notification.create')}}</a>
                    @endcan
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="w-100 d-flex justify-content-between align-items-center flex-wrap">
                            <h6>{{__('web/notification.title')}}</h6>
                            @can('destroyAll notification')
                                <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap">
                                    <button class="btn btn-sm btn-info" id="checkAllDestroy">{{__('web/notification.allSelect')}}</button>
                                    <button class="btn btn-sm btn-danger" id="allDestroy">{{__('web/notification.destroyAll')}}</button>
                                </div>
                            @endcan
                        </div>
                        <hr class="w-100">
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            @php $headers = array_values(__('web/notification.table')); @endphp
                            <x-table :headers="$headers" :items="$notifications">
                                @foreach($notifications->items as $key => $notification)
                                    <tr>
                                        <td class="text-center">
                                            @can('destroyAll notification')
                                                <div class="form-check">
                                                    <input class="form-check-input item-checkbox" type="checkbox" value="{{$notification->id}}">
                                                </div>
                                            @endcan
                                        </td>
                                        <td class="text-center">{{$notifications->firstItem() + $key}}</td>
                                        <td class="text-center">{{$notification->title}}</td>
                                        <td class="text-center">
                                            <span class="badge badge-pill bg-gradient-{{$notification->getTypeColor()}}">{{$notification->getTypePersian()}}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($notification->is_global)
                                                <span class="badge badge-pill bg-gradient-danger">{{__('web/notification.global_options.deActive')}}</span>
                                            @else
                                                <span class="badge badge-pill bg-gradient-success">{{__('web/notification.global_options.active')}}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{$notification->getJalaliCreatedAt()}}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                                                @can('edit notification')
                                                    <a href="{{route('admin.notifications.edit',['notification' => $notification->id])}}" class="btn btn-sm btn-warning m-0">{{__('web/notification.edit')}}</a>
                                                @endcan
                                                @can('destroy notification')
                                                    <a href="{{route('admin.notifications.destroy',['notification' => $notification->id])}}" class="btn btn-sm btn-danger m-0" data-confirm-delete="true">{{__('web/notification.destroy')}}</a>
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

@section('script')
    <script>
        $(document).ready(function () {

            let allChecked = false;

            $('#checkAllDestroy').on('click', function () {
                allChecked = !allChecked;
                $('.item-checkbox').prop('checked', allChecked);
            });
            $('#allDestroy').on('click', function () {
                let ids = []
                $('.item-checkbox:checked').each(function () {
                    ids.push($(this).val())
                })

                if (ids.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'هیچ آیتمی انتخاب نشده',
                        confirmButtonText: 'باشه'
                    })
                    return
                }

                Swal.fire({
                    title: 'حذف',
                    text: "آیا از انجام این عملیات اطمینان دارید؟",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'حذف',
                    cancelButtonText: 'بیخیال'
                }).then((result) => {
                    if (!result.isConfirmed) return
                    let btn = $('#allDestroy')
                    btn.prop('disabled', true)
                    $.ajax({
                        url: "{{route('admin.notifications.destroyAll')}}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: ids
                        },
                        success: function () {
                            location.reload()
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'خطا',
                                text: 'مشکلی در حذف رخ داد',
                            })
                        },
                        complete: function () {
                            btn.prop('disabled', false)
                        }
                    })
                })
            })
        })
    </script>
@endsection
