@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Настройка доступа к событию ({{$event->short_description}})</div>
                    <div class="panel-body">
                        <form method="POST" action="{{route('event.destroy', $event->id)}}">
                            {{csrf_field()}}
                            <div class="form-group {{$errors->has('read') ? 'has-error' : ''}}">
                                <label for="read">Доступ на чтение</label>
                                {!! Form::select('read', $users, $read_access, ['multiple'=>'multiple','name'=>'read[]', 'class' => 'form-control']) !!}
                                @if ($errors->has('read'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('read') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('edit') ? 'has-error' : ''}}">
                                <label for="edit">Доступ на чтение</label>
                                {!! Form::select('edit', $users, $read_access, ['multiple'=>'multiple','name'=>'edit[]', 'class' => 'form-control']) !!}
                                @if ($errors->has('edit'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('edit') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <a href="{{route('event.show', $event->id)}}" class="btn btn-default">Отмена</a>
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection