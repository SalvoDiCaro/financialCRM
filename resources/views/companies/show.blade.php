@extends('layouts.app')
@section('content')

    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="pull-right">
                <a class="btn btn-info btn-sm" href="{{ route('companies.edit', $lead->id) }}" title="Modifica"><i
                        class="fa fa-edit"></i></a>
                <a class="btn btn-warning btn-sm" href="{{ URL::previous() }}" title="Indietro"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <dl>
                <div class="box-title">
                    <h2>Informazioni Azienda</h2>
                </div>
                <div class="row">
                    <div class="card col-md-6">
                        <div class="card-header">
                            <strong>Stato lead</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Canale:</strong>
                                {{ $lead->channel }}
                            </li>
                            <li class="list-group-item">
                                <strong>Stato lead:</strong>
                                {{ $lead->current_state }}
                            </li>
                        </ul>

                        <div class="card-header">
                            <strong>Dati anagrafici</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Nome:</strong>
                                {{ $lead->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Cognome:</strong>
                                {{ $lead->surname }}
                            </li>
                            <li class="list-group-item">
                                <strong>Data di nascita:</strong>
                                {{ date('d/m/Y', strtotime($lead->date_of_birth)) }}
                            </li>
                            <li class="list-group-item">
                                <strong>Luogo di nascita:</strong>
                                {{ $lead->birth_place }}
                            </li>
                        </ul>
                        <div class="card-header">
                            <strong>Contatti</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Telefono:</strong>
                                {{ $lead->phone }}
                            </li>
                            <li class="list-group-item">
                                <strong>Email:</strong>
                                {{ $lead->email }}
                            </li>
                        </ul>
                        <div class="card-header">
                            <strong>Lavoro</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Professione:</strong>
                                {{ $lead->job }}
                            </li>
                            <li class="list-group-item">
                                <strong>Tipo di contratto:</strong>
                                {{ $lead->contract_type }}
                            </li>
                            <li class="list-group-item">
                                <strong>Lavora dal:</strong>
                                {{ $lead->work_since }}
                            </li>
                            <li class="list-group-item">
                                <strong>Azienda:</strong>
                                {{ $lead->company }}
                            </li>
                            <li class="list-group-item">
                                <strong>Reddito annuo:</strong>
                                {{ $lead->annual_income }}
                            </li>
                            <li class="list-group-item">
                                <strong>Note sul lavoro:</strong>
                                {{ $lead->work_notes }}
                            </li>
                        </ul>
                        <div class="card-header">
                            <strong>Dati aggiuntivi</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Città di residenza:</strong>
                                {{ $lead->city_of_residence }}
                            </li>
                            <li class="list-group-item">
                                <strong>CAP:</strong>
                                {{ $lead->postal_code }}
                            </li>
                            <li class="list-group-item">
                                <strong>Stato civile:</strong>
                                {{ $lead->marital_status }}
                            </li>

                            <li class="list-group-item">
                                <strong>Documenti:</strong>
                                @if (isset($lead->document))
                                    {{ $lead->document }} - Documento caricato
                                @else
                                    <form action="{{ route('file.upload.post') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">

                                            <div class="col-md-6">
                                                <input type="file" name="file" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-success">Upload</button>
                                            </div>

                                        </div>
                                    </form>
                                @endif
                            </li>
                        </ul>
                    </div>

                    <div class="card col-md-6">
                        <div class="card-header">
                            <strong>Note</strong>
                        </div>
                        <ul class="list-group list-group-flush">

                            @foreach ($notes as $note)
                            {!! Form::model($note, ['method' => 'POST', 'route' => ['notes.destroy', $note->id], 'id' => 'myForm']) !!}
                            <li class="list-group-item">
                                <strong>{{ $note->name }} {{ $note->surname }}</strong>
                                <p>{{ $note->note }}<br><small>{{ date('d/m/y H:i', strtotime($note->created_at)) }}</small></p>
                                @method('DELETE')
                                @if(auth()->user()->id == $note->user_id)
                                {{ Form::button('<i class="fa fa-trash"></i>', ['title' => 'Elimina nota', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'submit()']) }}
                                @endif
                            </li>
                            {!! Form::close() !!}
                            @endforeach

                        </ul>
                        {!! Form::open(['method' => 'post', 'route' => ['notes.store'], 'style' => 'display:inline', 'id' => 'myForm']) !!}
                        <label>Aggiungi nota:</label>
                        <div class="input-group">
                            <span class="input-group-addon">{{ Form::button('<i class="fa fa-send"></i> ', ['title' => 'Aggiungi nota', 'class' => 'btn btn-info btn-lg', 'onclick' => 'submit()']) }}</span>
                            {!! Form::textarea('notes', null, ['placeholder' => 'Note', 'class' => 'form-control']) !!}
                            <input type="hidden" value="{{ $lead->id }}" name="lead">
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <strong>Note sui finanziamenti:</strong>
                    {{ $lead->loan_notes }}
                </div>

                @foreach ($debts as $debt)
                    <div class="card col-md-6">
                        <div class="card-header">
                            <strong>Finanziamento</strong>
                        </div>
                        <ul class="list-group list-group-flush">


                            <li class="list-group-item">
                                <strong>Rata:</strong>
                                {{ $debt->flat }}
                            </li>
                            <li class="list-group-item">
                                <strong>Società:</strong>
                                {{ $debt->society }}
                            </li>
                            <li class="list-group-item">
                                <strong>Scadenza:</strong>
                                {{ $debt->expiration }}
                            </li>
                            <li class="list-group-item">
                                <strong>Debito residuo:</strong>
                                {{ $debt->residual_debt }}
                            </li>
                            <li class="list-group-item">
                                <strong>Est. anticipata:</strong>
                                {{ $debt->early_termination }}
                            </li>

                        </ul>
                    </div>
                @endforeach
                <div class="form-group col-md-12">

                </div>

            </dl>
        </div>

    </div>
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
