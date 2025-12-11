@extends('frontend.layouts.app')

@section('content')
<section class="newsletter bg-light" style="background: url({{ asset('assets/image/upload/banner/banner-order.png') }}) no-repeat;">
  <div class="w-100 h-100" style="background-color: rgba(255, 255, 255, 0.95);">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-7 py-5 my-5">
          <div class="subscribe-header text-center pb-3">
            <h3 class="section-title text-uppercase">Register Form</h3>
            <span class="text-muted">One more step, to get full access</span>
          </div>
          <form method="POST" id="form-data" class="d-flex flex-wrap gap-2">
            @csrf
            <input type="text" name="name" id="name" placeholder="Your Fullname" class="form-control form-control-lg" required onkeydown="if(event.key === 'Enter') register()">
            <input type="email" name="email" id="email" placeholder="Your Email Addresss" class="form-control form-control-lg" required value="{{ request()->email }}" onkeydown="if(event.key === 'Enter') register()">
            <div class="invalid-feedback" id="email-feedback"></div>
            <input type="text" name="phone_number" id="phone_number" placeholder="628xxxxxxxxxx" class="form-control form-control-lg" oninput="this.value = this.value.replace(/[^0-9]/g, '')" onkeydown="if(event.key === 'Enter') register()">
            <div class="invalid-feedback" id="phone_number-feedback"></div>
            <input type="password" name="password" id="password" placeholder="********" class="form-control form-control-lg" required onkeydown="if(event.key === 'Enter') register()">
            <div class="invalid-feedback" id="password-feedback"></div>
            <span class="text-muted my-2">Already have an account? <a href="{{ route('login') }}">Login</a></span>
            <button type="button" onclick="register()" id="btn-register" class="btn btn-dark btn-lg text-uppercase w-100">Register</button>
            <p class="w-100 my-2 text-muted text-center">Your account isn't active yet? <a href="{{ route('activation') }}">Activate it here</a>.</p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('scripts')
<script>
  function clearForm(){
    $('#name').val('')
    $('#email').val('')
    $('#phone_number').val('')
    $('#password').val('')
  }

  function register(){
    if (document.getElementById('form-data').reportValidity()) {
      registerProcess()
    } else {
      console.log("Form belum lengkap");
    }
  }

  function registerProcess(){
    $('#btn-register').text('Please Wait...').prop('disabled', true)

    var postData = new FormData($('#form-data')[0]);
    $.ajax({
        url: "{{ route('register.process') }}",
        type: "POST",
        data: postData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(res) {
            console.log(res)
            if(res.success){
              clearForm()
              showToastr('toast-top-right', 'success', res.message)
              setTimeout(() => {
                window.location.href = "{{ route('login') }}"
              }, 1000);
            }else{
              if(res.status == 'validation'){
                if(res.errors){
                  Object.entries(res.errors).forEach(([key, error]) => {
                    $('#'+key).addClass('is-invalid');
                    const msg = error ? error.join(', ') : ''; 
                    $('#'+key+'-feedback').html(msg);
                  });
                }
              }
              showToastr('toast-top-right', 'error', res.message)
            }
        },
        error:function(xhr){
            // console.log('error', xhr);
            var res = xhr.responseJSON;
            if ($.isEmptyObject(res) == false) {
                console.log(res.errors);
                
                $.each(res.errors, function(key, value) {
                    $('#' + key)
                        // .closest('#error')
                        .addClass('is-invalid');
                    $('#' + key + '-feedback').text(value.join(', '))
                });
            }
                
            showToastr('toast-top-right', 'error', "Please check the form for errors")
        },
        complete: function(){
          $('#btn-register').text('Register').prop('disabled', false)
        }
    });
  }
</script>
@endsection