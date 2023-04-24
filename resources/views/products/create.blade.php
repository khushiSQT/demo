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
    <label for="exampleFormControlFile1">image</label>
    <input type="file" class="form-control" id="image" name="image">

  </div>
  <div class="form-group">
    <label for="price">price</label>
    <input type="text" class="form-control" id="price" name="price"  placeholder="Enter price">

    </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>




@endsection
