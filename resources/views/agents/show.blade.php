@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="profile-card">
                    <div class="profile-cover">
                        <div class="box-body box-profile">
                            @if ($user->image != null)
                                <img class="profile-user-img img-responsive img-circle"
                                    src="{{ Auth::user()->getImage(Auth::user()->id) }}" />
                            @else
                                <img class="profile-user-img img-responsive img-circle lead-pic-container"
                                    src="/storage/image/stock.png" />
                            @endif
                            <h3 class="profile-username text-center">{{ $user->name }}</h3>

                            <p class="text-muted text-center">Profilo di {{ $user->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Contatti</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-envelope margin-r-5"></i>Nominativo</strong>
                    <p class="text-muted">
                        {{ $user->name }} {{ $user->surname }}
                    </p>
                    <hr>
                    <strong><i class="fa fa-envelope margin-r-5"></i>Codice agente</strong>
                    <p class="text-muted">
                        {{ $user->agent()->pluck('code')->first() }}
                    </p>

                    <hr>
                    <hr>
                    <strong><i class="fa fa-envelope margin-r-5"></i>Email</strong>
                    <p class="text-muted">
                        {{ $user->email }}
                    </p>

                    <hr>

                    <strong><i class="fa fa-wrench margin-r-5"></i>Telefono</strong>
                    <p class="text-muted">
                        {{ $user->phone }}
                    </p>
                    <hr>

                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Lead assegnati</h3>
                    <div class="pull-right">
                        <a class="btn btn-warning btn-sm" href="{{ route('agents.index') }}" title="Back"><i
                                class="fa fa-arrow-left"></i></a>
                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-briefcase margin-r-5"></i>Polizze chiuse</strong>



                    <hr>

                    <hr>

                </div>
                <!-- /.box-body -->
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
