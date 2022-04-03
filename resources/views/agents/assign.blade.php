@extends('layouts.app')
@section('content')
         <div class="box box-warning">
            <div class="box-header with-border">
		<div class="pull-right">
                   <a class="btn btn-warning btn-sm" href="{{ route('users.index')  }}" title="Back"><i class="fa fa-arrow-left"></i></a>
                </div>
              <h3 class="box-title"><strong>Assign Role</strong></h3>
            </div>
 

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

{!! Form::model($user, ['method' => 'POST','route' => ['roles.assignrole', $user->id]]) !!}
<div class="box-body">
    <div class="col-xs-12 col-sm-12 col-md-12">
	<div class="form-group">
	  <label>Give a role</label>
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-check-circle"></i></span>
		{!! Form::select('roles[]',$roles,[], array('class' =>'chosen-select','multiple', 'style'=>'width: 500px;')) !!}
		</div>
	</div>	
	 <div class="form-group">
		 <label>Give one or more Permission:</label>
		<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-check-circle-o"></i></span>
            {!! Form::select('permission[]', $permissions,[], array('class' =>'chosen-select','multiple', 'style'=>'width: 500px;')) !!}
          </div>
	</div>
                        <div class="form-group">
                                <strong>Select a Company:</strong>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-industry"></i></span>
					<select id="company"  name="company" class="form-control" style="width:250px">
					    <option disabled selected value>--- Select Company ---</option>
					    @foreach ($companies as $key => $value)
					    <option value="{{ $key }}">{{ $value->name }}</option>
					    @endforeach
					</select>
				</div>
                        <input type="checkbox" id="nocompany" class="icheckbox_square-aero">
                        </div>
                    </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                                <strong>Select a Group:</strong>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-users"></i></span>
					<select id="group" name="group" class="form-control"style="width:250px">
						<option value="0">No group</option>
					</select>
				</div>
                                <input type="checkbox" id="nogroup" class="icheckbox_square-aero">
                        </div>
                    </div>
		<footer>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
		</footer>
	</div>
    </form>

{!! Form::close() !!}
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

@section('scripts')
<script type="text/javascript">
    $(document).ready(function ()
    {
	$(".chosen-select").chosen();	

            $('select[name="company"]').on('change',function(){
               var companyID = $(this).val();
               if(companyID)
               {
                 $.ajax({
                     url : '/company/' +companyID + '/groups',
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        if($('#no-group').hasClass('d-none'))
                                $('#no-group').removeClass('d-none');

                           console.log(data);
                        $('select[name="group"]').empty();
                        $.each(data, function(key,value){
                           $('select[name="group"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="group"]').empty();
               }
            });
	 $('input').iCheck({
                checkboxClass: 'icheckbox_square-aero',
                increaseArea: '20%' // optional
        });

        $('#nogroup').on('ifChecked', function(event){
             $("#group").prop('disabled', 'disabled');
            });
        $('#nogroup').on('ifUnchecked', function(event){
                 $("#group").removeAttr("disabled");
        });
	$('#nocompany').on('ifChecked', function(event){
             $("#company").prop('disabled', 'disabled');
             $("#group").prop('disabled', 'disabled');
             $("#nogroup").iCheck('check');
        });
        $('#nocompany').on('ifUnchecked', function(event){
                $("#company").removeAttr("disabled");
                $("#group").removeAttr("disabled");
                $("#nogroup").iCheck('uncheck');
        });


    });
</script>

@endsection



