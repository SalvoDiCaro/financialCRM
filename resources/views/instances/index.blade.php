@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><strong>Richieste</strong></h3>
                    <div class="pull-right">
                        <a class="btn btn-warning btn-sm" title="Crea richiesta" href="{{ route('instances.create') }}"><i
                                class="fa fa-user-plus"></i></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-striped table-bordered table1" style="width:100%">
                        <thead>
                            <tr class="table-heading">
                                {{-- <th>Id</th> --}}
                                <th>Prodotto</th>
                                <th>Tipologia</th>
                                <th>Agente</th>
                                <th>Filiale</th>
                                <th>Partecipanti</th>
                                <th>Stato</th>
                                <th>Data</th>
                                <th class="text-right">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($instances as $instance)

                                <tr class=@if (Auth::user()->agent_code == '00000000')
                                    {{ $instance->current_state == 'attesa revisione' ? 'red-label' : 'green-label' }}
                                @else {{ $instance->current_state == 'attesa agente' ? 'red-label' : 'green-label' }}
                            @endif >
                            {{-- <td>{{ $instance->id }}</td> --}}
                            <td>{{ $instance->product_name }}</td>
                            <td>{{ $instance->product_type }}</td>
                            <td>{{ $instance->agent_name }} </td>
                            <td>{{ $instance->branch }}</td>
                            <td>
                                @foreach ($partecipations as $partecipation)
                                    @if ($partecipation->instance_id == $instance->id)
                                        @if ($partecipation->typology == 'Richiedente')
                                            <p><a href="{{ route('leads.show', $partecipation->lead_id) }}" class="badge btn-primary">{{ $partecipation->name }}
                                                {{ $partecipation->surname }} {{ ":" }} {{ $partecipation->typology }}</a></p>
                                        @else
                                        <p><a href="{{ route('leads.show', $partecipation->lead_id) }}" class="badge btn-secondary">{{ $partecipation->name }}
                                                {{ $partecipation->surname }} {{ ":" }} {{ $partecipation->typology }}</a></p>
                                        @endif
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ $instance->current_state }}</td>
                            <td>{{ $instance->created_at }}</td>
                            <td class="text-right">

                                {!! Form::model($instance, ['method' => 'POST', 'route' => ['instances.destroy', $instance->id], 'id' => 'myForm']) !!}
                                <a class="btn btn-primary btn-sm" title="Mostra chat"
                                    href="{{ route('messages.show', $instance->id) }}"><i class="fa fa-comment"></i></a>
                                <a class="btn btn-danger btn-sm" title="Scarica PDF"
                                    href="{{ route('instances.show', $instance->id) }}"><i class="fa fa-file"></i></a>
                                <a class="btn btn-success btn-sm" title="Aggiungi partecipante"
                                    href="{{ route('leads.create', ['id' => $instance->id]) }}"><i class="fa fa-plus"></i></a>
                                    @if(auth()->user()->agent_code == '00000000')
                                <a class="btn btn-info btn-sm" title="Converti in pratica"
                                    href="{{ route('practices.create', ['id' => $instance->id]) }}"><i class="fa fa-pencil"></i></a>
                                    @endif
                                <a class="btn btn-warning btn-sm" title="Modifica richiesta"
                                    href="{{ route('instances.edit', $instance->id) }}"><i
                                        class="fa fa-edit"></i></a>
                                @method('DELETE')
                                {{ Form::button('<i class="fa fa-trash"></i>', ['title' => 'Elimina istanza', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'submit()']) }}
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
