<div class="box-body">	
		<div class="form-group">
             <div class="input-group text-center">
				<input type="file" id="pic"  name="image" class="image" style="display:none">
				<img class="profile-user-img img-responsive img-circle lead-pic-container"  id="img" src="/storage/image/stock.png"/>
                <label for="pic" class="btn  btn-warning btn-xs" title="Change Image"><i class="fa fa-refresh"></i></label>
             </div>
        </div>
        <div class="form-group">
           <label>Job Title:</label>
				<div class="input-group">
					{!! Form::select('JobTitle', ['Sig' => 'Sig', 'Sig.ina' => 'Sig.ina', 'Dottor' => 'Dottor'], null, ['class' => 'chosen-select', 'style'=>'width: 250px;']) !!}
				</div>
         </div>

        <div class="form-group">
			<label>Full name:</label>
				<div class="row">
					<div class="col-sm-6">
						<div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
								<input name="name"  class= "form-control" id="name" placeholder="Name" type="text"  value="{{$contact->name ?? ""}}" required="required" data-error="Please enter your name.">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
								<input name="surname" class= "form-control"  id="surname" placeholder="Surname" type="text" value="{{$contact->surname ?? ""}}" data-error="Please enter your surname">
						</div>
					</div>
                </div>
        </div>

	    <div class="form-group">
            <label>Company:</label>
				<div class="row">
					<div class="col-sm-6">
						<div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-briefcase"></i>
                            </div>
                       		<input name="company" id="company" placeholder="Company" value="{{ $contact->company ?? "" }}" type="text"  class= "form-control">
						</div> 
					</div>
                </div>
        </div>

        <div class="form-group">
            <label>Phone:</label>
                <div class="row RegSpLeft" id="phone">
					<div class="col-sm-12">
                        <a href="#" class="btn btn-primary pl btn-xs" ><i class="fa fa-plus"></i></a>
                    </div>
					@forelse($contact->phone ?? [] as $phone)
					<div class="col-sm-3">
						<div class="phone-container">
							<div class="input-group">
                                <div class="input-group-addon">
                                     <i class="fa fa-phone"></i>
                                </div>
								<input type="text" class="form-control" name="phone[]" value="{{ $phone }}"  placeholder="Phone number" data-error="Please enter your phone number">
							</div>
                        	<a href="#" class="btn btn-danger mi btn-xs"><i class="fa fa-minus"></i></a>
                        	<div class="help-block with-errors"></div>
						</div>
					</div>
					@empty
					@endforelse
				</div>
		</div>
		
        <div class="form-group">
            <label>Email:</label>
                <div class="row RegSpLeft" id="email">
					<div class="col-sm-12">
                       	<a href="#" class="btn btn-primary epl btn-xs"><i class="fa fa-plus"></i></a>
					</div>
					@forelse($contact->email ?? [] as $email)
					<div class="col-sm-6">
						<div class="email-container">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-at"></i>
								</div>
								<input type="text" class="form-control" name="email[]" value="{{$email}}" placeholder="Email address" data-error="Please enter your email address">
							</div>
							<a href="#" class="btn btn-danger emi btn-xs"><i class="fa fa-minus"></i></a>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					@empty
					@endforelse
                </div>
        </div>
		
        <div class="form-group">
            <label>URL:</label>
                 <div class="row RegSpLeft" id="url">
					<div class="col-sm-12">
                        <a href="#" class="btn btn-primary upl btn-xs" ><i class="fa fa-plus"></i></a>
					</div>
					@forelse($contact->url ?? [] as $url)
					<div class="col-sm-6">
						<div class="url-container">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-external-link"></i>
								</div>
								<input type="text" class="form-control"  name="url[]" value="{{$url}}"  placeholder="URL" data-error="Please enter your url">
                            </div>
							<a href="#" class="btn btn-danger umi btn-xs"><i class="fa fa-minus"></i></a>
                            <div class="help-block with-errors"></div>
						</div>
					</div>
					@empty
					@endforelse
                </div>
        </div>

        <div class="form-group">
            <label>Address:</label>
                <div class="row RegSpLeft" id="address">
					<div class="col-sm-12">
                        		<a href="#" class="btn btn-primary apl btn-xs"><i class="fa fa-plus"></i></a>
                        		@forelse($contact->address ?? [] as $key => $value)
							<div class="address-container" data-id="{{ $key }}">
							@foreach($value as $address => $add)  
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-map-marker"></i>
									</div>
									<input  placeholder="{{ $address  }}" class= "form-control" type="text" name="address[{{$key}}][address_{{$address}}]" value="{{ $add }}">
									<div class="help-block with-errors"></div>
								</div>
							@endforeach
								<a href="#" class="btn btn-danger ami btn-xs"><i class="fa fa-minus"></i></a>
							</div>
						@empty
						@endforelse
					</div>
		</div>
      </div>

		<div class="form-group text-center">
            <input type="hidden" name="rubric" value="{{$ct->rubric_id ?? $rubric->id }}">
			<input type="hidden" name="photo"  id="photo">
            <button type="submit" class="btn btn-primary btn-xs">Submit</button>
		</div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Crop your Profile Image</h5>
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
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="crop" on-click= submit();>Crop</button>
			</div>
		</div>
	</div>
</div>

@section('style')
<style type="text/css">
img{
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
  border-radius:50%;
  margin-left: 20%;
  margin-top: 25%;
}
.modal-lg{
  max-width: 1000px !important;
}
.cropper-crop-box, .cropper-view-box {
    border-radius: 50%;
}
</style>
@endsection

@section('scripts')
<script>
$(".chosen-select").chosen();
 
var $modal = $('#modal');
var image = document.getElementById('image');
var user = document.getElementById('user');
var cropper;
  
$("body").on("change", ".image", function(e){
    var files = e.target.files;
    var done = function (url) {
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
        reader.onload = function (e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    }
});

$modal.on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
	  aspectRatio: 1,
	  viewMode: 3,
	  preview: '.preview'
    });
}).on('hidden.bs.modal', function () {
   cropper.destroy();
   cropper = null;
});

$("#crop").click(function(){
    canvas = cropper.getCroppedCanvas({
	    width: 160,
	    height: 160,
      });
	
    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
         reader.readAsDataURL(blob); 
         reader.onloadend = function() {
	 var base64 = reader.result;
	 document.getElementById('photo').value = base64;
	 document.getElementById('img').src = base64;	
        		 }
    });
	$("#modal .close").click()
});

</script>
<script>
    $(function() {
        $(document).on("click", "a.pl", function(e) {
            e.preventDefault();
                var len = ($('#phone input').length);
            $('#phone').append('<div class="col-sm-3"><div class="phone-container"><div class="input-group"><div class="input-group-addon"><i class="fa fa-phone"></i></div><input type="text" class="form-control" name="phone['+len+']" placeholder="Phone number" data-error="Please enter your phone number"></div><a href="#" class="btn btn-danger mi btn-xs"><i class="fa fa-minus"></i></a><div class="help-block with-errors"></div></div></div>');
        $('#form1').validator('update');
        });
        $(document).on("click", "a.mi", function (e) {
            e.preventDefault();
                $(this).closest('.col-sm-3').remove();
        });
        $(document).on("click", "a.epl", function(e) {
            e.preventDefault();
                var len2 = ($('#email input').length);
            $('#email').append('<div class="col-sm-6"><div class="email-container"><div class="input-group"><div class="input-group-addon"><i class="fa fa-at"></i></div><input type="text" class="form-control" name="email['+len2+']" placeholder="Email address" data-error="Please enter your email address"></div><a href="#" class="btn btn-danger emi btn-xs"><i class="fa fa-minus"></i></a><div class="help-block with-errors"></div></div></div>');
        $('#form1').validator('update');
        });
        $(document).on("click", "a.emi", function (e) {
            e.preventDefault();
                $(this).closest('.col-sm-6').remove();
        });
        $(document).on("click", "a.upl", function(e) {
           e.preventDefault();
                var len3 = ($('#url input').length);
            $('#url').append('<div class="col-sm-6"><div class="url-container"><div class="input-group"><div class="input-group-addon"><i class="fa fa-external-link"></i></div><input type="text" class="form-control"  name="url['+len3+']" placeholder="URL" data-error="Please enter your url"></div><a href="#" class="btn btn-danger umi btn-xs"><i class="fa fa-minus"></i></a><div class="help-block with-errors"></div></div></div>');
        $('#form1').validator('update');
        });
        $(document).on("click", "a.umi", function (e) {
            e.preventDefault();
                $(this).closest('.col-sm-6').remove();
        });
	$(document).on("click", "a.apl", function(e) {
              e.preventDefault();
	  var len4 = ($('#address input').length);
          var content=('<div class="col-sm-12"><div class="address-container" data-id="'+len4+'"><div class="input-group"><div class="input-group-addon"><i class="fa fa-map-marker"></i></div><input placeholder="Address name" class="form-control" type="text" name="address['+len4+'][address_name]"><div class="help-block with-errors"></div></div><div class="input-group"><div class="input-group-addon"><i class="fa fa-map-marker"></i></div><input placeholder="Address extended" class= "form-control" type="text" name="address['+len4+'][address_extended]"><div class="help-block with-errors"></div></div><div class="input-group"><div class="input-group-addon"><i class="fa fa-map-marker"></i></div><input placeholder="Address street" class="form-control" type="text" name="address['+len4+'][address_street]"><div class="help-block with-errors"></div></div><div class="input-group"><div class="input-group-addon"><i class="fa fa-map-marker"></i></div><input placeholder="Address city" class= "form-control" type="text" name="address['+len4+'][address_city]"><div class="help-block with-errors"></div></div><div class="input-group"><div class="input-group-addon"><i class="fa fa-map-marker"></i></div><input placeholder="Address region" class="form-control" type="text" name="address['+len4+'][address_region]" ><div class="help-block with-errors"></div></div><div class="input-group"><div class="input-group-addon"><i class="fa fa-map-marker"></i></div><input placeholder="Zip code" class= "form-control" type="text" name="address['+len4+'][address_zip]" ><div class="help-block with-errors"></div></div><div class="input-group"><div class="input-group-addon"><i class="fa fa-map-marker"></i></div><input placeholder="Country" class= "form-control" type="text" name="address['+len4+'][address_country]" ><div class="help-block with-errors"></div></div><a href="#" class="btn btn-danger ami btn-xs"><i class="fa fa-minus"></i></a></div></div>');
	  $('#address').append(content);
          $('#form1').validator('update');
          });
	  $(document).on("click", "a.ami", function (e) {
              e.preventDefault();
                  $(this).closest('.col-sm-12').remove();
         });

    });
    </script>
@endsection
