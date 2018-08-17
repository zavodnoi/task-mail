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
                            <a class="btn btn-default" href="{{route('project.create')}}">Добавить проект</a>
                        </p>
                        @if($projects->isEmpty())
                            <p class="alert alert-info">отстутствуют</p>
                        @else
                            <div class="table-responsive">
                                <table>

                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
