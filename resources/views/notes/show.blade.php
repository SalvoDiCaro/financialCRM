@extends('layouts.app')
@section('content')
    <div class="container d-flex justify-content-center">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="profile-card">
                        <div class="profile-cover">
                            <div class="box-body box-profile">
                                <br>
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <b>Note lead di: </b>
                                        @foreach ($partecipations as $partecipation)
                                            {{ $partecipation->name }} {{ $partecipation->surname }}
                                        @endforeach
                                        <div class="pull-right">
                                            <a class="btn btn-warning btn-sm" href="{{ route('instances.index') }}"
                                                onMouseOver="self.status=document.referrer;return true">
                                                <i class="fa fa-arrow-left"></i></a>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="profile-card">
                <div class="profile-cover">
                    <div class="box-body box-profile">
                        @foreach ($notes as $note)
                            <div class="row">
                                @if ($note->user_id != $user->id)
                                    <div class="col-md-12 cloud">
                                        <strong>
                                            {{ $note->name }} {{ $note->surname }}
                                        </strong>
                                    @else
                                        <div class="col-md-12 cloud2">
                                            <strong>
                                                Io
                                            </strong>
                                @endif
                                <p>{{ $note->note }}<br><small>{{ date('d/m/y H:i', strtotime($note->created_at)) }}</small></p>
                            </div>
                    </div>
                    @endforeach
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" action="{{ route('notes.store') }}" accept-charset="UTF-8">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Scrivi messaggio</label>
                                    <textarea name="note" class="form-control text-to-send"
                                        id="exampleFormControlTextarea1" rows="3"></textarea>
                                    <input type="hidden" name="instance" value="{{ $instance }}">
                                    <button type="submit" class="btn btn-primary">Invia</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('style')
    <style>
        .cloud {
            margin: 6px 25px;
            background-color: lightblue;
            border-radius: 10px;
            width: auto;
            max-width: 350px;
        }

        .cloud2 {
            margin: 6px 25px;
            background-color: gainsboro;
            border-radius: 10px;
            width: auto;
            max-width: 350px;
        }

        .form-group {
            margin: 6px 10px;
        }

        .text-to-send {
            border-radius: 10px;
            max-width: 350px;
        }

        button {
            margin: 6px 0;
            width: 350px;
        }

        small {
            color: grey;
        }

    </style>
@stop
