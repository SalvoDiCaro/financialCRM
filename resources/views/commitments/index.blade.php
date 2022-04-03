@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><strong>Affidamento Dealer</strong></h3>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-striped table-bordered table1" style="width:100%">

                        <thead>
                            <tr>
                                @if(auth()->user()->agent_code == '00000000')
                                    <th>Agente</th>
                                @endif
                                <th>Nominativo</th>
                                <th>Stato</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Data assegnazione</th>
                                <th class="text-right">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commitments as $commitment)
                                <tr>
                                    @if(auth()->user()->agent_code == '00000000')
                                        <td>{{ $commitment->agent_name }}</td>
                                    @endif
                                    <td>{{ $commitment->dealer_name }}</td>
                                    <td>{{ $commitment->current_state }}</td>
                                    <td>{{ $commitment->phone }}</td>
                                    <td>{{ $commitment->email }}</td>
                                    <td>{{ date('d/m/y H:i', strtotime($commitment->created_at)) }}</td>
                                    <td class="text-right">
                                        {!! Form::model($commitment, ['method' => 'POST', 'route' => ['commitments.destroy', $commitment->id], 'id' => 'myForm']) !!}
                                        <a class="btn btn-primary btn-sm" title="Visualizza Affidamento"
                                            href="{{ route('commitments.show', $commitment->id) }}">
                                            <i class="fa fa-id-badge"></i></a>
                                        </a>
                                        <a class="btn btn-warning btn-sm" title="Modifica istanza"
                                            href="{{ route('commitments.edit', $commitment->id) }}"><i
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
