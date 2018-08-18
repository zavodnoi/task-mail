@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Проекты
                    </div>
                    <div class="panel-body">
                        <p>
                            <a class="btn btn-primary" href="{{route('project.create')}}">Добавить проект</a>
                            @if(!$projects->isEmpty())
                                <a class="btn btn-success" href="{{route('event.create')}}">Добавить событие</a>
                            @endif

                        </p>
                        @if($projects->isEmpty())
                            <p class="alert alert-info">отстутствуют</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th colspan="{{$weeks->count()+1}}" style="text-align: center">
                                            @php($prev_month = \Carbon\Carbon::create($year, $month)->subMonth())
                                            <a href="{{route('project.index',['year' => $prev_month->year, 'month' => $prev_month->month])}}" class="btn btn-warning pull-left">
                                                <i class="glyphicon glyphicon-menu-left"></i>
                                                {{$prev_month->englishMonth}}
                                            </a>

                                            <b>{{\Carbon\Carbon::create($year, $month)->englishMonth}}</b>

                                            @php($next_month = \Carbon\Carbon::create($year, $month)->addMonth())
                                            <a href="{{route('project.index',['year' => $next_month->year, 'month' => $next_month->month])}}" class="btn btn-warning pull-right">
                                                {{$next_month->englishMonth}}
                                                <i class="glyphicon glyphicon-menu-right"></i>
                                            </a>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        @foreach($weeks as $week_number => $week)
                                            <td>
                                                <span style="white-space: nowrap">{{$week_number}}</span>
                                                <span style="white-space: nowrap">{{$week->get('start')}}</span><br>
                                                <span style="white-space: nowrap">{{$week->get('end')}}</span>
                                            </td>
                                        @endforeach
                                    </tr>
                                    @foreach($projects as $project)
                                        <tr>
                                            <th>{{$project->name}}</th>
                                            @foreach($weeks as $week)
                                                <td>
                                                    @php
                                                        $events = $week->get('events');
                                                        $events = $events->get($project->id);
                                                        if(empty($events)){
                                                            $events = [];
                                                        }
                                                    @endphp
                                                    @foreach($events as $event)
                                                        <a href="{{route('event.show', $event->id)}}"
                                                           class="btn btn-info btn-sm"
                                                           style="white-space: normal; padding: 0">
                                                            {{$event->short_description}}
                                                        </a>
                                                        <br><br>
                                                    @endforeach
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
