@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><strong>Prenota il tuo posto nella stanza {{ $room->name }}</strong></h3>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-striped table-bordered table1" style="width:100%">

                        <thead>
                            <tr>
                                <th>Orari</th>
                                @foreach ($days as $day)
                                    <th>{{ date('d/m/y', $day) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hours as $hour)
                            <tr>
                                <td>{{ $hour.'-'.date("H:i", strtotime('+30 minutes', strtotime($hour))) }}</td>
                                @foreach ($days as $day)
                                <td class="text-center">

                                @php
                                $prenotated = 0;
                                @endphp
                                    @foreach ($prenotations as $prenotation)

                                        @if (date('Y-m-d H:i', strtotime($prenotation->date_from)) == ((date('Y-m-d', $day).' '.$hour)))

                                                <span class="badge btn-warning">
                                                    @if (isset(explode(' ',trim($prenotation->name))[1]))
                                                        {{ explode(' ',trim($prenotation->name))[1] }}
                                                    @else
                                                        {{ explode(' ',trim($prenotation->name))[0] }}
                                                    @endif
                                                </span>
                                                @if(auth()->user()->agent_code == '00000000' || auth()->user()->id == $prenotation->user_id)
                                                    {!! Form::open(['method' => 'DELETE','route' => ['prenotations.destroy', $prenotation->id],'class'=>'text-center']) !!}

                                                    @csrf
                                                    {{ Form::button('<i class="fa fa-times"></i>', ['type' => 'submit', 'title' => 'Elimina prenotazione', 'class' => 'badge btn-danger', 'onclick' => 'submit()']) }}
                                                    {!! Form::close() !!}
                                                @endif
                                                <p style="font-size: 1px">.</p>
                                            @php
                                            $prenotated += 1;
                                            @endphp
                                        @endif

                                    @endforeach
                                    @if ($prenotated < $room->places_available)
                                    {!! Form::open(['method' => 'post', 'route' => ['prenotations.store']]) !!}
                                    @csrf
                                    <input type="hidden" value="{{ $day }}" name="day">
                                    <input type="hidden" value="{{ $hour }}" name="hour">
                                    <input type="hidden" value="{{ $room->id }}" name="spot_id">
                                    {{ Form::button('<i class="ion ion-laptop"></i> Prenota', ['title' => 'Prenota posto', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'submit()']) }}
                                    {!! Form::close() !!}
                                    @endif
                                </td>
                                @endforeach
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
                'paging': false,
                'lengthChange': true,
                'searching': true,
                'info': false,
                'autoWidth': true,
                'responsive': true,
                "scrollX": true,
                "ordering": false

            });
        });

    </script>
@endsection
