<div class="form-group">
    <label>Nome</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        {!! Form::text('name', null, ['placeholder' => 'Nome', 'class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label>Cognome</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        {!! Form::text('surname', null, ['placeholder' => 'Cognome', 'class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label>Data di nascita</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        {!! Form::date('date_of_birth', null, ['placeholder' => 'Data di nascita', 'class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label>Telefono</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        {!! Form::text('phone', null, ['placeholder' => 'Telefono', 'class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label>Email</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
        {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
    </div>
</div>
<!-- textarea -->
<div class="form-group">
    <label>Password</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
        {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label>Conferma Password</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
        {!! Form::password('confirm-password', ['placeholder' => 'Conferma Password', 'class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label>Codice agente</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        {!! Form::text('code', null, ['placeholder' => 'Codice agente', 'class' => 'form-control']) !!}
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 text-center">
    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
</div>
