
@extends('layout')
@section('content')

<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">password</div>
                  <div class="card-body">

                      <form method="POST" action="{{ route('passwordconfirm.post', ['token' => $data->token]) }}" id="MyForm" >
                          @csrf
                          <div class="form-group row">
                              <label for="name" class="col-md-4 col-form-label text-md-right">password</label>
                              <div class="col-md-6">
                                  <input type="password" id="password" class="form-control" name="password">

                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">confirm password</label>
                              <div class="col-md-6">
                                  <input type="password" id="c_password" class="form-control" name="c_password">

                              </div>
                          </div>





                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                 submit
                              </button>
                          </div>
                      </form>

                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
<script>
    $(document).ready(function(){
        $("#MyForm").validate({
  rules: {

    password: {
      required: true,
      minlength: 6,
    },
    c_password: {
      required: true,
      minlength: 6,
    }
  },
  messages: {

    password: 'This password is required',

    c_password: {
        required:'This confirm  password is required',
      minlength: 'Password must be at least 6 characters long'
    }
  },

});
    })
</script>
@endsection
