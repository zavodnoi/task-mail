@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Настройка доступа к событию ({{$event->short_description}})</div>
                    <div class="panel-body">
                        <p class="alert alert-info">Доступ на редактирование, включает доступ на чтение.</p>
                        <form method="POST" action="{{route('event.access.update', $event->id)}}">
                            {{csrf_field()}}
                            <div class="form-group {{$errors->has('read') ? 'has-error' : ''}}">
                                <label for="read">Доступ на чтение</label>
                                {!! Form::select('read', $users, $errors->has('read') ? old('read') : $read_access, ['multiple'=>'multiple','name'=>'read[]', 'class' => 'form-control']) !!}
                                @if ($errors->has('read'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('read') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{$errors->has('edit') ? 'has-error' : ''}}">
                                <label for="edit">Доступ на редактирование</label>
                                {!! Form::select('edit', $users, $errors->has('read') ? old('read') : $edit_access, ['multiple'=>'multiple','name'=>'edit[]', 'class' => 'form-control']) !!}
                                @if ($errors->has('edit'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('edit') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <a href="{{route('event.show', $event->id)}}" class="btn btn-default">Отмена</a>
                            <button type="submit" class="btn btn-warning">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection