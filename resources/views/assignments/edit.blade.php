@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::model($assignment, ['method' => 'PUT', 'route' => ['assignments.update', $assignment->id]]) !!}
    @csrf
    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="pull-right">
                <a class="btn btn-warning btn-sm" href="{{ route('assignments.index') }}" title="Back"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title"><strong>Modifica assegnazione</strong></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                <strong>Lead: </strong>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    <input disabled type="text" name="lead_name" class="form-control" value="{{ $lead->name }} {{ $lead->surname }}">
                </div>

            </div>
            <div class="form-group">
                <strong>Telefono: </strong>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    <input disabled type="text" name="name" class="form-control" value="{{ $lead->phone }}">
                </div>
            </div>
            <div class="form-group">
                <strong>Email: </strong>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                    <input disabled type="text" name="name" class="form-control" value="{{ $lead->email }}">
                </div>
            </div>
            <div class="form-group">
                <strong>Agente:</strong>
                {!! Form::select('user_id', $users, null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-sm">Invia</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
@section('style')
    <style>
        img {
            display: block;
            max-width: 100%;
            pointer-events: none;
            cursor: default;
        }

    </style>
@endsection
