@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><strong>Lista utenti</strong></h3>
                    <div class="pull-right">
                        <a class="btn btn-warning btn-sm" title="Crea utente" href="{{ route('users.create') }}"><i
                                class="fa fa-user-plus"></i></a>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered table1" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th>Codice agente</th>
                                <th>Assegnabile</th>
                                <th>Registrato il</th>
                                <th class="text-right">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->agent_code }}</td>
                                    <td>
                                        @if ($user->assignable)
                                            <span class="badge bg-green p-2">SI</span>
                                        @else
                                            <span class="badge bg-red">NO</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d/m/y H:i', strtotime($user->created_at)) }}</td>
                                    <td class="text-right">
                                        <a class="btn btn-primary btn-sm" title="Mostra dettagli"
                                            href="{{ route('users.show', $user->id) }}"><i class="fa fa-id-badge"></i></a>
                                        @if ($user->agent_code != '00000000' && Auth::user()->agent_code == '00000000')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline', 'id' => 'myForm']) !!}
                                            <a class="btn btn-warning btn-sm" title="Modifica utente"
                                                href="{{ route('users.edit', $user->id) }}"><i
                                                    class="fa fa-edit"></i></a>
                                            @if (Auth::user()->id != $user->id)
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

            .bg-green {

                padding-left: 10px;
                padding-right: 10px;
            }

        </style>
    @endsection

    @section('scripts')
        <script>
            $(document).ready(function() {
            $('.table1').DataTable({
                "oLanguage": {
                    "sSearch": "Ricerca: ",
                    "sLengthMenu": "Mostra _MENU_ dati",
                    "oPaginate": {
                        "sFirst": "Prima pagina", // This is the link to the first page
                        "sPrevious": "Precedente", // This is the link to the previous page
                        "sNext": "Successiva", // This is the link to the next page
                        "sLast": "Ultima pagina" // This is the link to the last page
                    },
                },
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'info': false,
                'autoWidth': true,
                'responsive': true,
                "scrollX": true,
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
