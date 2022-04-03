@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title "><strong>Lista Lead</strong></h3>
                    <div class="pull-right">
                        <a class="btn btn-warning btn-sm" title="Nuovo lead" href="{{ route('leads.create') }}"><i
                                class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered table1" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Cognome</th>
                                 @if(auth()->user()->agent_code == '00000000')
                                 <th>Agente</th>
                                 <th>Diretto/Assegnato</th>
                                 @endif
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Canale</th>
                                <th>Stato</th>
                                <th>Ultima nota</th>
                                <th class="pull-right">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leads as $lead)
                                <tr>
                                    <td>{{ $lead->name }}</td>
                                    <td>{{ $lead->surname }}</td>
                                    @if(auth()->user()->agent_code == '00000000')
                                    <td>{{ $lead->agent }}</td>
                                    <td>
                                        @if ($lead->is_direct)
                                            {{ "Diretto" }}
                                        @else
                                            {{ "Assegnato" }}
                                        @endif
                                    </td>
                                    @endif
                                    <td>{{ $lead->phone }}</td>
                                    <td>{{ $lead->email }}</td>
                                    <td>{{ $lead->channel }}</td>
                                    <td>{{ $lead->current_state }}</td>
                                    <td>
                                        @if($lead->date_last_note)
                                            {{ date('d/m/y H:i', strtotime($lead->date_last_note)) }}
                                        @else
                                            {{ "Nessuna nota" }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        {!! Form::model($lead, ['method' => 'POST', 'route' => ['leads.destroy', $lead->id], 'id' => 'myForm']) !!}
                                        <a class="btn btn-primary btn-sm" title="Visualizza lead"
                                            href="{{ route('leads.show', $lead->id) }}">
                                            <i class="fa fa-id-badge"></i></a>
                                        </a>
                                        <a class="btn btn-info btn-sm" title="Crea richiesta"
                                            href="{{ route('instances.create', ['id' => $lead->id]) }}"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-warning btn-sm" title="Modifica lead"
                                            href="{{ route('leads.edit', $lead->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @method('DELETE')
                                        {{ Form::button('<i class="fa fa-trash"></i> ', ['title' => 'Cancella lead', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'submit()']) }}
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
