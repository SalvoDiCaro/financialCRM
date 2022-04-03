@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
        </div>
    </div>

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

    {!! Form::open(['method' => 'POST', 'route' => ['compleads.store']]) !!}
    @csrf

    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="pull-right">
                <a class="btn btn-warning btn-sm" href="{{ route('leads.index') }}" title="Back"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title"><strong>Completa anagrafica lead</strong></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <!-- text input -->
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Codice fiscale:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('fis_cod', null, ['placeholder' => 'Codice fiscale', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label>Data di nascita:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        {!! Form::date('date_of_birth', null, ['placeholder' => 'Data di nascita', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <label>Luogo di nascita:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('birth_place', null, ['placeholder' => 'Luogo di nascita', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Lavoro:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::select('job', ['Pubblico' => 'Pubblico', 'Privato' => 'Privato', 'Autonomo' => 'Autonomo'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Tipo di contratto:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::select('contract_type', ['Indeterminato' => 'Indeterminato', 'Determinato' => 'Determinato', 'Atipico' => 'Atipico'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label>CAP:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('postal_code', null, ['placeholder' => 'Codice avviamento postale', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Città residenza:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('city_of_residence', null, ['placeholder' => 'Città residenza', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group col-md-5">
                    <label>Indirizzo residenza:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('address', null, ['placeholder' => 'Indirizzo di residenza', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <input type="hidden" id="lead_id" name="lead_id" value="{{ request()->get('id') }}">
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
