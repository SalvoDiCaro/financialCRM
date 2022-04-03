<div class="container">
    <input type="file" name="image" class="image" >
    {!! Form::open(['method' => 'DELETE','route' => ['profile.destroyImage', Auth::user()->id],'style'=>'display:inline']) !!}
		 {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'title' =>'Delete Image', 'class' => 'btn btn-danger btn-sm','onclick'=>"return confirm('Are you sure?')" ]) }}
    {!! Form::close() !!}

</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Crop your Profile Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
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
        <button type="button" class="btn btn-primary" id="crop">Crop</button>
      </div>
    </div>
  </div>
</div>
</div>
@section('scripts')
<!--Cropper Script--!>
<script>
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
            var base64data = reader.result;	

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "profile/imageupload",
                data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data, 'user': '<?php echo Auth::user()->id?>' },
                success: function(data){
                    $modal.modal('hide');
                    alert("success upload image");
                }
              });
         }
    });
})
</script>
@endsection
