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
    {!! Form::model($instance, ['method' => 'PUT', 'route' => ['instances.update', $instance->id]]) !!}
    @csrf
    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="pull-right">
                <a class="btn btn-warning btn-sm" href="{{ url()->previous() }}" title="Back"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title"><strong>Modifica richiesta</strong></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <strong>Partecipanti:</strong>
            @foreach ($partecipations as $partecipation)
                @if ($partecipation->typology == 'Richiedente')
                    <a href="{{ route('leads.show', $partecipation->lead_id) }}"
                        class="badge btn-primary">{{ $partecipation->name }}
                        {{ $partecipation->surname }}</a>
                @else
                    <a href="{{ route('leads.show', $partecipation->lead_id) }}"
                        class="badge btn-secondary">{{ $partecipation->name }}
                        {{ $partecipation->surname }}</a>
                @endif
            @endforeach
            <div class="row">
                <div class="form-group col-md-4">
                    <strong>Stato corrente:</strong>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::select('current_state', [ $instance->current_state  => 'Cambia stato', 'In attesa' => 'In attesa', 'Deliberato' => 'Deliberato', 'Respinto' => 'Respinto'],null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <strong>Agente:</strong>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::select('user_id', $agents, null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <strong>Filiale:</strong>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-industry"></i></span>
                        {!! Form::text('branch', null, ['placeholder' => 'Filiale', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <label>Fondo CONSAP:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {!! Form::select('consap', [
                            'Sì, prioritario' => 'Sì, prioritario',
                            'Sì, prioritario > 80%' => 'Sì, prioritario > 80%',
                            'Sì, non prioritario' => 'Sì, non prioritario',
                            'No' => 'No'
                            ], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Prodotto:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {!! Form::select('product_id', $products, null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>Finalità:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {!! Form::select('finality', ['Acquisto 1° casa' => 'Acquisto 1° casa', 'Acquisto 2° casa' => 'Acquisto 2° casa', 'Acquisto + ristrutturazione' => 'Acquisto + ristrutturazione', 'Costruzione/Ristrutturazione' => 'Costruzione/Ristrutturazione', 'Sostituzione + ristrutturazione' => 'Sostituzione + ristrutturazione', 'Sostituzione' => 'Sostituzione', 'Surroga' => 'Surroga'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <label>Tipologia:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {!! Form::select('product_type', [
                            'RFDV - Rata fissa durata variabile' => 'RFDV - Rata fissa durata variabile',
                            'Tasso misto varia il fisso 15 con preamm.' => 'Tasso misto varia il fisso 15 con preamm.',
                            'Tasso misto varia il fisso 9 con preamm.' => 'Tasso misto varia il fisso 9 con preamm.',
                            'TF - Tasso fisso special' => 'TF - Tasso fisso special',
                            'TF - Tasso fisso' => 'TF - Tasso fisso',
                            'TF - Tasso fisso con preamm.' => 'TF - Tasso fisso con preamm.',
                            'TFRC - Tasso fisso rata crescente con preamm.' => 'TFRC - Tasso fisso rata crescente con preamm.',
                            'TV - Tasso variabile' => 'TV - Tasso variabile',
                            'TV - Tasso variabile cap' => 'TV - Tasso variabile cap',
                            'TV - Tasso variabile promo' => 'TV - Tasso variabile promo',
                            'TVMSW - Tasso variabile multiswitch con preamm.' => 'TVMSW - Tasso variabile multiswitch con preamm.',
                            'TVMSW - Tasso variabile multiswitch' => 'TVMSW - Tasso variabile multiswitch',
                            ], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Durata:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {{ Form::select('duration', range(60, 360), null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Importo richiesto:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('amount', null, ['placeholder' => 'Importo', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Rating:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {!! Form::select('rating', ['c2' => 'c2', 'c4' => 'c4', 'c5' => 'c5', 'c7' => 'c7'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Costo immobile:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('property_cost', null, ['placeholder' => 'Costo immobile', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Valore immobile:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('property_value', null, ['placeholder' => 'Valore immobile', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Spread:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('spread', null, ['placeholder' => 'Spread', 'class' => 'form-control']) !!}
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
    null,
    ['class' => 'form-control'],
) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>1 Erogazione:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('first_erogation', null, ['placeholder' => '1 Erogazione', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <label class="badge bg-blue">Immobile oggetto d{{ "'" }}acquisto:</label>
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Indirizzo:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('property_address', null, ['placeholder' => 'Indirizzo', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Città:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('property_city', null, ['placeholder' => 'Città', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>CAP:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('property_postal_code', null, ['placeholder' => 'CAP', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <label class="badge bg-blue">Immobile estensione ipotecaria:</label>
            <div class="row">
                <div class="form-group col-md-4">
                    <label>indirizzo:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('property_extension_address', null, ['placeholder' => 'indirizzo', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Città:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('property_extension_city', null, ['placeholder' => 'Città', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>CAP:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('property_extension_postal_code', null, ['placeholder' => 'CAP', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Composizione nucleo familiare NR:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('family_members', null, ['placeholder' => 'Composizione nucleo familiare NR', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Situazione abitativa:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('housing_situation', null, ['placeholder' => 'Situazione abitativa', 'class' => 'form-control']) !!}
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

    </style>
@endsection
