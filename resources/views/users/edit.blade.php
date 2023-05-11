@extends('layout2')

@section('content')

<div class="pull-left">
                <a class="btn btn-primary" href="{{ route('user.index') }}">User</a>
</div>



<form method="POST" action="{{ route('user.update',$user->id) }}">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value={{ $user->name }}>
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="{{ $user->email }}">
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
</form>





@endsection
