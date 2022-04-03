@extends('layouts.app')
@section('content')
    <div class="box box-warning">
        <div class="box-header with-border">
          <dl>
           <div class="box-title">
              <h2> Show Group</h2>
           </div>

		 <div class="form-group">
                <strong>Name:</strong>
                {{ $group->name }}
	    </div>

            <div class="form-group">
                <strong>Dipendent:</strong>
		@foreach($users as $user)
			<label class="badge badge-warning">{{ $user->name }}</label>
		@endforeach
            </div>

          <div>
            <div class="form-group">
		 {!! Form::model($group, ['method' => 'POST','route' => ['groups.destroy', $group->id]]) !!}
                    <a class="btn btn-warning btn-sm" title="Edit Group" href="{{ route('groups.edit',$group->id) }}">
                        <i class="fa fa-edit"></i>
                    </a>
                    @method('DELETE')
                        {{ Form::button('<i class="fa fa-trash"></i> ', ['title'=>'Delete Group','type' => 'submit', 'class' => 'btn btn-danger btn-sm','onclick'=>"return confirm('Are you sure?')" ]) }}
                {!! Form::close() !!}

            </div>
	</dl>
          <div>
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

