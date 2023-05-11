@extends('layout')
@section('content')

<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Register</div>
                  <div class="card-body">

                      <form method="POST" action="{{route('register.post')}}" id="MyForm">
                          @csrf
                          <div class="form-group row">
                              <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                              <div class="col-md-6">
                                  <input type="text" id="name" class="form-control" name="name" >

                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                              <div class="col-md-6">
                                  <input type="text" id="email_address" class="form-control" name="email" >

                              </div>
                          </div>



                        

                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  Register
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
$(document).ready(function() {
$("#MyForm").validate({
  rules: {
    name: 'required',
    email: {
      required: true,
      email: true,
    },
    password: {
      required: true,
      minlength: 6,
    }
  },
//   messages: {
//     name:
//     // {
//     //     required:'This name is required',
//     // }
//     // // user_email: 'This email is required',
//     // // user_email: 'Enter a valid email',
//     // password: {
//     //     required:'This password is required',
//     //   minlength: 'Password must be at least 6 characters long'
//     // }
//   },

});
});
</script>
@endsection
