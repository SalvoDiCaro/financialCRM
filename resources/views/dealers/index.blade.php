@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><strong>Lista dealer</strong></h3>
                    @if (Auth::user()->agent_code == '00000000')
                        <div class="pull-right">
                            <a class="btn btn-warning btn-sm" title="Crea dealer" href="{{ route('dealers.create') }}"><i
                                    class="fa fa-user-plus"></i></a>
                        </div>
                    @endif
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered table1" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Indirizzo</th>
                                <th>Telefono</th>
                                <th>Registrato il</th>
                                <th class="text-right">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dealers as $dealer)
                                <tr>
                                    <td>{{ $dealer->name }}</td>
                                    <td>{{ $dealer->email }}</td>
                                    <td>{{ $dealer->address }}</td>
                                    <td>{{ $dealer->phone }}</td>
                                    <td>{{ $dealer->created_at }}</td>
                                    <td class="text-right">

                                        @if (Auth::user()->agent_code == '00000000')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['dealers.destroy', $dealer->id], 'style' => 'display:inline', 'id' => 'myForm']) !!}
                                            <a class="btn btn-warning btn-sm" title="Modifica dealer"
                                                href="{{ route('dealers.edit', $dealer->id) }}"><i
                                                    class="fa fa-edit"></i></a>
                                            {{ Form::button('<i class="fa fa-trash"></i>', ['title' => 'Cancella utente', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'submit()']) }}
                                            {!! Form::close() !!}
                                            @csrf
                                        @else
                                            {!! Form::open(['route' => 'commitments.store', 'method' => 'POST']) !!}
                                            {{ Form::hidden('dealer_id', $dealer->id) }}
                                            {{ Form::button('<i class="fa fa-plus"></i>', ['title' => 'Accetta dealer', 'class' => 'btn btn-success btn-sm', 'onclick' => 'submit()']) }}
                                            {!! Form::close() !!}
                                        @endif
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
