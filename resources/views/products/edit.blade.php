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
<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="mt-5">
        @csrf
        @method('PUT')
  <div class="form-group">
    <label for="name">name</label>
    <input type="text" class="form-control" id="name" name="name"  placeholder="Enter email" value="{{$product->name}}">
    </div>
    <div class="form-group">
        <label for="exampleFormControlFile1">image show</label>
        @foreach($images as $image)
        <img src="{{ asset('images/' . $image) }}" height="100"/>
        @endforeach


  </div>
  <div class="form-group">
    <label for="price">price</label>
    <input type="text" class="form-control" id="price" name="price"  placeholder="Enter price" value="{{$product->price}}">
    </div>

              <button type="submit" class="btn btn-primary">Submit</button>

</form>
@endsection
