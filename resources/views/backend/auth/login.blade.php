@extends('backend.layouts.auth')
@section('content')
<section class="bg-light border-bottom">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-7 py-5 my-5">
          <div class="subscribe-header text-center pb-3">
            <h3 class="section-title text-uppercase">Login Form Admin</h3>
            <span class="text-muted">Welcome back, crew!</span>
          </div>
          <form method="POST" id="form-data" class="d-flex flex-wrap gap-2">
            @csrf
            <input type="email" name="email" id="email" placeholder="Your Email Addresss" class="form-control form-control-lg" required value="{{ request()->email ? request()->email : old('email') }}" onkeydown="if(event.key === 'Enter') login();">
            <input type="password" name="password" id="password" placeholder="********" class="form-control form-control-lg" required onkeydown="if(event.key === 'Enter') login();">
            <span class="text-muted my-2">Don't have an account? 
                {{-- <a href="{{ route('register').(request()->email? '?email='.request()->email : '') }}">Register</a> --}}
                <span>Contact your admin</span>
            </span>
            <button type="button" id="btn-login" onclick="login()" class="btn btn-dark btn-lg text-uppercase w-100">Login</button>
            <p class="w-100 mt-2 p-0 mb-0 text-muted text-center">Your account isn't active yet? <a href="{{ route('paneladmin.activation') }}">Activate it here</a>.</p>
            <p class="w-100 mt-1 p-0 mb-0 text-muted text-center"><a href="{{ route('paneladmin.forgot-password') }}">Forgot Password?</a></p>
          </form>
        </div>
      </div>
    </div>
</section>
@endsection


@section('scripts')
<script>
  function clearForm(){
    $('#email').val('')
    $('#password').val('')
  }

  function login(){
    if (document.getElementById('form-data').reportValidity()) {
      loginProcess()
    } else {
      console.log("Form belum lengkap");
    }
  }

  function loginProcess(){
    $('#btn-login').text('Please Wait...').prop('disabled', true)
    var postData = new FormData($('#form-data')[0]);
    $.ajax({
        url: "{{ route('paneladmin.login.process') }}",
        type: "POST",
        data: postData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(res) {
            console.log(res)
            if(res.success){
              showToastr('toast-top-right', 'success', res.message)
              clearForm()
              setTimeout(() => {
                window.location.href = "{{ route('paneladmin.dashboard') }}"
              }, 1000);
            }else{
              showToastr('toast-top-right', 'error', res.message)
            }
        },
        error:function(res){
            console.log('error', res);
        },
        complete: function(){
          $('#btn-login').text('Login').prop('disabled', false)
        }
    });
  }
</script>
@endsection