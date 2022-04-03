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

    {!! Form::open(['method' => 'POST', 'route' => ['companies.store']]) !!}
    @csrf

    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="pull-right">
                <a class="btn btn-warning btn-sm" href="{{ URL::previous() }}" title="Back"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title"><strong>Aggiungi una nuova Azienda</strong></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Denominazione:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('name', null, ['placeholder' => 'Denominazione', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Partita iva:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('vat_number', null, ['placeholder' => 'Partitita Iva', 'class' => 'form-control']) !!}
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Tipologia azienda:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {!! Form::select(
    'typology',
    [
        'Impresa individuale' => 'Impresa individuale',
        'SRL' => 'SRL',
        'SRLS' => 'SRLS',
        'SS' => 'SS',
        'SAS' => 'SAS',
        'Impresa agricola' => 'Impresa agricola',
        'SPA' => 'SPA',
        'SAPA' => 'SAPA',
        'SNC' => 'SNC',
        'Cooperativa' => 'Cooperativa',
        'Associazione' => 'Associazione',
        'No profit' => 'No profit',
        'Multinazionale' => 'Multinazionale',
    ],
    null,
    ['class' => 'form-control', 'placeholder' => 'Seleziona tipologia'],
) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Codice fiscale:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('fis_cod', null, ['placeholder' => 'Codice fiscale', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="form-group col-md-6">
                    <label>Telefono:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        {!! Form::text('phone', null, ['placeholder' => 'Telefono', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Email:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        {!! Form::email('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-5">
                    <label>Indirizzo:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('address', null, ['placeholder' => 'Indirizzo', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label>CAP:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('postal_code', null, ['placeholder' => 'Codice avviamento postale', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Città:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('city', null, ['placeholder' => 'Città', 'class' => 'form-control']) !!}
                    </div>
                </div>


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

        .btn {
            margin-bottom: 10px;
        }

    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {



        });
    </script>
@endsection
