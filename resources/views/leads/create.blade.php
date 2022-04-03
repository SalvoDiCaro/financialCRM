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

    {!! Form::open(['method' => 'POST', 'route' => ['leads.store']]) !!}
    @csrf

    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="pull-right">
                <a class="btn btn-warning btn-sm" href="{{ URL::previous() }}" title="Back"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title"><strong>Aggiungi un nuovo lead</strong></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @if ($instance)
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Tipo di partecipazione:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                            {!! Form::select('typology', ['Richiedente' => 'Richiedente', 'Richiedente + Datore ipoteca' => 'Richiedente + Datore ipoteca', 'Garante' => 'Garante', 'Datore ipoteca' => 'Datore ipoteca', 'Garante fuori atto' => 'Garante fuori atto'], null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="form-group col-md-4">
                    <label>Nome:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('name', null, ['placeholder' => 'Nome', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Cognome:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('surname', null, ['placeholder' => 'Cognome', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Email:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        {!! Form::email('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label>Telefono:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        {!! Form::text('phone', null, ['placeholder' => 'Telefono', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            @if (!$instance)
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Canale:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-bullhorn"></i></span>
                            {!! Form::select('channel', ['Diretta' => 'Diretta', 'Avvera' => 'Avvera', 'Online' => 'Online', 'MOL' => 'MOL', 'Credem' => 'Credem', 'PFC' => 'PFC', 'PBE' => 'PBE', 'GSM' => 'GSM', 'Facile.it' => 'Facile.it'], null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Stato:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                            {!! Form::select('current_state', ['Creato' => 'Creato', 'Attesa immobile' => 'Attesa immobile', 'In contatto' => 'In contatto', 'In trattativa' => 'In trattativa', 'Non finanziabile' => 'Non finanziabile', 'Non interessato' => 'Non interessato'], null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row" id="branch">
                    <div class="form-group col-md-12">
                        <label>Filiale Credem:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-bullhorn"></i></span>
                            {!! Form::text('branch', null, ['placeholder' => 'Filiale Credem', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            @endif

            @if (Auth::user()->agent_code == '00000000' && !$instance)
                <div class="row assignment">
                    <div class="form-group col-md-12">
                        <label>Assegnazione:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                            {!! Form::select('random', [true => 'Random', false => 'Manuale'], null, ['class' => 'form-control', 'id' => 'random']) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group" id="agents">
                    <strong>Agente:</strong>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::select('user_id', $agents, null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            @endif
            <div class="form-group">
                <label>Note:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                    {!! Form::textarea('notes', null, ['placeholder' => 'Note', 'class' => 'form-control']) !!}
                </div>
            </div>
            @if ($instance)
                <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                    <a class="btn btn-success btn-sm show_informations">Inserisci informazioni aggiuntive</a>
                </div>
                <div class="informations">
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
                                {!! Form::date('date_of_birth', null, ['class' => 'form-control']) !!}
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
                <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                    <a class="btn btn-success btn-sm show_work">Inserisci lavoro</a>
                </div>
                <div class="work">
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
                    <a class="btn btn-success btn-sm add_debts">Inserisci situazione debitoria</a>
                </div>
                <div class="row" id="debt">
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
                            {!! Form::text('expiration[]', null, ['placeholder' => 'Scadenza', 'class' => 'form-control']) !!}
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
                            {!! Form::select('early_termination[]', ['SI' => 'SI', 'NO' => 'NO'], null, ['class' => 'form-control', 'placeholder' => 'SI/NO']) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group loan_notes">
                    <label>Note finanziamenti:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {!! Form::textarea('loan_notes', null, ['placeholder' => 'Note', 'class' => 'form-control']) !!}
                    </div>
                </div>
            @endif
            <input type="hidden" name="instance_id" value="{{ $instance }}">
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

        #debt {
            display: none;
        }

        .work {
            display: none;
        }

        .informations {
            display: none;
        }

        #agents {
            display: none;
        }

        #new_company {
            display: none;
        }

        .loan_notes {
            display: none;
        }

        #branch {
            display: none;
        }

    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            var cloneCount = 0;

            $('.add_debts').click(function() {
                $('.loan_notes').show();
                if (cloneCount == 0) {
                    $('#debt').show();
                    cloneCount++;
                } else {
                    var debt = $('#debt').clone().attr('id', 'debt' + cloneCount++).insertAfter("#debt");
                    debt.find("input[type=text]").val('');
                }
            });
        });

        $(document).ready(function() {
            $('.show_informations').click(function() {
                $('.informations').show();
            });
            $('.show_work').click(function() {
                $('.work').show();
            });
            $('.show_new_company').click(function() {
                $('#new_company').show();
            });
            $('#random').on('change', (event) => {
                if (event.target.value == 0) {
                    $('#agents').show();
                } else {
                    $('#agents').hide();
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


            if ($("select[name=channel]").val() == 'Credem') {
                $("#branch").show();
            }

            $("select[name=channel]").change(function() {
                if ($("select[name=channel]").val() == 'Credem') {
                    $("#branch").show();
                } else {
                    $("#branch").val('');
                    $("#branch").hide();
                }
            });
        });
    </script>
@endsection
