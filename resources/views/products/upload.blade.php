@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Contact</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary btn-sm" href="{{ route('contacts.index') }}"> Back</a>
            </div>
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


<form action="{{ route('contacts.upload',$contact->id) }}" method="POST">
        @csrf
         @method('PUT')
         <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            <input type="text" name="name" value="{{$contact->name}}" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Surname:</strong>
                            <input type="text" name="surname" value="{{$contact->surname}}" class="form-control" placeholder="Surname">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                            <input type="text" name="email" value="{{$contact->email}}"class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Phone:</strong>
                            <input type="text" name="phone" value="{{$contact->phone}}"class="form-control" placeholder="Phone">
                        </div>
                    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12">
			<div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Company:</strong>
                            <input type="text" name="company" class="form-control" placeholder="Company">
                        </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Address:</strong>
                            <input type="text" name="address_name" class="form-control" placeholder="Name">
                        </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="text" name="address_extended" class="form-control" placeholder="Extended">
                        </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="text" name="address_street" class="form-control" placeholder="Street">
                        </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="text" name="address_city" class="form-control" placeholder="City">
                        </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="text" name="address_region" class="form-control" placeholder="Region">
                        </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="text" name="address_zip" class="form-control" placeholder="Zip code">
                        </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="text" name="address_country" class="form-control" placeholder="Country">
                        </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Job Title:</strong>
                            <input type="text" name="jobtitle" class="form-control" placeholder="Job title">
                        </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>URL:</strong>
                            <input type="text" name="url" class="form-control" placeholder="URL">
                        </div>
                 </div>
	
                        <div class="form-group">
                            <strong>Rubrics:</strong>
                                {!! Form::select('rubrics', $rubrics, [], array('class' => 'form-control','multiple')) !!}
                        </div>
                    </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                 <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </div>
    </form>
@endsection

