@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Событие</div>
                    <div class="panel-body">
                        <p>
                            <a href="{{route('project.index')}}" class="btn btn-default">Назад</a>
                            @if(!$event->finished_at)
                            <a href="{{route('event.finish', $event->id)}}" class="btn btn-primary">Завершить</a>
                            @endif
                            <a href="{{route('event.edit', $event->id)}}" class="btn btn-warning">Редактировать</a>
                            <a href="{{route('event.delete-cause', $event->id)}}" class="btn btn-danger">Удалить</a>
                        </p>
                        <table class="table table-striped">
                            <tr>
                                <th style="width: 30%;">Дата начала</th>
                                <td>{{$event->started_at->format('d.m.Y')}}</td>
                            </tr>
                            <tr>
                                <th>Проект</th>
                                <td>{{$event->project->name}}</td>
                            </tr>
                            <tr>
                                <th>Тип события</th>
                                <td>{{$event->type->name}}</td>
                            </tr>
                            <tr>
                                <th>Краткое описание</th>
                                <td>{{$event->short_description}}</td>
                            </tr>
                            <tr>
                                <th>Подробное описание</th>
                                <td>{{$event->full_description}}</td>
                            </tr>
                            <tr>
                                <th>Завершено</th>
                                <td>{{$event->finished_at ? 'Да' : 'Нет'}}</td>
                            </tr>
                            <tr>
                                <th>Причина удаления/переноса</th>
                                <td>{{$event->cause_of_change}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
