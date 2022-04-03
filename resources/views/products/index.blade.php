@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><strong>Lista Prodotti</strong></h3>
                    <div class="pull-right">
                        <a class="btn btn-warning btn-sm" title="Crea prodotto" href="{{ route('products.create') }}"><i
                                class="fa fa-user-plus"></i></a>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-striped table-bordered table1" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Dettagli</th>
                                <th class="text-right">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->details }}</td>
                                    <td class="text-right">
                                        <a class="btn btn-primary btn-sm" title="Show product"
                                            href="{{ route('products.show', $product->id) }}"><i class="fa fa-id-badge"></i></a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['products.destroy', $product], 'style' => 'display:inline', 'id' => 'myForm']) !!}
                                        <a class="btn btn-warning btn-sm" title="Edit product"
                                            href="{{ route('products.edit', $product->id) }}"><i class="fa fa-edit"></i></a>
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['title' => 'Delete product', 'class' => 'btn btn-danger btn-sm', 'onclick' => 'submit()']) }}
                                        {!! Form::close() !!}
                                        @csrf
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                    'columnDefs': [{
                        'targets': [3, 4],
                        /* column index */
                        'orderable': false,
                        /* true or false */
                    }]
                });
            });
        </script>
    @endsection
