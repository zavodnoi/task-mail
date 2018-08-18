@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Удаление события</div>
                    <div class="panel-body">
                        <form method="POST" action="{{route('event.destroy', $event->id)}}">
                            <input type="hidden" name="_method" value="DELETE">
                            {{csrf_field()}}
                            <div class="form-group {{$errors->has('cause_of_change') ? 'has-error' : ''}}">
                                <label for="cause_of_change">Причина</label>
                                <textarea class="form-control" id="cause_of_change" name="cause_of_change">{{$event->cause_of_change}}</textarea>
                                @if ($errors->has('cause_of_change'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cause_of_change') }}</strong>
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