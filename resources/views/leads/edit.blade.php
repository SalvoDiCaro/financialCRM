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

    {!! Form::model($lead, ['method' => 'PUT', 'route' => ['leads.update', $lead->id]]) !!}
    @csrf
    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="pull-right">
                <a class="btn btn-warning btn-sm" href="{{ route('leads.index') }}" title="Back"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title"><strong>Aggiungi un nuovo lead</strong></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
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
                <div class="form-group col-md-4">
                    <label>Telefono:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        {!! Form::text('phone', null, ['placeholder' => 'Telefono', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label>Canale:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-bullhorn"></i></span>
                        {!! Form::select('channel', ['Diretta' => 'Diretta', 'Avvera' => 'Avvera', 'Online' => 'Online', 'MOL' => 'MOL', 'Credem' => 'Credem', 'PFC' => 'PFC', 'PBE' => 'PBE', 'GSM' => 'GSM', 'Facile.it' => 'Facile.it'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Stato:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                        {!! Form::select('current_state', ['Creato' => 'Creato', 'Attesa immobile' => 'Attesa immobile', 'In contatto' => 'In contatto', 'In trattativa' => 'In trattativa', 'Non finanziabile' => 'Non finanziabile', 'Non interessato' => 'Non interessato'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Aggiungi nota:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                    {!! Form::textarea('notes', null, ['placeholder' => 'Note', 'class' => 'form-control']) !!}
                </div>
            </div>
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
            <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                <a class="btn btn-success btn-sm show_work">Inserisci lavoro</a>
            </div>
            <div class="work">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Lavoro:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::select('job', ['Pubblico' => 'Pubblico', 'Privato' => 'Privato', 'Autonomo' => 'Autonomo'], null, ['class' => 'form-control', 'placeholder' => 'Inserisci lavoro']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Tipo di contratto:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::select('contract_type', ['Indeterminato' => 'Indeterminato', 'Determinato' => 'Determinato', 'Atipico' => 'Atipico'], null, ['class' => 'form-control', 'placeholder' => 'Inserisci tipologia contratto']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Azienda:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::text('company[]', null, ['placeholder' => 'Azienda', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Lavora dal:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::date('work_since[]', null, ['placeholder' => 'Lavora dal', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Reddito annuo:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            {!! Form::text('annual_income[]', null, ['placeholder' => 'Reddito annuo', 'class' => 'form-control']) !!}
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
                        {!! Form::text('flat[]', null, ['placeholder' => 'Rata', 'class' => 'form-control', 'data-type'=>"currency"]) !!}
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
                        {!! Form::text('residual_debt[]', null, ['placeholder' => 'Debito residuo', 'class' => 'form-control', 'data-type'=>"currency"]) !!}
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label>Estinzione anticipata:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::select('early_termination[]', ['SI' => 'SI', 'NO' => 'NO'], null, ['class' => 'form-control', 'placeholder' => 'Inserisci se estinzione anticipata']) !!}
                    </div>
                </div>
            </div>
            @foreach ($debts as $key => $debt)

            <div class="row" id="debt{{ $key }}">
                <div class="form-group col-md-2">
                    <label>Rata:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('flat[]', $debt->flat, ['placeholder' => 'Rata', 'class' => 'form-control', 'data-type'=>"currency"]) !!}
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
                        {!! Form::text('expiration[]', $debt->expiration, ['placeholder' => 'Scadenza', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label>Debito residuo:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('residual_debt[]', $debt->residual_debt, ['placeholder' => 'Debito residuo', 'class' => 'form-control', 'data-type'=>"currency"]) !!}
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
            <div class="form-group loan_notes">
                <label>Note finanziamenti:</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-clipboard"></i></span>
                    {!! Form::textarea('loan_notes', null, ['placeholder' => 'Note', 'class' => 'form-control']) !!}
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

        .btn {
            margin-bottom: 10px;
        }

        .work {
            display: none;
        }

        .informations {
            display: none;
        }
        #agents{
            display: none;
        }

        .loan_notes{
            display: none;
        }

        #debt{
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
                var select = $('#debt').clone().attr('id', 'debt0' + cloneCount++).insertBefore("#debt");
                select.find(':input').not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
            });
        });

        $(document).ready(function() {
            $('.show_informations').click(function() {
                $('.informations').show();
            });
            $('.show_work').click(function() {
                $('.work').show();
            });
            $('#random').on('change',(event) => {
                if(event.target.value == 0){
                    $('#agents').show();
                }else{
                    $('#agents').hide();
                }
            });
        });
    </script>
@endsection
