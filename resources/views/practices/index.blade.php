@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><strong>Pratiche</strong></h3>
                    @if(auth()->user()->agent_code == '00000000')
                    <div class="pull-right">
                        <a class="btn btn-warning btn-sm" title="Crea pratica" href="{{ route('practices.create') }}"><i
                                class="fa fa-user-plus"></i></a>
                    </div>
                    @endif
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-striped table-bordered table1" style="width:100%">
                        <thead>
                            <tr class="table-heading">
                                <th>Numero pratica</th>
                                <th>Agente</th>
                                <th>Partecipanti</th>
                                <th>Importo</th>
                                <th>Data stipula</th>
                                <th>Istruttoria</th>
                                <th class="text-right">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($practices as $practice)
                                <tr>
                                    <td>{{ $practice->practice_number }}</td>
                                    <td>{{ $practice->agent_name }}</td>
                                    <td>
                                        @foreach ($partecipations as $partecipation)
                                            @if ($partecipation->practice_id == $practice->id)
                                                @if ($partecipation->typology == 'Richiedente')
                                                    <a href="{{ route('leads.show', $partecipation->lead_id) }}"
                                                        class="badge btn-primary">{{ $partecipation->name }}
                                                        {{ $partecipation->surname }}</a>
                                                @else
                                                    <a href="{{ route('leads.show', $partecipation->lead_id) }}"
                                                        class="badge btn-secondary">{{ $partecipation->name }}
                                                        {{ $partecipation->surname }}</a>
                                                @endif
                                            @endif
                                        @endforeach

                                    </td>
                                    <td>{{"€ " . number_format($practice->amount, 2, ",", ".")  }}</td>
                                    <td>{{ $practice->stipulation_date }}</td>
                                    <td>{{ $practice->inquest }}</td>
                                    <td class="text-right">

                                        {!! Form::model($practice, ['method' => 'POST', 'route' => ['practices.destroy', $practice->id], 'id' => 'myForm']) !!}
                                        <a class="btn btn-primary btn-sm" title="Mostra dettagli"
                                            href="{{ route('practices.show', $practice->id) }}"><i
                                                class="fa fa-id-badge"></i></a>
                                                @if(auth()->user()->agent_code == '00000000')
                                        <a class="btn btn-warning btn-sm" title="Modifica istanza"
                                            href="{{ route('practices.edit', $practice->id) }}"><i
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

        .red-label {
            background-color: #ff00007a !important;
        }

        .green-label {
            background-color: #00800080 !important;
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
