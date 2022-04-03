@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title "><strong>Lista Aziende</strong></h3>
                    <div class="pull-right">
                        <a class="btn btn-warning btn-sm" title="Nuova azienda" href="{{ route('companies.create') }}"><i
                                class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered table1" style="width:100%">
                        <thead>
                            <tr>
                                <th>Denominazione</th>
                                <th>P.IVA</th>
                                <th>Indirizzo</th>
                                <th>Città</th>
                                <th>CAP</th>
                                <th>Tipologia</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th class="pull-right">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $company)
                                <tr>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->vat_number }}</td>
                                    <td>{{ $company->address }}</td>
                                    <td>{{ $company->city }}</td>
                                    <td>{{ $company->postal_code }}</td>
                                    <td>{{ $company->typology }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>{{ $company->phone }}</td>
                                    <td class="text-right">
                                        {!! Form::model($company, ['method' => 'POST', 'route' => ['companies.destroy', $company->id], 'id' => 'myForm']) !!}
                                        <a class="btn btn-warning btn-sm" title="Modifica Azienda"
                                            href="{{ route('companies.edit', $company->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @method('DELETE')
                                        {{ Form::button('<i class="fa fa-trash"></i> ', ['title' => 'Cancella Azienda', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'submit()']) }}
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
