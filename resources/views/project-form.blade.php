@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Новый проект</div>
                <div class="panel-body">
                    <form method="POST" action="{{route('project.store')}}">
                        {{csrf_field()}}
                        <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                            <label for="name">Наименование</label>
                            <input type="text" class="form-control" id="name" name="name">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                            @if($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <a href="{{route('project.index')}}" class="btn btn-danger">Отмена</a>
                        <button type="submit" class="btn btn-default">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
