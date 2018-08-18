@php
    if(!$errors->isEmpty() && !$event->id){
        $event = session('event');
    }
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Новое событие</div>
                    <div class="panel-body">
                        @if($event->id)
                            <form method="POST" action="{{route('event.update', $event->id)}}">
                            <input type="hidden" name="_method" value="PUT">
                        @else
                            <form method="POST" action="{{route('event.store')}}">
                        @endif
                            {{csrf_field()}}
                            <div class="form-group {{$errors->has('started_at') ? 'has-error' : ''}}">
                                <label for="started_at">Дата начала</label>
                                <input type="date" class="form-control" id="started_at" name="started_at"
                                       value="{{$event->started_at ? $event->started_at->format('Y-m-d') : null}}">
                                @if ($errors->has('started_at'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('started_at') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('project_id') ? 'has-error' : ''}}">
                                <label for="project_id">Проект</label>
                                {!! Form::select('project_id', $projects->all(), $event->project_id, ['class' => 'form-control']) !!}
                                @if ($errors->has('project_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('project_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('dictionary_type_id') ? 'has-error' : ''}}">
                                <label for="dictionary_type_id">Тип события</label>
                                {!! Form::select('dictionary_type_id', $types->all(), $event->dictionary_type_id, ['class' => 'form-control']) !!}
                                @if ($errors->has('dictionary_type_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dictionary_type_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('short_description') ? 'has-error' : ''}}">
                                <label for="short_description">Краткое описание</label>
                                <input type="text" class="form-control" id="short_description" name="short_description"
                                       value="{{$event->short_description}}">
                                @if ($errors->has('short_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('short_description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('full_description') ? 'has-error' : ''}}">
                                <label for="full_description">Подробное описание</label>
                                <textarea class="form-control" id="full_description" name="full_description">{{$event->full_description}}</textarea>
                                @if ($errors->has('full_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('full_description') }}</strong>
                                    </span>
                                @endif
                                @if($errors->has('full_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('full_description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            @if($event->id)
                                <div class="form-group {{$errors->has('cause_of_change') ? 'has-error' : ''}}">
                                    <label for="cause_of_change">Причина переноса</label>
                                    <textarea class="form-control" id="cause_of_change" name="cause_of_change">{{$event->cause_of_change}}</textarea>
                                    @if ($errors->has('cause_of_change'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('cause_of_change') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            @endif

                            <a href="{{route('project.index')}}" class="btn btn-default">Отмена</a>
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
    session_unset('event');
@endphp