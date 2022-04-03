@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title "><strong>Lista Clienti</strong></h3>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered table1" style="width:100%">
                        <thead>
                            <tr class="table-heading">
                                <th>Nome</th>
                                <th>Cognome</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Numero pratica</th>
                                <th>Data stipula</th>
                                <th class="text-right">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($partecipations as $partecipation)
                                <tr>
                                    <td>{{ $partecipation->name }}</td>
                                    <td>{{ $partecipation->surname }}</td>
                                    <td>{{ $partecipation->phone }}</td>
                                    <td>{{ $partecipation->email }}</td>
                                    <td>
                                        <a href="{{ route('practices.show', $partecipation->practice_id) }}"
                                            class="badge btn-primary">{{ $partecipation->practice_number }}
                                        </a>
                                    </td>
                                    <td>{{ $partecipation->stipulation_date }}</td>

                                    <td class="text-right">

                                        {!! Form::model($partecipation, ['method' => 'POST', 'route' => ['practices.destroy', $partecipation->practice_id], 'id' => 'myForm']) !!}
                                        <a class="btn btn-primary btn-sm" title="Mostra dettagli"
                                            href="{{ route('practices.show', $partecipation->practice_id) }}"><i
                                                class="fa fa-id-badge"></i></a>
                                                @if(auth()->user()->agent_code == '00000000')
                                        <a class="btn btn-warning btn-sm" title="Modifica istanza"
                                            href="{{ route('practices.edit', $partecipation->practice_id) }}"><i
                                                class="fa fa-edit"></i></a>
                                        @method('DELETE')
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['title' => 'Elimina istanza', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'submit()']) }}
                                        @endif
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
