@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title "><strong>Lista Lead completi</strong></h3>
                    <!--<div class="pull-right">
                        <a class="btn btn-warning btn-sm" title="Nuovo complead" href="{{ route('compleads.create') }}"><i
                                class="fa fa-plus"></i></a>
                    </div>-->
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered table1" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Cognome</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Canale</th>
                                <th>Stato</th>
                                <th>Note</th>
                                <th>Lavoro</th>
                                <th>Tipo di contratto</th>
                                <th>Data di nascita</th>
                                <th>Luogo di nascita</th>
                                <th>Codice fiscale</th>
                                <th>Città residenza</th>
                                <th>CAP</th>
                                <th>Indrizzo</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($compleads as $complead)
                                <tr>
                                    <td>{{ $complead->name }}</td>
                                    <td>{{ $complead->surname }}</td>
                                    <td>{{ $complead->phone }}</td>
                                    <td>{{ $complead->email }}</td>
                                    <td>{{ $complead->channel }}</td>
                                    <td>{{ $complead->current_state }}</td>
                                    <td>{{ $complead->notes }}</td>
                                    <td>{{ $complead->job }}</td>
                                    <td>{{ $complead->contract_type }}</td>
                                    <td>{{ $complead->date_of_birth }}</td>
                                    <td>{{ $complead->birth_place }}</td>
                                    <td>{{ $complead->fis_cod }}</td>
                                    <td>{{ $complead->city_of_residence }}</td>
                                    <td>{{ $complead->postal_code }}</td>
                                    <td>{{ $complead->address }}</td>

                                    <td class="text-right">
                                        {!! Form::model($complead, ['method' => 'POST', 'route' => ['compleads.destroy', $complead->id], 'id' => 'myForm']) !!}
                                        <a class="btn btn-warning btn-sm" title="Modifica complead"
                                            href="{{ route('compleads.edit', $complead->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <!--<a class="btn btn-primary btn-sm" title="Aggiungi nuovo"
                                                href="{{ route('compleads.create', $complead->id) }}">
                                                <i class="fa fa-plus"></i>
                                            </a>-->
                                        @method('DELETE')
                                        {{ Form::button('<i class="fa fa-trash"></i> ', ['title' => 'Cancella complead', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'submit()']) }}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.table1').DataTable({
                "oLanguage": {
                    "sLengthMenu": "Mostra _MENU_ dati",
                },
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'info': false,
                'autoWidth': true,
                'responsive': true,
                'columnDefs': [{
                    'targets': 3,
                    /* column index */
                    'orderable': false,
                    /* true or false */
                }]
            });
        });
    </script>
@endsection
