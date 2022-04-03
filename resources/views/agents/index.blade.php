@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><strong>Lista Agenti</strong></h3>
                    <div class="pull-right">
                        <a class="btn btn-warning btn-sm" title="Crea utente" href="{{ route('agents.create') }}"><i
                                class="fa fa-user-plus"></i></a>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered table1" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Cognome</th>
                                <th>data di nascita</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th>Registrato il</th>
                                <th class="text-right">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agents as $agent)
                                <tr>
                                    <td>{{ $agent->name }}</td>
                                    <td>{{ $agent->surname }}</td>
                                    <td>{{ $agent->date_of_birth }}</td>
                                    <td>{{ $agent->email }}</td>
                                    <td>{{ $agent->phone }}</td>
                                    <td>{{ $agent->created_at }}</td>
                                    <td class="text-right">
                                        <a class="btn btn-primary btn-sm" title="Mostra dettagli"
                                            href="{{ route('agents.show', $agent->id) }}"><i class="fa fa-id-badge"></i></a>
                                        @if ($agent->id != '1')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['agents.destroy', $agent->id], 'style' => 'display:inline', 'id' => 'myForm']) !!}
                                            <a class="btn btn-warning btn-sm" title="Modifica utente"
                                                href="{{ route('agents.edit', $agent->id) }}"><i class="fa fa-edit"></i></a>
                                            @if (Auth::user()->id != $agent->id)
                                                <a class="btn btn-success btn-sm" title="Assegna Lead" href="#"><i
                                                        class="fa fa-plus"></i></a>
                                            @endif
                                            {{ Form::button('<i class="fa fa-trash"></i>', ['title' => 'Cancella utente', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'submit()']) }}
                                            {!! Form::close() !!}
                                            @csrf
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                        'targets': [3, 4],
                        /* column index */
                        'orderable': false,
                        /* true or false */
                    }]
                });
            });
        </script>
    @endsection
