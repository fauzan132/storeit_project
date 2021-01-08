<!DOCTYPE html>
<html>
<head>
    <title>Coba Crop Image</title>
    <meta name="_token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
</head>
<style type="text/css">
img {
  display: block;
  max-width: 100%;
}
.preview {
  overflow: hidden;
  width: 160px; 
  height: 160px;
  margin: 10px;
  border: 1px solid red;
}
.modal-lg{
  max-width: 1000px !important;
}
</style>
<body>

<div class="modal hide fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Crop This Image</h5>
        <a class="close" aria-label="Close" href="{{ url('admin-data/index_all/') }}">
          <span aria-hidden="true">×</span>
        </a>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="image" src="{{ URL::asset("images/{$data->ImageURL}") }}">
                </div>
                <div class="col-md-4">
                    <div class="preview"></div>
                </div>
            </div>
			<small style="color:red;">*Arahkan kursor pada gambar dan klik kiri</small>
        </div>
      </div>
      <div class="modal-footer">
        <a class="btn btn-secondary" href="{{ url('admin-data/index_all/') }}">Cancel</a>
        <button type="button" class="btn btn-primary" id="crop">Crop</button>
      </div>
    </div>
  </div>
</div>

</div>
</div>
<script>
var $modal = $('#modal');
var image = document.getElementById('image');
var cropper;
  
//memunculkan preview image ke modal
$modal.modal('show');
$("body").on("change", ".image", function(e){
    var files = e.target.files;
    var done = function (url) {
      image.src = url;
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
//aksi crop di modal
$modal.on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
	  aspectRatio: 1,
	  viewMode: 1,
	  preview: '.preview',
	  cropBoxResizable: false,
	  dragMode: 'move',
      restore: false,
      guides: false,
      center: false,
      highlight: false,
      cropBoxMovable: true,
      toggleDragModeOnDblclick: false,
    });
}).on('hidden.bs.modal', function () {
   cropper.destroy();
   cropper = null;
});
//cropping image
$("#crop").click(function(){
    canvas = cropper.getCroppedCanvas({
	    width: 256,
	    height: 256,
      });
	
	//upload to folder "upload"
    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
         reader.readAsDataURL(blob); 
         reader.onloadend = function() {
            var base64data = reader.result;	
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ url('admin-data/upload_all',$data->imageID) }}",
                data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
                success: function(data){
                    $modal.modal('hide');
                    alert("success upload image");
                    window.location.href = "{{ url('admin-data/index_all/') }}";
                }
              });
         }
    });
})
</script>
</body>
</html> 