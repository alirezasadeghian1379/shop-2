@extends('admin.master')
@section('title',__('web/question.list'))
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/question.list'),'route' => route('admin.questions.index'),'active' => 1],
                        ]
                    ])
                    @can('create question')
                        <a href="{{route('admin.questions.create')}}" class="btn bg-gradient-danger">{{__('web/question.create')}}</a>
                    @endcan
                </div>
            </div>
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>{{__('web/question.title')}}</h6>
                        <hr class="w-100">
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            @php $headers = array_values(__('web/question.table')); @endphp
                            <x-table :headers="$headers" :items="$questions">
                                @foreach($questions->items as $key => $question)
                                    <tr>
                                        <td class="text-center">{{$questions->firstItem() + $key}}</td>
                                        <td class="text-center">{{$question->question}}</td>
                                        <td class="text-center">
                                            @if($question->active)
                                                <span class="badge badge-pill bg-gradient-success">{{__('web/question.table_options.active_value')}}</span>
                                            @else
                                                <span class="badge badge-pill bg-gradient-danger">{{__('web/question.table_options.deActive_value')}}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{$question->getJalaliCreatedAt()}}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                                                @can('edit question')
                                                    <a href="{{route('admin.questions.edit',['question' => $question->id])}}" class="btn btn-sm btn-warning m-0">{{__('web/question.edit')}}</a>
                                                @endcan
                                                @can('destroy question')
                                                        <a href="{{route('admin.questions.destroy',['question' => $question->id])}}" class="btn btn-sm btn-danger m-0" data-confirm-delete="true">{{__('web/question.destroy')}}</a>
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
