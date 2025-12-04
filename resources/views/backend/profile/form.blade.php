@extends('backend.layouts.app')
@section('styles')
<style>
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
<div class="row">
    <div class="col-12 col-md-7">
        <div class="card">
            <h5 class="card-header"><i class="mdi mdi-account-cog fs-4"></i> Edit Profile</h5>
            <div class="card-body">
                <form class="w-100" action="{{ route('paneladmin.profile.update-profile') }}"
                    enctype="multipart/form-data" method="POST" id="formProfile">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">

                    <div class="col-12 col-md-12">
                        <label class="mb-2">Image Profile</label>
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
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{ @$data ? $data->name : old('name') }}">
                        <small id="nameHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                    </div>
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="{{ @$data ? $data->email : old('email') }}">
                        <small id="emailHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter Phone Number" value="{{ @$data ? $data->phone_number : old('phone_number') }}">
                        <small id="phone_numberHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                    </div>

                    <div class="mt-3 d-flex justify-content-end">
                        <button type="button" class="btn btn-info" onclick="saveProfile()"><i class="mdi mdi-content-save-check-outline"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-5">
        <div class="card">
            <h5 class="card-header"><i class="mdi mdi-lock-reset fs-4"></i> Set New Password</h5>
            <div class="card-body">
                <form class="w-100" action="{{ route('paneladmin.profile.set-new-password') }}"
                    enctype="multipart/form-data" method="POST" id="formPassword">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">

                    <div class="form-group">
                        <label>Password Lama <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Enter Old Password">
                        <small id="old_passwordHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                    </div>
                    <div class="form-group">
                        <label>Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter New Password">
                        <small id="new_passwordHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" placeholder="Enter Confirm New Password">
                        <small id="confirm_new_passwordHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                    </div>

                    <div class="mt-3 d-flex justify-content-end">
                        <button type="button" class="btn btn-info" onclick="setNewPassword()"><i class="mdi mdi-content-save-check-outline"></i> Set New Password</button>
                    </div>
                </form>
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

    if("{{ $data->image }}"){
        setImageProfile()
    }
})


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
        <img src="{{ ($data->image ? asset('assets/image/upload/user/'.$data->image) : asset('assets/frontend/images/businesswoman-avatar.svg')) }}">
    `;

    // Ganti upload box dengan preview
    customWrapper.replaceChild(preview, customUploadBox);
}

function saveProfile(){
    const email_request = $('#email').val();

    if('{{ $data->email }}' != email_request){
        var confirmText = 'Perubahan pada email akan membuat akun anda tidak aktif, dan anda akan diminta aktivasi akun kembali.';
    
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
        url: "{{ route('paneladmin.profile.update-profile') }}",
        method: 'POST',
        data: new FormData(document.getElementById("formProfile")),
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
            console.log(response);
            if (response.success == true) {
                showToastr('toast-top-right', 'success', "Data berhasil disimpan")
                
                const email_request = $('#email').val();
                if('{{ $data->email }}' != email_request){
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
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

function setNewPassword(){
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
                url: "{{ route('paneladmin.profile.set-new-password') }}",
                type: 'POST',
                data: $('#formPassword').serialize(),
                beforeSend:function(){
                    $('input.is-invalid').removeClass('is-invalid');
                    $('.custom-loader-overlay').css('display', 'flex')
                },
                success: function(response) {
                    console.log('new password', response);
                    
                    if(response.success) {
                        $('#formPassword')[0].reset();
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