@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(['method' => 'GET', 'route' => ['download_module']]) !!}
    @csrf

    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="pull-right">
                <a class="btn btn-warning btn-sm" href="{{ URL::previous() }}" title="Back"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title"><strong>Crea il modulo</strong></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Nome:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('name', null, ['placeholder' => 'Nome', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Cognome:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!! Form::text('surname', null, ['placeholder' => 'Cognome', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label>Email:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        {!! Form::email('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label>Telefono:</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        {!! Form::text('phone', null, ['placeholder' => 'Telefono', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <input type="hidden" name="product" value="{{ $product }}">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-sm">Invia</button>
            </div>
        </div>

    </div>
    {!! Form::close() !!}

@endsection
@section('style')
    <style>
        img {
            display: block;
            max-width: 100%;
            pointer-events: none;
            cursor: default;
        }

        .btn {
            margin-bottom: 10px;
        }

        #debt {
            display: none;
        }

        .work {
            display: none;
        }

        .informations {
            display: none;
        }

        #agents {
            display: none;
        }

        #new_company {
            display: none;
        }

        .loan_notes {
            display: none;
        }

        #branch {
            display: none;
        }

    </style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            var cloneCount = 0;

            $('.add_debts').click(function() {
                $('.loan_notes').show();
                if (cloneCount == 0) {
                    $('#debt').show();
                    cloneCount++;
                } else {
                    var debt = $('#debt').clone().attr('id', 'debt' + cloneCount++).insertAfter("#debt");
                    debt.find("input[type=text]").val('');
                }
            });
        });

        $(document).ready(function() {
            $('.show_informations').click(function() {
                $('.informations').show();
            });
            $('.show_work').click(function() {
                $('.work').show();
            });
            $('.show_new_company').click(function() {
                $('#new_company').show();
            });
            $('#random').on('change', (event) => {
                if (event.target.value == 0) {
                    $('#agents').show();
                } else {
                    $('#agents').hide();
                }
            });

            if ($("select[name=job]").val() == 'Autonomo') {
                $("select[name=contract_type]").attr('disabled', 'disabled');
            } else {
                $("select[name=contract_type]").removeAttr('disabled', 'disabled');
            }

            $("select[name=job]").change(function() {
                if ($("select[name=job]").val() == 'Autonomo') {
                    $("select[name=contract_type]").attr('disabled', 'disabled');
                } else {
                    $("select[name=contract_type]").removeAttr('disabled', 'disabled');
                }
            });


            if ($("select[name=channel]").val() == 'Credem') {
                $("#branch").show();
            }

            $("select[name=channel]").change(function() {
                if ($("select[name=channel]").val() == 'Credem') {
                    $("#branch").show();
                } else {
                    $("#branch").val('');
                    $("#branch").hide();
                }
            });
        });
    </script>
@endsection
