@extends('layouts.app')
@section('content')
    <div class="box box-warning">
        <div class="box-header with-border">
            <dl>
                <div class="box-title">
                    <h2>Dettagli richiesta</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-warning btn-sm" href="{{ route('instances.index') }}" title="Back"><i
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
                        <strong>Premio CPI:</strong>
                        {{ $instance->cpi_awards }}
                    </div>

                    <div class="form-group">
                        <strong>Finalità:</strong>
                        {{ $instance->finality }}
                    </div>

                    <div class="form-group">
                        <strong>LTV fin:</strong>
                        {{ $instance->ltv_fin }}
                    </div>

                    <div class="form-group">
                        <strong>Durata:</strong>
                        {{ $instance->duration }}
                    </div>

                    <div class="form-group">
                        <strong>Incendio:</strong>
                        {{ $instance->fire }}
                    </div>

                    <div class="form-group">
                        <strong>Incendio completo:</strong>
                        {{ $instance->complete_fire }}
                    </div>

                    <div class="form-group">
                        <strong>Infortunio:</strong>
                        {{ $instance->injuries }}
                    </div>

                    <div class="form-group">
                        <strong>Ppl:</strong>
                        {{ $instance->ppl }}
                    </div>

                    <div class="form-group">
                        <strong>Vita:</strong>
                        {{ $instance->life }}
                    </div>

                    <div class="form-group">
                        <strong>Spread:</strong>
                        {{ $instance->spread }}
                    </div>

                    <div class="form-group">
                        <strong>Fascia spread:</strong>
                        {{ $instance->spread_band }}
                    </div>
                    <div class="form-group">
                        <strong>Numero cpi:</strong>
                        {{ $instance->cpi_number }}
                    </div>

                    <div class="form-group">
                        <strong>Istruttoria:</strong>
                        {{ $instance->inquest }}
                    </div>

                    <div class="form-group">
                        <strong>LTV banca:</strong>
                        {{ $instance->ltv_bank }}
                    </div>

                    <div class="form-group">
                        <strong>Rating:</strong>
                        {{ $instance->rating }}
                    </div>

                    <div class="form-group">
                        <strong>Incendio importo:</strong>
                        {{ $instance->fire_amount }}
                    </div>

                    <div class="form-group">
                        <strong>Incendio completo importo:</strong>
                        {{ $instance->complete_fire_amount }}
                    </div>

                    <div class="form-group">
                        <strong>Infortunio importo:</strong>
                        {{ $instance->injuries_amount }}
                    </div>

                    <div class="form-group">
                        <strong>Ppl importo:</strong>
                        {{ $instance->ppl_amount }}
                    </div>

                    <div class="form-group">
                        <strong>Vita importo:</strong>
                        {{ $instance->life_amount }}
                    </div>

                    <div class="form-group">
                        <strong>LTV fascia:</strong>
                        {{ $instance->ltv_band }}
                    </div>

                    <div class="form-group">
                        <strong>Cartaceo/Digitale:</strong>
                        {{ $instance->paper_digital }}
                    </div>



                    <div>
                        <div class="form-group">
                            {!! Form::model($instance, ['method' => 'POST', 'route' => ['instances.destroy', $instance->id]]) !!}
                            <a class="btn btn-warning btn-sm" title="Modifica pratica"
                                href="{{ route('instances.edit', $instance->id) }}">
                                <i class="fa fa-edit"></i>
                            </a>
                            @method('DELETE')
                            {{ Form::button('<i class="fa fa-trash"></i> ', ['title' => 'Elimina pratica', 'type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) }}
                            {!! Form::close() !!}

                        </div>
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
