@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="profile-card">
                    <div class="profile-cover">
                        <div class="box-body box-profile">
                            <br>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Nome prodotto</b> <a class="pull-right">{{ $product->name }}</a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom box box-primary">
                <div class="box-header with-border">
                    <strong class="box-title">Dettagli</strong>
                    <div class="pull-right">
                        <a class="btn btn-warning btn-sm" href="javascript:history.go(-1)"
                            onMouseOver="self.status=document.referrer;return true">
                            <i class="fa fa-arrow-left"></i></a>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="Email">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <strong class="col-sm-2 pull-left">Descrizione</strong>
                                <div class="col-sm-10 pull-right">
                                    <p>{{ $product->details }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
