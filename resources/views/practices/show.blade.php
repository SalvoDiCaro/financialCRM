@extends('layouts.app')
@section('content')
    <div class="box box-warning">
        <div class="box-header with-border">
            <dl>
                <div class="box-title">
                    <h2>Dettagli pratica</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-warning btn-sm" href="{{ route('practices.index') }}" title="Back"><i
                            class="fa fa-arrow-left"></i></a>
                </div>
                <div class="form-group">
                    <strong>Partecipanti:</strong>
                    @foreach ($partecipations as $partecipation)
                        @if ($partecipation->typology == 'Richiedente')
                            <span class="badge btn-primary">{{ $partecipation->name }}
                                {{ $partecipation->surname }}</span>
                        @else
                            <span class="badge btn-secondary">{{ $partecipation->name }}
                                {{ $partecipation->surname }}</span>
                        @endif
                    @endforeach
                </div>
                <div class="form-group">
                    <strong>Numero pratica:</strong>
                    {{ $practice->practice_number }}
                </div>

                <div class="form-group">
                    <strong>Importo:</strong>
                    {{"€ " . number_format($instance->amount, 2, ",", ".")  }}
                </div>

                <div class="form-group">
                    <strong>Data di stipula:</strong>
                    {{ $practice->stipulation_date }}
                </div>

                <div class="form-group">
                    <strong>Premio CPI:</strong>
                    {{ $practice->cpi_awards }}
                </div>

                <div class="form-group">
                    <strong>Finalità:</strong>
                    {{ $instance->finality }}
                </div>

                <div class="form-group">
                    <strong>LTV fin:</strong>
                    {{ $practice->ltv_fin }}
                </div>

                <div class="form-group">
                    <strong>Durata:</strong>
                    {{ $instance->duration }}
                </div>

                <div class="form-group">
                    <strong>Incendio:</strong>
                    {{ $practice->fire }}
                </div>

                <div class="form-group">
                    <strong>Incendio completo:</strong>
                    {{ $practice->complete_fire }}
                </div>

                <div class="form-group">
                    <strong>Infortunio:</strong>
                    {{ $practice->injuries }}
                </div>

                <div class="form-group">
                    <strong>Ppl:</strong>
                    {{ $practice->ppl }}
                </div>

                <div class="form-group">
                    <strong>Vita:</strong>
                    {{ $practice->life }}
                </div>

                <div class="form-group">
                    <strong>Spread:</strong>
                    {{ $instance->spread }}
                </div>

                <div class="form-group">
                    <strong>Fascia spread:</strong>
                    {{ $practice->spread_band }}
                </div>
                <div class="form-group">
                    <strong>Numero cpi:</strong>
                    {{ $practice->cpi_number }}
                </div>

                <div class="form-group">
                    <strong>Istruttoria:</strong>
                    {{ $instance->inquest }}
                </div>

                <div class="form-group">
                    <strong>LTV banca:</strong>
                    {{ $practice->ltv_bank }}
                </div>

                <div class="form-group">
                    <strong>Rating:</strong>
                    {{ $instance->rating }}
                </div>

                <div class="form-group">
                    <strong>Incendio importo:</strong>
                    {{ $practice->fire_amount }}
                </div>

                <div class="form-group">
                    <strong>Incendio completo importo:</strong>
                    {{ $practice->complete_fire_amount }}
                </div>

                <div class="form-group">
                    <strong>Infortunio importo:</strong>
                    {{ $practice->injuries_amount }}
                </div>

                <div class="form-group">
                    <strong>Ppl importo:</strong>
                    {{ $practice->ppl_amount }}
                </div>

                <div class="form-group">
                    <strong>Vita importo:</strong>
                    {{ $practice->life_amount }}
                </div>

                <div class="form-group">
                    <strong>LTV fascia:</strong>
                    {{ $practice->ltv_band }}
                </div>

                <div class="form-group">
                    <strong>Cartaceo/Digitale:</strong>
                    {{ $practice->paper_digital }}
                </div>

                <div>
                    @if(auth()->user()->agent_code == '00000000')
                    <div class="form-group">
                        {!! Form::model($practice, ['method' => 'POST', 'route' => ['practices.destroy', $practice->id]]) !!}
                        <a class="btn btn-warning btn-sm" title="Modifica pratica"
                            href="{{ route('practices.edit', $practice->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        @method('DELETE')
                        {{ Form::button('<i class="fa fa-trash"></i> ', ['title' => 'Elimina pratica', 'type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) }}
                        {!! Form::close() !!}

                    </div>
                    @endif
            </dl>
            <div>
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
