@extends('frontend.layouts.app')

@section('content')
<section class="newsletter bg-light border-bottom" style="background: url(images/pattern-bg.png) no-repeat;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-7 py-5 my-5">
          <div class="subscribe-header text-center pb-3">
            <h3 class="section-title text-uppercase">Activation Account Form</h3>
            <span class="text-muted">Activate account to get full access</span>
          </div>
          <form method="POST" id="form-data" class="d-flex flex-wrap gap-2">
            @csrf
            <input type="email" name="email" id="email" placeholder="Your Email Addresss" class="form-control form-control-lg" required value="{{ request()->email ? request()->email : old('email') }}" onkeydown="if(event.key === 'Enter') event.preventDefault();">
            <span class="text-muted my-2">Don't have an account? <a href="{{ route('register').(request()->email? '?email='.request()->email : '') }}">Register</a></span>
            <button type="button" id="btn-activate" onclick="activate()" class="btn btn-dark btn-lg text-uppercase w-100">Activate Account</button>
            <p class="w-100 my-2 text-muted text-center">Your account isn't active yet? <a href="">Activate it here</a>.</p>
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
  }

  function activate(){
    if (document.getElementById('form-data').reportValidity()) {
      activateProcess()
    } else {
      console.log("Form belum lengkap");
    }
  }

  function activateProcess(){
    $('#btn-activate').text('Please Wait...').prop('disabled', true)

    var postData = new FormData($('#form-data')[0]);
    $.ajax({
        url: "{{ route('activation.process') }}",
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
            }else{
              showToastr('toast-top-right', 'error', res.message)
            }
        },
        error:function(res){
            console.log('error', res);
        },
        complete: function(){
          $('#btn-activate').text('Activate Account').prop('disabled', false)
        }
    });
  }
</script>
@endsection