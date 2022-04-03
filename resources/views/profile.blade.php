@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    @if (Auth::user()->image != null)
                        <img class="profile-user-img img-responsive img-circle"
                            src="{{ Auth::user()->getImage(Auth::user()->id) }}" />
                    @else
                        <img class="profile-user-img img-responsive img-circle lead-pic-container"
                            src="/storage/image/stock.png" />
                    @endif
                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">Profilo di {{ $user->name }}</p>
                    <div class="text-center" style="margin-bottom:10px;">
                        <input type="file" id="pic" name="image" class="image " style="display:none;">
                        <label for="pic" class="btn btn-warning btn-xs" title="cambia immagine"> <i
                                class="fa fa-refresh"></i></label>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['profile.destroyImage', Auth::user()->id], 'style' => 'display:inline', 'id' => 'myForm']) !!}
                        {{ Form::button('<i class="fa fa-trash"></i>', ['title' => 'elimina immagine', 'class' => 'btn btn-danger btn-xs', 'onclick' => 'myFunction()']) }}
                        {!! Form::close() !!}
                    </div>

                    {!! Form::open(['method' => 'DELETE', 'route' => ['profile.deleteProfile', Auth::user()->id], 'style' => 'display:inline', 'id' => 'myForm']) !!}
                    {{ Form::button('Elimina utente', ['title' => 'Elimina utente', 'class' => 'btn btn-danger btn-block', 'onclick' => 'myFunction()']) }}
                    {!! Form::close() !!}

                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Contatti</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-user margin-r-5"></i>Nominativo</strong>

                    <p class="text-muted">
                        {{ $user->name }} {{ $user->surname }}
                    </p>

                    <hr>
                </div>

                <div class="box-body">
                    <strong><i class="fa fa-calendar margin-r-5"></i>Data di nascita</strong>

                    <p class="text-muted">
                        {{ $user->date_of_birth }}
                    </p>

                    <hr>
                </div>
                <div class="box-body">
                    <strong><i class="fa fa-phone margin-r-5"></i>Telefono</strong>

                    <p class="text-muted">
                        {{ $user->phone }}
                    </p>

                    <hr>
                    <strong><i class="fa fa-envelope margin-r-5"></i>Email</strong>
                    <p class="text-muted">
                        {{ $user->email }}
                    </p>

                    <hr>
                </div>

                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Modifica scheda</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="settings">
                        {!! Form::model($user, ['method' => 'PUT', 'route' => ['profile.update'], 'class' => 'form-horizontal']) !!}
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Nome</label>

                            <div class="col-sm-8">
                                {!! Form::text('name', null, ['placeholder' => 'Nome', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputSurname" class="col-sm-2 control-label">Cognome</label>

                            <div class="col-sm-8">
                                {!! Form::text('surname', null, ['placeholder' => 'Cognome', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDateOfBirth" class="col-sm-2 control-label">Data di nascita</label>

                            <div class="col-sm-8">
                                {!! Form::date('date_of_birth', null, ['placeholder' => 'Data di nascita', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPhone" class="col-sm-2 control-label">Telefono</label>

                            <div class="col-sm-8">
                                {!! Form::text('phone', null, ['placeholder' => 'Telefono', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                            <div class="col-sm-8">
                                {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPasword" class="col-sm-2 control-label">Password</label>

                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i toggle="#myInput"
                                            class="fa fa-eye toggle-password"></i></span>
                                    <input placeholder="***********" class="form-control" type="password" id="myInput"
                                        name="password">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPasword" class="col-sm-2 control-label">Conferma Password</label>

                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i toggle="#confirm"
                                            class="fa fa-eye toggle-confirm"></i></span>
                                    <input placeholder="***********" class="form-control" type="password" id="confirm"
                                        name="confirm-password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-warning"><i class="icon fa fa-send"></i></button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Ritaglia la tua immagine di profilo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon fa fa-times-circle"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                    <button type="button" class="btn btn-primary" id="crop">Ritaglia</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('style')
    <style type="text/css">
        img {
            display: block;
            max-width: 100%;
            pointer-events: none;
            cursor: default;
        }

        .preview {
            overflow: hidden;
            width: 160px;
            height: 160px;
            margin: 10px;
            border: 1px solid red;
            border-radius: 50%;
            margin-left: 20%;
            margin-top: 25%;
        }

        .modal-lg {
            max-width: 1000px !important;
        }

        .cropper-crop-box,
        .cropper-view-box {
            border-radius: 50%;
        }

    </style>
@endsection
@section('scripts')
    <!--Cropper Script--!>
    <script>
        var $modal = $('#modal');
        var image = document.getElementById('image');
        var user = document.getElementById('user');
        var cropper;

        $("body").on("change", ".image", function(e) {
            var files = e.target.files;
            var done = function(url) {
                image.src = url;
                $modal.modal('show');
            };
            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });

        $("#crop").click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });

            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "profile/imageupload",
                        data: {
                            '_token': $('meta[name="_token"]').attr('content'),
                            'image': base64data,
                            'user': '<?php echo Auth::user()->id; ?>'
                        },
                        success: function(data) {
                            $modal.modal('hide');
                            alert("success upload image");
                        }
                    });
                    setTimeout(function() {
                        window.location.reload(1);
                    }, 1000);

                }
            });
        })
    </script>
    <script>
        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });
        $(".toggle-confirm").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });
    </script>
@endsection
