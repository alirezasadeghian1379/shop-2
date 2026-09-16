@extends('admin.master')

@section('title',isset($question) ? __('web/question.edit'):__('web/question.create'))

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    @include('admin.layouts.breadcrump',[
                        'data' => [
                            ['title' => __('web/dashboard.dashboard'),'route' => route('admin.index'),'active' => 0],
                            ['title' => __('web/question.list'),'route' => route('admin.questions.index'),'active' => 0],
                            ['title' => isset($question) ? __('web/question.edit'):__('web/question.create'),'route' => isset($question) ? route('admin.questions.edit',['question' => $question->id]):route('admin.questions.create'),'active' => 1],
                        ]
                    ])
                </div>
            </div>

            <div class="col-md-12">
                <form role="form" method="POST" action="{{isset($question) ? route('admin.questions.update',['question' => $question->id]):route('admin.questions.store')}}">
                    @csrf
                    @if(isset($question))
                        @method('PUT')
                    @endif

                    <div class="row w-100 m-0 p-0">
                        <div class="col-md-8 order-2 order-md-1 p-2">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-uppercase text-sm">{{isset($question) ? __('web/question.edit'):__('web/question.create')}}</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="question" class="form-control-label">{{__('web/question.form.question')}}</label>
                                                <input class="form-control {{$errors->has('question') ? 'border-danger':''}}" type="text" name="question" id="question" value="{{isset($question) ? $question->question:old('question')}}" autocomplete="off" placeholder="{{__('web/question.form.question')}}">
                                                @error('question') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="answer" class="form-control-label">{{__('web/question.form.answer')}}</label>
                                                <textarea name="answer" class="form-control {{$errors->has('answer') ? 'border-danger':''}}" id="answer" cols="30" rows="5">{{isset($question) ? $question->answer:old('answer')}}</textarea>
                                                @error('answer') <div class="text-danger text-14">{{$message}}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr class="w-100">
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-start align-items-center gap-2">
                                                @if(isset($question))
                                                    @can('update question')
                                                        <button class="btn bg-gradient-success">{{__('web/question.edit')}}</button>
                                                    @endcan
                                                @else
                                                    @can('store question')
                                                        <button class="btn bg-gradient-success">{{__('web/question.store')}}</button>
                                                    @endcan
                                                @endif
                                                @can('index question')
                                                    <a href="{{route('admin.questions.index')}}" class="btn bg-gradient-warning">{{__('web/question.back')}}</a>
                                                @endcan
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 order-1 order-md-2 p-2">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row w-100 p-0 m-0">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-check form-switch p-0 gap-2">
                                                    <input class="form-check-input m-0" type="checkbox" name="active" dir="ltr" id="active" {{isset($question) && $question->active ? 'checked':''}}>
                                                    <label class="form-check-label m-0" for="active">{{__('web/question.form.active')}}</label>
                                                </div>
                                                @error('active') <div class="text-danger text-14">{{$message}}</div> @enderror
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
