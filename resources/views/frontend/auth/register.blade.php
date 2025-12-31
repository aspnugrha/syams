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
            <input type="text" name="name" id="name" placeholder="full name" class="form-control form-control-lg" required onkeydown="if(event.key === 'Enter') register()">
            <input type="email" name="email" id="email" placeholder="example@email.com" class="form-control form-control-lg" required value="{{ request()->email }}" onkeydown="if(event.key === 'Enter') register()">
            <div class="invalid-feedback" id="email-feedback"></div>
            <input type="tel" name="phone" id="phone" class="form-control form-control-lg" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" onkeydown="if(event.key === 'Enter') register()">

            <!-- hidden input untuk dikirim ke backend -->
            <input type="hidden" name="country_code" id="country_code" value="id">
            <input type="hidden" name="dial_code" id="dial_code" value="62">
            <input type="hidden" name="phone_number" id="phone_number">

            {{-- <input type="text" name="phone_number" id="phone_number" placeholder="628xxxxxxxxxx" class="form-control form-control-lg" oninput="this.value = this.value.replace(/[^0-9]/g, '')" onkeydown="if(event.key === 'Enter') register()"> --}}
            <div class="invalid-feedback" id="phone_number-feedback"></div>
            <div class="invalid-feedback" id="dial_code-feedback"></div>
            <div class="invalid-feedback" id="country_code-feedback"></div>
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
  // let phoneInput = '';
  $(document).ready(function(){
  })
  const phoneInput = document.querySelector("#phone");

  const iti = window.intlTelInput(phoneInput, {
      initialCountry: "id",          // default Indonesia
      separateDialCode: true,         // tampilkan +62 terpisah
      nationalMode: false,
      autoPlaceholder: "polite",      // placeholder sesuai negara
      formatOnDisplay: true,
      utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js"
  });

  phoneInput.addEventListener("countrychange", function () {
    const countryData = iti.getSelectedCountryData();

    // ISO code (id, us, sg)
    document.getElementById("country_code").value = countryData.iso2;

    // Dial code (+62, +1)
    document.getElementById("dial_code").value = countryData.dialCode;
    document.getElementById("phone").value = '';
    document.getElementById("phone_number").value = '';
  });

  document.getElementById('phone').addEventListener("keyup", function () {
    document.getElementById("phone_number").value = iti.getNumber().replace('+', '');
  });

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