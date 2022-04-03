<div class="form-group">
    <label>Nominativo</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        {!! Form::text('name', null, ['placeholder' => 'Nominativo', 'class' => 'form-control', 'required' => 'required']) !!}
    </div>
</div>

<div class="form-group">
    <label>Indirizzo</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        {!! Form::text('address', null, ['placeholder' => 'Indirizzo', 'class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label>Telefono</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        {!! Form::text('phone', null, ['placeholder' => 'Telefono', 'class' => 'form-control', 'required' => 'required']) !!}
    </div>
</div>
<div class="form-group">
    <label>Email</label>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
        {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control', 'required' => 'required']) !!}
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
        {!! Form::text('agent_code', null , ['placeholder' => 'Codice agente', 'class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">

    <div class="input-group">
        <label>Assegnabile &nbsp;</label>
        {!! Form::checkbox('assignable') !!}
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 text-center">
    <button type="submit" class="btn btn-primary btn-sm">Invia</button>
</div>
