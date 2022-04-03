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
    {!! Form::model($lead, ['method' => 'POST', 'route' => ['instances.store']]) !!}
    @csrf

    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="pull-right">
                <a class="btn btn-warning btn-sm" href="{{ route('instances.index') }}" title="Back"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title"><strong>Nuova richiesta</strong></h3>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Lead:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <select required id="lead" name="lead" class="form-control" aria-label="Lead"
                            onchange="doAction(this.value);">
                            <option disabled @if ($lead == null) selected="selected" @endif value> -- Seleziona un lead -- </option>
                            @foreach ($leads as $value)
                                <option value="{{ $value->id }}" @if ($lead != null && $lead->id == $value->id) selected="selected" @endif>
                                    {{ $value->name }} {{ $value->surname }}
                                    - Agente: {{ $value->agent_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>Filiale:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-users"></i></span>
                        {!! Form::text('branch', null, ['placeholder' => 'Filiale', 'class' => 'form-control required']) !!}
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
                        {!! Form::select('product', $products, null, ['class' => 'form-control']) !!}
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
                        {!! Form::select(
    'product_type',
    [
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
    ],
    null,
    ['class' => 'form-control'],
) !!}
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
                        {!! Form::text('amount', null, ['placeholder' => 'Importo', 'class' => 'form-control', 'data-type' => 'currency']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Rating:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {!! Form::select('rating', ['C2' => 'C2', 'C4' => 'C4', 'C5' => 'C5', 'C7' => 'C7'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Costo immobile:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('property_cost', null, ['placeholder' => 'Costo immobile', 'class' => 'form-control', 'data-type' => 'currency']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Valore immobile:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('property_value', null, ['placeholder' => 'Valore immobile', 'class' => 'form-control', 'data-type' => 'currency']) !!}
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
                        {!! Form::text('first_erogation', null, ['placeholder' => '1 Erogazione', 'class' => 'form-control', 'data-type' => 'currency']) !!}
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
            <label class="badge bg-blue">Dati Venditore:</label>
            <div class="row">
                <div class="form-group col-md-3">
                    <label>Nome:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('seller_name', null, ['placeholder' => 'Nome', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label>Cognome:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('seller_surname', null, ['placeholder' => 'Cognome', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label>Telefono:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('seller_phone', null, ['placeholder' => 'Telefono', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Email:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('seller_email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                <a class="btn btn-success btn-sm" id="show_extension">Aggiungi immobile estensione ipotecaria</a>
                <a class="btn btn-danger btn-sm" id="hide_extension">Nascondi immobile estensione ipotecaria</a>
            </div>
            <label class="badge bg-blue extension">Immobile estensione ipotecaria:</label>
            <div class="row extension">
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
                        {!! Form::select('family_members', ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9'], null, ['placeholder' => 'Composizione nucleo familiare NR', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Situazione abitativa:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::select('housing_situation', ['Proprietà' => 'Proprietà', 'In affitto' => 'In affitto', 'Presso terzi' => 'Presso terzi', "In comodato d'uso gratuito" => "In comodato d'uso gratuito", 'Presso genitori' => 'Presso genitori'], null, ['placeholder' => 'Situazione abitativa', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div id="form1">
                {{-- <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <a class="btn btn-success btn-sm" id="show_informations1">Inserisci informazioni aggiuntive</a>
                    <a class="btn btn-danger btn-sm" id="hide_informations1">Nascondi informazioni aggiuntive</a>
                </div> --}}

                <div id="informations1">
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
                        <div class="form-group col-md-2">
                            <label>CAP:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::text('postal_code', null, ['placeholder' => 'Codice avviamento postale', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Città residenza:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::text('city_of_residence', null, ['placeholder' => 'Città residenza', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Indirizzo residenza:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::text('address', null, ['placeholder' => 'Indirizzo di residenza', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Stato civile:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::select('marital_status', ['Celibe/Nubile' => 'Celibe/Nubile', 'Coniugato in separazione dei beni' => 'Coniugato in separazione dei beni', 'Coniugato in comunione dei beni' => 'Coniugato in comunione dei beni', 'Separato' => 'Separato'], null, ['class' => 'form-control', 'placeholder' => 'Inserisci stato civile']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <a class="btn btn-success btn-sm" id="show_work">Inserisci lavoro</a>
                    <a class="btn btn-danger btn-sm" id="hide_work">Nascondi lavoro</a>
                </div> --}}
                <div id="work">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Lavoro:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::select('job', ['Pubblico' => 'Pubblico', 'Privato' => 'Privato', 'Autonomo' => 'Autonomo'], null, ['class' => 'form-control', 'placeholder' => 'Inserisci lavoro']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tipo di contratto:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::select('contract_type', ['Indeterminato' => 'Indeterminato', 'Determinato' => 'Determinato', 'Atipico' => 'Atipico'], null, ['class' => 'form-control', 'placeholder' => 'Inserisci tipologia contratto']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Settore:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::select(
    'sector',
    [
        'Edilizia' => 'Edilizia',
        'Agricoltura' => 'Agricoltura',
        'Industria' => 'Industria',
        'Commerciale' => 'Commerciale',
        'Insegnamento' => 'Insegnamento',
        'Artigianato' => 'Artigianato',
        'Informatica' => 'Informatica',
        'Meccanica' => 'Meccanica',
        'Elettronica' => 'Elettronica',
    ],
    null,
    ['class' => 'form-control', 'placeholder' => 'Inserisci settore'],
) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Azienda:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::select('company_id', $companies, null, ['placeholder' => 'Scegli azienda già in database', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Lavora dal:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::date('work_since', null, ['placeholder' => 'Lavora dal', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Reddito annuo:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::text('annual_income', null, ['placeholder' => 'Reddito annuo', 'class' => 'form-control', 'data-type' => 'currency']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                        <a class="btn btn-success btn-sm show_new_company">Inserisci nuova azienda</a>
                    </div>

                    <div id="new_company">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Denominazione:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    {!! Form::text('company_name', null, ['placeholder' => 'Denominazione', 'class' => 'form-control']) !!}
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
    'company_typology',
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
                                    {!! Form::text('company_fis_cod', null, ['placeholder' => 'Codice fiscale', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label>Telefono:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    {!! Form::text('company_phone', null, ['placeholder' => 'Telefono', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    {!! Form::email('company_email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-5">
                                <label>Indirizzo:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    {!! Form::text('company_address', null, ['placeholder' => 'Indirizzo', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label>CAP:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    {!! Form::text('company_postal_code', null, ['placeholder' => 'Codice avviamento postale', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Città:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    {!! Form::text('company_city', null, ['placeholder' => 'Città', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Note lavoro:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                            {!! Form::textarea('work_notes', null, ['placeholder' => 'Note', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                    <a class="btn btn-success btn-sm" id="add_debts1">Inserisci situazione debitoria</a>
                    <a class="btn btn-danger btn-sm" id="remove_debts1">Elimina situazione debitoria</a>
                </div>
                <div id="debts1">
                    <div class="row debt1">
                        <div class="form-group col-md-2">
                            <label>Rata:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::text('flat[]', null, ['placeholder' => 'Rata', 'class' => 'form-control', 'data-type' => 'currency']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Società:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::text('society[]', null, ['placeholder' => 'Società', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Scadenza:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::date('expiration[]', null, ['placeholder' => 'Scadenza', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Debito residuo:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::text('residual_debt[]', null, ['placeholder' => 'Debito residuo', 'class' => 'form-control', 'data-type' => 'currency']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Estinzione anticipata:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::select('early_termination[]', ['SI' => 'SI', 'NO' => 'NO'], null, ['class' => 'form-control', 'placeholder' => 'si/no']) !!}
                            </div>
                        </div>
                    </div>
                    @foreach ($debts as $key => $debt)
                        <div class="row olddebt">
                            <div class="form-group col-md-2">
                                <label>Rata:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    {!! Form::text('flat[]', $debt->flat, ['placeholder' => 'Rata', 'class' => 'form-control', 'data-type' => 'currency']) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Società:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    {!! Form::text('society[]', $debt->society, ['placeholder' => 'Società', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Scadenza:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    {!! Form::date('expiration[]', $debt->expiration, ['placeholder' => 'Scadenza', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Debito residuo:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    {!! Form::text('residual_debt[]', $debt->residual_debt, ['placeholder' => 'Debito residuo', 'class' => 'form-control', 'data-type' => 'currency']) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Estinzione anticipata:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    {!! Form::select('early_termination[]', ['SI' => 'SI', 'NO' => 'NO'], $debt->early_termination, ['class' => 'form-control', 'placeholder' => 'Inserisci se estinzione anticipata']) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-group" id="loan_notes1">
                    <label>Note finanziamenti:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {!! Form::textarea('loan_notes', null, ['placeholder' => 'Note', 'class' => 'form-control']) !!}
                    </div>
                </div>

            </div>

            <input type="hidden" id="partecipations_number" name="partecipations_number" value="1">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Invia</button>
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

            .debt1 {
                display: none;
            }

            /*
                    #work {
                        display: none;
                    }

                    #informations1 {
                       display: none;
                    }
                    */

            #loan_notes1 {
                display: none;
            }

            #hide_informations1 {
                display: none;
            }

            #hide_work {
                display: none;
            }

            .extension {
                display: none;
            }

            #hide_extension {
                display: none;
            }

            #new_company {
                display: none;
            }

        </style>
    @endsection

    @section('scripts')
        <script>
            $(document).ready(function() {

                $('.required').filter(function() {
                        return !this.value;
                    })
                    .css("border-color", "red");

                $(".required").keyup(function() {
                    if ($(this).val() != '') {
                        $(this).css("border-color", "#ccc");
                    } else {
                        $(this).css("border-color", "red");
                    }
                    $(".required").filter(function() {
                            return !this.value;
                        })
                        .css("border-color", "red");
                });


                var partecipations_number = 1;

                $('#show_informations1').click(function() {
                    $('#informations1').show();
                    $('#hide_informations1').show();
                    $('#show_informations1').hide();
                });

                $('#hide_informations1').click(function() {
                    $('#informations1').hide();
                    $('#hide_informations1').hide();
                    $('#show_informations1').show();
                });

                $('#show_work').click(function() {
                    $('#work').show();
                    $('#hide_work').show();
                    $('#show_work').hide();
                });

                $('#show_extension').click(function() {
                    $('.extension').show();
                    $('#hide_extension').show();
                    $('#show_extension').hide();
                });

                $('#hide_extension').click(function() {
                    $('.extension').hide();
                    $('#hide_extension').hide();
                    $('#show_extension').show();
                });


                $('#hide_work').click(function() {
                    $('#work').hide();
                    $('#hide_work').hide();
                    $('#show_work').show();
                });

                $('#add_debts1').click(function() {
                    $('#loan_notes1').show();

                    var debt = $('.debt1').first().clone().appendTo("#debts1");
                    debt.find("input[type=text]")
                        .val('');
                    debt.show();

                });

                $('.show_new_company').click(function() {
                    $('#new_company').show();
                });

                $('#remove_debts1').click(function() {
                    if ($('.debt1').length == 2) {
                        $('#loan_notes1').hide();
                    }
                    if ($('.debt1').length > 1) {
                        $('.debt1').last().remove();
                    }

                });

                $("#add_partecipation").click(function() {
                    partecipations_number++;
                    $("#partecipations_number").val(partecipations_number);
                    var select = $('#form1').clone().attr('id', 'form' + partecipations_number)
                        .insertAfter("#form" + (partecipations_number - 1));

                    select.find("input[type=text],input[type=email], textarea")
                        .val('');

                    select.find("#informations1").attr('id', 'informations' + partecipations_number).hide();
                    select.find("#work").attr('id', 'work' + partecipations_number).hide();
                    select.find("#show_informations1").attr('id', 'show_informations' + partecipations_number);
                    select.find("#hide_informations1").attr('id', 'hide_informations' + partecipations_number);
                    select.find("#show_work").attr('id', 'show_work' + partecipations_number);
                    select.find("#hide_work").attr('id', 'hide_work' + partecipations_number);
                    select.find("#debts1").attr('id', 'debts' + partecipations_number);
                    select.find(".debt1").remove();
                    select.find(".olddebt").remove();
                    select.find("#add_debts1").attr('id', 'add_debts' + partecipations_number);
                    select.find("#remove_debts1").attr('id', 'remove_debts' + partecipations_number);
                    select.find("#loan_notes1").attr('id', 'loan_notes' + partecipations_number).hide();

                    for (let i = 2; i <= partecipations_number; i++) {

                        $('#add_debts' + i).click(function() {

                            $('#loan_notes' + i).show();
                            var debt = $('.debt1').first().clone().attr('class', 'debt' + i).appendTo(
                                "#debts" + i);
                            debt.find('input[name="flat[1][]"]').attr('name', 'flat[' + i + '][]');
                            debt.find('input[name="society[1][]"]').attr('name', 'society[' + i +
                                '][]');
                            debt.find('input[name="expiration[1][]"]').attr('name', 'expiration[' + i +
                                '][]');
                            debt.find('input[name="residual_debt[1][]"]').attr('name',
                                'residual_debt[' + i + '][]');
                            debt.find('select[name="early_termination[1][]"]').attr('name',
                                'early_termination[' + i + '][]');

                            debt.addClass('row');
                            debt.find("input[type=text]").val('');
                            debt.show();

                        });

                        $('#remove_debts' + i).click(function() {

                            if ($('.debt' + i).length == 1) {
                                $('#loan_notes' + i).hide();
                            }
                            if ($('.debt' + i).length > 0) {
                                $('.debt' + i).last().remove();
                            }

                        });

                        $('#show_informations' + i).click(function() {
                            $('#informations' + i).show();
                        });

                        $('#hide_informations' + i).click(function() {
                            $('#informations' + i).hide();
                        });

                        $('#show_work' + i).click(function() {
                            $('#work' + i).show();
                        });

                        $('#hide_work' + i).click(function() {
                            $('#work' + i).hide();
                        });
                    }

                    $("#form" + partecipations_number).prepend("<p>Partecipante n. " + partecipations_number +
                        "</p>");


                });

                $("#remove_partecipation").click(function() {
                    if (partecipations_number > 1) {
                        var select = $('#form' + partecipations_number).remove();
                        partecipations_number--;
                        $("#partecipations_number").val(partecipations_number);
                    }

                });

                $('#random').on('change', (event) => {
                    if (event.target.value == 0) {
                        $('#agents').show();
                    } else {
                        $('#agents').hide();
                    }
                });
            });

            function doAction(val) {
                document.location.href = "{{ route('instances.create') }}/" + val;
            }

            if (!(
                    $("select[name=finality]").val() == 'Acquisto + ristrutturazione' ||
                    $("select[name=finality]").val() == 'Costruzione/Ristrutturazione' ||
                    $("select[name=finality]").val() == 'Sostituzione + ristrutturazione')) {
                $("input[name=first_erogation]").attr('disabled', 'disabled').val(0);
            }

            $("select[name=finality]").change(function() {
                if (!(
                        $("select[name=finality]").val() == 'Acquisto + ristrutturazione' ||
                        $("select[name=finality]").val() == 'Costruzione/Ristrutturazione' ||
                        $("select[name=finality]").val() == 'Sostituzione + ristrutturazione')) {
                    $("input[name=first_erogation]").attr('disabled', 'disabled').val(0);
                } else {
                    $("input[name=first_erogation]").removeAttr('disabled', 'disabled').val("");
                }
            });

            if ($("select[name=job]").val() == 'Autonomo') {
                $("select[name=contract_type]").attr('disabled', 'disabled');
            } else {
                $("select[name=contract_type]").removeAttr('disabled', 'disabled');
            }

            $("select[name=job]").change(function() {
                if ($("select[name=job]").val() == 'Autonomo') {
                    $("select[name=contract_type]").attr('disabled', 'disabled');
                } else {
                    $("select[name=contract_type]").removeAttr('disabled', 'disabled');
                }
            });

            if ($("select[name=company_id]").val()) {
                $('.show_new_company').hide();
                $('#new_company').hide();

            } else {
                $('.show_new_company').show();
            }

            $("select[name=company_id]").change(function() {
                if ($("select[name=company_id]").val()) {
                    $('.show_new_company').hide();
                    $('#new_company').hide();

                } else {
                    $('.show_new_company').show();
                }
            });
        </script>
    @endsection
