@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Событие</div>
                    <div class="panel-body">
                        <div class="col-sm-6">
                            <a href="{{route('project.index')}}" class="btn btn-default">
                                <i class="glyphicon glyphicon-menu-left"></i>
                                Назад
                            </a>
                        </div>
                        <div class="col-sm-6">
                            @can('edit', $event)
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        Действия <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @can('access-edit', $event)
                                            <li>
                                                <a href="{{route('event.access.edit', $event->id)}}">
                                                    <i class="glyphicon glyphicon-user"></i>
                                                    Настроить доступ
                                                </a>
                                            </li>
                                        @endcan
                                        @can('finish', $event)
                                            <li>
                                                <a href="{{route('event.finish', $event->id)}}">
                                                    <i class="glyphicon glyphicon-ban-circle"></i>
                                                    Завершить
                                                </a>
                                            </li>
                                        @endcan
                                        <li>
                                            <a href="{{route('event.edit', $event->id)}}">
                                                <i class="glyphicon glyphicon-edit"></i>
                                                Редактировать
                                            </a>
                                        </li>
                                        @can('access-edit', $event)
                                            <li>
                                                <a href="{{route('event.delete-cause', $event->id)}}">
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                    Удалить
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            @endcan
                        </div>
                        <br>
                        <br>

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
