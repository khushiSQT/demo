@extends('layout2')

@section('content')


<div class="pull-left">
                <a class="btn btn-primary" href="{{ route('products.index') }}">Product</a>
</div>

@if(session()->has('message'))
    <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul><li>
        {{ session()->get('message') }}
</li></ul>
    </div>
        @endif
<form action="{{ route('products.store') }}" class="mt-5" method="POST"  enctype="multipart/form-data">
    @csrf
  <div class="form-group">
    <label for="name">name</label>
    <input type="text" class="form-control" id="name" name="name"  placeholder="Enter name">

    </div>

  <div class="form-group">
    <label for="price">price</label>
    <input type="text" class="form-control" id="price" name="price"  placeholder="Enter price">

    </div>
    images
    <input type="file" id="image-upload" name="image[]" multiple>
    <div id="image-preview" ></div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>



<script>
   $(document).ready(function() {
  $("#image-upload").change(function() {
   $("#image-preview").html("");
    var files = this.files;
    for (var i = 0; i < files.length; i++) {
      var reader = new FileReader();
      reader.onload = function(event) {
        var image = new Image();
        image.src = event.target.result;
        $("#image-preview").append(image);
      };
      reader.readAsDataURL(files[i]);
    }
  });
});


</script>

@endsection
