@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><strong>Assegnazioni</strong></h3>
                    <div class="pull-right">
                        <a class="btn btn-warning btn-sm" title="Nuoba assegnazione" href="{{ route('assignments.create') }}"><i
                                class="fa fa-user-plus"></i></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-striped table-bordered table1" style="width:100%">

                        <thead>
                            <tr>
                                <th>Nominativo</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Agente</th>
                                <th>Data assegnazione</th>
                                <th class="text-right">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $assignment)
                                <tr>
                                    <td>{{ $assignment->name }} {{ $assignment->surname }}</td>
                                    <td>{{ $assignment->phone }}</td>
                                    <td>{{ $assignment->email }}</td>
                                    <td>{{ $assignment->agent_name }}</td>
                                    <td>{{ $assignment->created_at }}</td>
                                    <td class="text-right">
                                        {!! Form::model($assignment, ['method' => 'POST', 'route' => ['assignments.destroy', $assignment->id], 'id' => 'myForm']) !!}
                                        <a class="btn btn-warning btn-sm" title="Modifica istanza"
                                            href="{{ route('assignments.edit', $assignment->id) }}"><i
                                                class="fa fa-edit"></i></a>
                                        @method('DELETE')
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['title' => 'Elimina assegnazione', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'submit()']) }}
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
