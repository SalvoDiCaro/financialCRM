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
    {!! Form::model($practice, ['method' => 'PUT', 'route' => ['practices.update', $practice->id]]) !!}
    @csrf

    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="pull-right">
                <a class="btn btn-warning btn-sm" href="{{ URL::previous() }}" title="Back"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title"><strong>Modifica Pratica</strong></h3>
        </div>
        <!-- /.box-header -->
        <div class="container-fluid">
            <div class="row">

                <div class="form-group col-md-12">
                    <label>Importo:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('amount', $instance ? $instance->amount : null, ['placeholder' => 'Importo', 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Numero Pratica:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('practice_number', null, ['placeholder' => 'Numero Pratica', 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Data di stipula:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        {!! Form::date('stipulation_date', null, ['placeholder' => 'Data di stipula', 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Finalità:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {!! Form::select('finality', ['Acquisto 1° casa' => 'Acquisto 1° casa', 'Acquisto 2° casa' => 'Acquisto 2° casa', 'Acquisto + ristrutturazione' => 'Acquisto + ristrutturazione', 'Costruzione/Ristrutturazione' => 'Costruzione/Ristrutturazione', 'Sostituzione + ristrutturazione' => 'Sostituzione + ristrutturazione', 'Sostituzione' => 'Sostituzione', 'Surroga' => 'Surroga'], $instance ? $instance->finality : null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>LTV fin:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('property_cost', $instance ? $instance->property_cost : null, ['placeholder' => 'LTV fin', 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>LTV Banca:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('property_value', $instance ? $instance->property_value : null, ['placeholder' => 'LTV Banca', 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Fascia LTV:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::select('ltv_band', ['0-50' => '0-50', '51-70' => '51-70', '71-80' => '71-80', '81-90' => '81-90', '>91' => '>91'], null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Durata:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {{ Form::select('duration', range(60, 360), $instance ? $instance->duration : null, ['class' => 'form-control', 'required' => 'required']) }}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Rating:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {!! Form::select('rating', ['C2' => 'C2', 'C4' => 'C4', 'C5' => 'C5', 'C7' => 'C7'], $instance ? $instance->rating : null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Incendio:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::select('fire', ['0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8'], null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Incendio importo:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('fire_amount', null, ['placeholder' => 'Incendio importo', 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Incendio completo:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::select('complete_fire', ['0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8'], null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Incendio completo importo:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('complete_fire_amount', null, ['placeholder' => 'Incendio completo importo', 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Ppl:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::select('ppl', ['0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8'], null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Ppl importo:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('ppl_amount', null, ['placeholder' => 'Ppl importo', 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Infortuni:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::select('injuries', ['0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8'], null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Infortuni importo:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('injuries_amount', null, ['placeholder' => 'Infortuni importo', 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Vita:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::select('life', ['0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8'], null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Vita importo:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('life_amount', null, ['placeholder' => 'Vita importo', 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Numero CPI:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {!! Form::select('cpi_number', ['0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8'], null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Premi CPI:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('cpi_awards', null, ['placeholder' => 'Premi CPI', 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Spread:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('spread', null, ['placeholder' => 'Spread', 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Fascia Spread:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {!! Form::select('spread_band', ['1a' => '1a', '2a' => '2a', '3a' => '3a', '4a' => '4a'], null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label>Istruttoria:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {!! Form::select(
    'inquest',
    [
        '500' => '500€',
        '600' => '600€',
        '700' => '700€',
        '800' => '800€',
        '900' => '900€',
        '1000' => '1000€',
        '1100' => '1100€',
        '1200' => '1200€',
        '1300' => '1300€',
        '1400' => '1400€',
        '1500' => '1500€',
        '1600' => '1600€',
        '1700' => '1700€',
        '1800' => '1800€',
        '1900' => '1900€',
        '2000' => '2000€',
        '2100' => '2100€',
        '2200' => '2200€',
        '2300' => '2300€',
        '2400' => '2400€',
        '2500' => '2500€',
        '2600' => '2600€',
        '2700' => '2700€',
        '2800' => '2800€',
        '2900' => '2900€',
        '3000' => '3000€',
    ],
    $instance ? $instance->inquest : null,
    ['class' => 'form-control', 'required' => 'required'],
) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Cartaceo/Digitale:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::select('paper_digital', ['Cartaceo' => 'Cartaceo', 'Digitale' => 'Digitale'], null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="partecipations_number" name="partecipations_number" value="1">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm">Invia</button>
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

@section('scripts')
    <script>

        $(document).ready(function() {
            if ($("select[name=ppl]").val() == 0) {
                $("input[name=ppl_amount]").prop("readonly", true).val(0);
            }

            $("select[name=ppl]").change(function() {
                if ($("select[name=ppl]").val() == 0) {
                    $("input[name=ppl_amount]").prop("readonly", true).val(0);
                } else {
                    $("input[name=ppl_amount]").prop("readonly", false).val("");
                }
            });

            if ($("select[name=fire]").val() == 0) {
                $("input[name=fire_amount]").prop("readonly", true).val(0);
            }

            $("select[name=fire]").change(function() {
                if ($("select[name=fire]").val() == 0) {
                    $("input[name=fire_amount]").prop("readonly", true).val(0);
                } else {
                    $("input[name=fire_amount]").prop("readonly", false).val("");
                }
            });

            if ($("select[name=life]").val() == 0) {
                $("input[name=life_amount]").prop("readonly", true).val(0);
            }

            $("select[name=life]").change(function() {
                if ($("select[name=life]").val() == 0) {
                    $("input[name=life_amount]").prop("readonly", true).val(0);
                } else {
                    $("input[name=life_amount]").prop("readonly", false).val("");
                }
            });

            if ($("select[name=complete_fire]").val() == 0) {
                $("input[name=complete_fire_amount]").prop("readonly", true).val(0);
            }

            $("select[name=complete_fire]").change(function() {
                if ($("select[name=complete_fire]").val() == 0) {
                    $("input[name=complete_fire_amount]").prop("readonly", true).val(0);
                } else {
                    $("input[name=complete_fire_amount]").prop("readonly", false).val("");
                }
            });

            if ($("select[name=injuries]").val() == 0) {
                $("input[name=injuries_amount]").prop("readonly", true).val(0);
            }

            $("select[name=injuries]").change(function() {
                if ($("select[name=injuries]").val() == 0) {
                    $("input[name=injuries_amount]").prop("readonly", true).val(0);
                } else {
                    $("input[name=injuries_amount]").prop("readonly", false).val("");
                }
            });

            if ($("select[name=cpi_number]").val() == 0) {
                $("input[name=cpi_awards]").prop("readonly", true).val(0);
            }

            $("select[name=cpi_number]").change(function() {
                if ($("select[name=cpi_number]").val() == 0) {
                    $("input[name=cpi_awards]").prop("readonly", true).val(0);
                } else {
                    $("input[name=cpi_awards]").prop("readonly", false).val("");
                }
            });
        });
    </script>
@endsection
