@extends('layouts.app')
@section('content')
<div class="box box-warning">
            <div class="box-header with-border">
		<div class="pull-right">
                   <a class="btn btn-warning btn-sm" href="{{ route('dealers.index')  }}" title="Back"><i class="fa fa-arrow-left"></i></a>
                </div>
              <h3 class="box-title"><strong>Modifica dealer</strong></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
		{!! Form::model($user, ['method' => 'PATCH','route' => ['dealers.update', $user->id]]) !!}
			@include('dealers.form')
		{!! Form::close() !!}
</div>
@endsection
@section('style')
<style>
img{
 display: block;
 max-width: 100%;
 pointer-events:none;
 cursor: default;
}
</style>
@endsection
