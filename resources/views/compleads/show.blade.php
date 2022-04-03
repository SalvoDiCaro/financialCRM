@extends('layouts.app')
@section('content')

    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="pull-right">
                <a class="btn btn-warning btn-sm" href="{{ url()->previous() }}" title="Back"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <dl>
                <div class="box-title">
                    <h2> Mostra lead completo</h2>
                </div>

                <div class="form-group">
                    <strong>Nome:</strong>
                    {{ $complead->name }}
                </div>

                <div class="form-group">
                    <strong>Cognome:</strong>
                    {{ $complead->surname }}
                </div>

                <div class="form-group">
                    <strong>Telefono:</strong>
                    {{ $complead->phone }}
                </div>

                <div class="form-group">
                    <strong>Email:</strong>
                    {{ $complead->email }}
                </div>

                <div class="form-group">
                    <strong>Canale:</strong>
                    {{ $complead->channel }}
                </div>

                <div class="form-group">
                    <strong>Email:</strong>
                    {{ $complead->current_state }}
                </div>

                <div class="form-group">
                    <strong>Note:</strong>
                    {{ $complead->notes }}
                </div>

                <div class="form-group">
                    <strong>Data di nascita:</strong>
                    {{ $complead->date_of_birth }}
                </div>

                <div class="form-group">
                    <strong>Codice fiscale:</strong>
                    {{ $complead->fis_cod }}
                </div>

                <strong>Documenti:</strong>
                @if (isset($complead->document))
                    {{ $complead->document }} - Documento caricato
                @else
                <form action="{{ route('file.upload.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-md-3">
                            <input type="file" name="file" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>

                    </div>
                </form>
                @endif

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
