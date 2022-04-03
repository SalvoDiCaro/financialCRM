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
    {!! Form::open(['method' => 'POST', 'route' => ['assignments.store']]) !!}
    @csrf

    <div class="box box-warning">
        <div class="box-header with-border">

            <div class="pull-right">
                <a class="btn btn-warning btn-sm" href="{{ route('assignments.index') }}" title="Back"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title"><strong>Nuova assegnazione</strong></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                <strong>Lead non assegnati:</strong>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    {!! Form::select('lead_id', $leads, null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                <strong>Agente:</strong>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    {!! Form::select('user_id', $agents, null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <input type="hidden" id="is_direct" name="is_direct" value="0">
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
