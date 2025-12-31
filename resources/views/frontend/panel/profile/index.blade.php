@extends('frontend.layouts.app')

@section('styles')
<style>
    #table-data th, td{
        border: 1px solid #212529 !important;
    }

    .custom-upload-box {
        border: 2px dashed #ccc;
        border-radius: 10px;
        min-height: 200px;
        height: 100% !important;
        /* width: 150px; */
        cursor: pointer;
    }

    .custom-preview-item {
        position: relative;
        width: 100%;
        height: 100%;
        border-radius: 10px;
        overflow: hidden;
    }

    .custom-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .btn-remove {
        position: absolute;
        top: 3px;
        right: 3px;
        background: black;
        opacity: 0.6;
        color: white;
        border: none;
        border-radius: 50%;
        width: 26px;
        height: 26px;
        cursor: pointer;
    }
</style>
@endsection
@section('content')
<div class="collection bg-light position-relative pt-5">
    <div class="container">
        <div class="collection-item d-flex flex-wrap pb-5">
            <div class="column-container bg-white w-100">
                <div class="collection-content p-4 m-0 m-md-5 text-dark">
                    <h4 class="mb-4 mt-1">Profile</h4>
                        
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="true">
                            Account
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">
                            Password
                            </button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content mt-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                            <form class="row" id="form-profile">
                                <input type="hidden" name="id" value="{{ $customer->id }}">
                                @csrf
                                <div class="col-12 col-md-4">
                                    <div class="w-100 h-100 mb-2">
                                        <div class="container h-100">
                                            <div id="customUploadWrapper" class="d-flex flex-wrap gap-3 h-100">
                                                <div id="customUploadBox" class="custom-upload-box d-flex flex-column justify-content-center align-items-center w-100 h-100"
                                                    onclick="document.getElementById('image').click();">
                                                    <i class="mdi mdi-image" style="font-size: 40px;color:#ccc;"></i>
                                                    <span class="text-secondary">Unggah gambar</span>
                                                </div>
                                            </div>

                                            <input type="file" name="image" id="image" class="" accept="image/jpg,image/jpeg,image/png,image/webp" style="visibility: hidden;">
                                        </div>
                                    </div>
                                    {{-- <img src="{{ $customer->image ? asset('assets/image/upload/customer/'.Auth::guard('customer')->user()->image) : 'https://via.assets.so/img.jpg?w=400&h=300&bg=e5e7eb&text=+&f=png' }}" alt="Image Profile" style="width: 100%;"> --}}
                                    <div id="imageHelp" class="form-text text-danger invalid-feedback">Enter your fullname here.</div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <h4 class="mt-3">{{ $customer->name }}</h4>
                                    <span class="text-muted mb-2">Complete your data to make it easier to manage your orders.</span>
                                    @if (!$customer->phone_number)
                                    <div class="alert alert-warning w-100" role="alert">
                                        Your <u>phone number</u> is incomplete, please complete the data for your convenience.
                                    </div>
                                    @endif

                                    <div class="my-4">
                                        <div class="mb-2">
                                            <label for="fullname" class="form-label">Fullname <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Alexander William" value="{{ $customer->name }}">
                                            <div id="fullnameHelp" class="form-text text-danger invalid-feedback">Enter your fullname here.</div>
                                        </div>
                                        <div class="mb-2">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="example@email.com" value="{{ $customer->email }}">
                                            <div id="emailHelp" class="form-text text-danger invalid-feedback">Enter your email here.</div>
                                        </div>
                                        <div class="mb-2">
                                            <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                            {{-- <input type="text" class="form-control" name="phone_number" id="phone_number" oninput="this.value=this.value.replace(/\D/g,'')" placeholder="628**********" value="{{ $customer->phone_number }}"> --}}

                                            <input type="tel" name="phone" id="phone" class="form-control" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ $customer->phone_number }}">

                                            <!-- hidden input untuk dikirim ke backend -->
                                            <input type="hidden" name="country_code" id="country_code" value="{{ $customer->country_code }}">
                                            <input type="hidden" name="dial_code" id="dial_code" value="{{ $customer->dial_code }}">
                                            <input type="hidden" name="phone_number" id="phone_number" value="{{ $customer->phone_number }}">

                                            <div class="invalid-feedback" id="dial_codeHelp"></div>
                                            <div class="invalid-feedback" id="country_codeHelp"></div>
                                            <div id="phone_numberHelp" class="form-text text-danger invalid-feedback">Enter your phone_number here.</div>
                                        </div>
                                        <button type="button" class="btn btn-dark text-uppercase w-100 mt-3" onclick="saveProfile()">Update My Profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <h4 class="mt-3">Form Password</h4>
                            <span class="text-muted mb-2">This form allows you to change your account password. Make sure your password is at least 6 characters long, strong, and easy to remember..</span>
                            
                            <form class="my-4" id="form-password">
                                @csrf
                                <input type="hidden" name="id" value="{{ $customer->id }}">
                                <div class="mb-2">
                                    <label for="old_password" class="form-label">Old password</label>
                                    <input type="password" class="form-control" name="old_password" id="old_password" placeholder="******">
                                    <div id="old_passwordHelp" class="form-text invalid-feedback text-danger">Enter your old password here.</div>
                                </div>
                                <div class="mb-2">
                                    <label for="new_password" class="form-label">New password</label>
                                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="******">
                                    <div id="new_passwordHelp" class="form-text invalid-feedback text-danger">Enter your new password here.</div>
                                </div>
                                <div class="mb-2">
                                    <label for="confirm_new_password" class="form-label">Confirm new password</label>
                                    <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" placeholder="******">
                                    <div id="confirm_new_passwordHelp" class="form-text invalid-feedback text-danger">Enter your confirm new password here.</div>
                                </div>
                                <button type="button" class="btn btn-dark text-uppercase w-100 mt-3" onclick="saveNewPassword()">Set New Password</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });	

    if("{{ $customer->image }}"){
        setImageProfile()
    }

    if("{{ $customer->country_code }}"){
        iti.setCountry("{{ $customer->country_code }}");
        document.getElementById("phone").value = "{{ $customer->phone_number }}";
        document.getElementById("phone_number").value = "{{ $customer->phone_number }}";
    }
});

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

// image
const customInput = document.getElementById("image");
const customUploadBox = document.getElementById("customUploadBox");
const customWrapper = document.getElementById("customUploadWrapper");

customInput.addEventListener("change", function () {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {

        // Buat elemen preview
        const preview = document.createElement("div");
        preview.className = "custom-preview-item";
        preview.innerHTML = `
            <button type="button" class="btn-remove" onclick="customRemoveImage()">×</button>
            <img src="${e.target.result}">
        `;

        // Ganti upload box dengan preview
        customWrapper.replaceChild(preview, customUploadBox);
        
        // customInput.value = ''
    };
    
    reader.readAsDataURL(file);
});

function customRemoveImage() {
    // Hapus preview
    const previewItem = document.querySelector(".custom-preview-item");
    previewItem.remove();
    
    // Tampilkan kembali upload box
    customWrapper.appendChild(customUploadBox);
    customInput.value = ''
}

function setImageProfile(){
    // Buat elemen preview
    const preview = document.createElement("div");
    preview.className = "custom-preview-item";
    preview.innerHTML = `
        <button type="button" class="btn-remove" onclick="customRemoveImage()">×</button>
        <img src="{{ ($customer->image ? asset('assets/image/upload/customer/'.$customer->image) : asset('assets/frontend/images/businesswoman-avatar.svg')) }}">
    `;

    // Ganti upload box dengan preview
    customWrapper.replaceChild(preview, customUploadBox);
}

function saveProfile(){
    const email_request = $('#email').val();

    if('{{ $customer->email }}' != email_request){
        var confirmText = 'Changes to your email will deactivate your account, and you will be asked to reactivate your account.';
    
        var confirmButtonText = 'Yes, update my email!';
        var confirmButtonColor = '#13c2c2';
        
        Swal.fire({
            title: 'Are you sure you want to set new email?',
            text: confirmText,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: confirmButtonColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmButtonText,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                saveProfileAct();
            }
        });
    }else{
        saveProfileAct()
    }
}

function saveProfileAct(){
    $('input.is-invalid').removeClass('is-invalid');
    $('#imageHelp').removeClass('d-block').addClass('d-none');

    $('.custom-loader-overlay').css('display', 'flex');

    $.ajax({
        url: "{{ route('profile.update-profile') }}",
        method: 'POST',
        data: new FormData(document.getElementById("form-profile")),
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
            console.log(response);
            if (response.success == true) {
                showToastr('toast-top-right', 'success', "Data berhasil disimpan")

                const email_request = $('#email').val();
                // if('{{ $customer->email }}' != email_request){
                //     setTimeout(() => {
                //         window.location.reload();
                //     }, 1000);
                // }
                window.location.reload();
            } else {
                showToastr('toast-top-right', 'error', "Terjadi kesalahan, silahkan ulangi kembali")
            }
        },
        error: function(xhr) {
            var res = xhr.responseJSON;
            if ($.isEmptyObject(res) == false) {
                console.log(res.errors);
                
                $.each(res.errors, function(key, value) {
                    let key_name = key
                    if(key == 'image'){
                        key_name = key.split('.')[0];
                        $('#' + key_name)
                            // .closest('#error')
                            .addClass('is-invalid');
                        $('#' + key_name + 'Help').text(value.join(', ')).removeClass('d-none').addClass('d-block')
                    }else{
                        $('#' + key)
                            // .closest('#error')
                            .addClass('is-invalid');
                        $('#' + key + 'Help').text(value.join(', '))
                    }
                    
                    console.log('error', key, value, key_name);
                    
                });
            }
                
            showToastr('toast-top-right', 'error', "Please check the form for errors")
        },
        complete:function(){
            $('.custom-loader-overlay').css('display', 'none')
        }
    });
}

function saveNewPassword(){
    // Confirm dialog based on action type
    var confirmText = 'Are you sure you want to set new password?';
    
    var confirmButtonText = 'Yes, set new password!';
    var confirmButtonColor = '#13c2c2';
    
    Swal.fire({
        title: 'Confirmation',
        text: confirmText,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: confirmButtonColor,
        cancelButtonColor: '#6c757d',
        confirmButtonText: confirmButtonText,
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('profile.update-password') }}",
                type: 'POST',
                data: $('#form-password').serialize(),
                beforeSend:function(){
                    $('input.is-invalid').removeClass('is-invalid');
                    $('.custom-loader-overlay').css('display', 'flex')
                },
                success: function(response) {
                    console.log('new password', response);
                    
                    if(response.success) {
                        $('#form-password')[0].reset();
                        // Show success toast notification
                        toastr.success(
                            'Password has been change successfully!',
                            'Success!'
                        );
                    } else {
                        if(response.status == 'validation'){
                            response.validation.forEach(item => {
                                $('#' + item.name).addClass('is-invalid');
                                $('#' + item.name + 'Help').text(item.value)
                            });
                        }
                        toastr.error(
                            response.message,
                            'Error!'
                        );
                    }
                },
                error: function(xhr) {
                    console.log('error', xhr);

                    var res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        console.log(res.errors);
                        
                        $.each(res.errors, function(key, value) {
                            let key_name = key
                            $('#' + key)
                                // .closest('#error')
                                .addClass('is-invalid');
                            $('#' + key + 'Help').text(value.join(', '))
                        });
                    }
                    
                    toastr.error(
                        'An error occurred while processing your request',
                        'Error!'
                    );
                },
                complete:function(){
                    $('.custom-loader-overlay').css('display', 'none')
                },
            });
        }
    });
};
</script>
@endsection