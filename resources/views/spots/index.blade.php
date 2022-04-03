@extends('layouts.app')
@section('content')
    <div class="row">

        <div class="col-lg-4">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><strong>Prenota il tuo posto</strong></h3>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-striped table-bordered table1" style="width:100%">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Tipologia</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($spots as $spot)
                                    <tr>
                                    <td>{{ $spot->id }}</td>
                                    <td>{{ $spot->name }}</td>
                                    <td>{{ $spot->type }}</td>
                                    <td class="text-right">
                                        <a class="btn btn-success btn-sm" title="Prenota posto"
                                            href="{{ route('prenotations.index', ['id' => $spot->id]) }}">
                                            <i class="fa fa-id-badge"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <img src="storage/image/mappa.png">
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
                'lengthChange': false,
                'searching': false,
                'info': false,
                'autoWidth': true,
                'responsive': true,
                'columnDefs': [{
                    'targets': [1, 2],
                    /* column index */
                    'orderable': true,
                    /* true or false */
                }]
            });
        });
    </script>
@endsection
