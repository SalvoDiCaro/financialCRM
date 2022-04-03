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
    {!! Form::model($commitment, ['method' => 'PUT', 'route' => ['commitments.update', $commitment->id]]) !!}
    @csrf
    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="pull-right">
                <a class="btn btn-warning btn-sm" href="{{ route('commitments.index') }}" title="Back"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title"><strong>Modifica assegnazione</strong></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                <strong>Stato attuale: </strong>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                    {!! Form::select('current_state', [
                        'Creato' => 'Creato',
                        'Da telefonare' => 'Da telefonare',
                        'Telefonato' => 'Telefonato',
                        'Preso appuntamento' => 'Preso appuntamento',
                        'Visitato' => 'Visitato',


                        ], $commitment->current_state, ['class' => 'form-control']) !!}
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
