@extends('layouts.app')
@section('content')

    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="pull-right">

                <a class="btn btn-warning btn-sm" href="{{ url()->previous() }}" title="Indietro"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <dl>
                <div class="box-title">
                    <h2>Informazioni Dealer</h2>
                </div>
                <div class="row">

                    <div class="card col-md-12">
                        <div class="card-header">
                            <strong>Annotazioni</strong>
                        </div>
                        <ul class="list-group list-group-flush">

                            @foreach ($annotations as $annotation)
                            {!! Form::model($annotation, ['method' => 'POST', 'route' => ['annotations.destroy', $annotation->id], 'id' => 'myForm']) !!}
                            <li class="list-group-item">
                                <strong>{{ $annotation->name }}</strong>
                                <p>{{ $annotation->note }}<br><small>{{ date('d/m/y H:i', strtotime($annotation->created_at)) }}</small></p>
                                @method('DELETE')
                                @if(auth()->user()->agent_code == '00000000')
                                {{ Form::button('<i class="fa fa-trash"></i>', ['title' => 'Elimina nota', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'submit()']) }}
                                @endif
                            </li>
                            {!! Form::close() !!}
                            @endforeach

                        </ul>
                        {!! Form::open(['method' => 'post', 'route' => ['annotations.store'], 'style' => 'display:inline', 'id' => 'myForm']) !!}
                        <label>Aggiungi nota:</label>
                        <div class="input-group">
                            <span class="input-group-addon">{{ Form::button('<i class="fa fa-send"></i> ', ['title' => 'Aggiungi nota', 'class' => 'btn btn-info btn-lg', 'onclick' => 'submit()']) }}</span>
                            {!! Form::textarea('note', null, ['placeholder' => 'Note', 'class' => 'form-control']) !!}
                            <input type="hidden" value="{{ $dealer_id }}" name="dealer_id">
                        </div>

                        {!! Form::close() !!}
                    </div>
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
