@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <h5 class="card-header">Form Company Profile</h5>
            <div class="card-body">
                <form class="w-100" action="{{ route('company-profile.update', @$data->id) }}"
                    enctype="multipart/form-data" method="POST" id="formData">
                    @csrf
                    <input type="hidden" name="_method" value="{{ 'PUT' }}">
                    <input type="hidden" name="id" value="{{ $data->id }}">

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Profile</button>
                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
                            <button class="nav-link" id="nav-policy-tab" data-bs-toggle="tab" data-bs-target="#nav-policy" type="button" role="tab" aria-controls="nav-policy" aria-selected="false">Policy</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade py-4 px-2 show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{ @$data ? $data->name : old('name') }}">
                                <small id="nameHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                            </div>
                            <div class="form-group">
                                <label>Profile</label>
                                <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ @$data ? $data->description : old('description') }}</textarea>
                                <small id="descriptionHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control">{{ @$data ? $data->alamat : old('alamat') }}</textarea>
                                <small id="alamatHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                            </div>
                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" class="form-control" name="logo" id="logo">
                                <small id="logoHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>

                                @if (@$data && $data->logo)
                                    <img src="{{ asset('assets/image/upload/logo/'.$data->logo) }}" alt="Logo" class="mt-2" style="width: 100px;">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="pavicon">Pavicon</label>
                                <input type="file" class="form-control" name="pavicon" id="pavicon">
                                <small id="paviconHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>

                                @if (@$data && $data->pavicon)
                                    <img src="{{ asset('assets/image/upload/pavicon/'.$data->pavicon) }}" alt="Pavicon" class="mt-2" style="width: 100px;">
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade py-4 px-2" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="{{ @$data ? $data->email : old('email') }}">
                                        <small id="emailHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Phone Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-phone-outline"></i></span>
                                        <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter Phone Number" oninput="this.value=this.value.replace(/\D/g,'')" value="{{ @$data ? $data->phone_number : old('phone_number') }}">
                                        <small id="phone_numberHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Whatsapp</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                                        <input type="text" class="form-control" name="whatsapp" id="whatsapp" placeholder="628xxxxxxxxxx" oninput="this.value=this.value.replace(/\D/g,'')" value="{{ @$data ? $data->whatsapp : old('whatsapp') }}">
                                        <small id="whatsappHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>IMessage</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-chat-outline"></i></span>
                                        <input type="text" class="form-control" name="imessage" id="imessage" placeholder="628xxxxxxxxxx" oninput="this.value=this.value.replace(/\D/g,'')" value="{{ @$data ? $data->imessage : old('imessage') }}">
                                        <small id="imessageHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Facebook</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                                        <input type="text" class="form-control" name="facebook" id="facebook" placeholder="Username Facebook" value="{{ @$data ? $data->facebook : old('facebook') }}">
                                        <small id="facebookHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Instagram</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                                        <input type="text" class="form-control" name="instagram" id="instagram" placeholder="Username Instagram" value="{{ @$data ? $data->instagram : old('instagram') }}">
                                        <small id="instagramHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Twitter</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-twitter-x"></i></span>
                                        <input type="text" class="form-control" name="twitter" id="twitter" placeholder="Username Twitter" value="{{ @$data ? $data->twitter : old('twitter') }}">
                                        <small id="twitterHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Youtube</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-youtube"></i></span>
                                        <input type="text" class="form-control" name="youtube" id="youtube" placeholder="Username Youtube" value="{{ @$data ? $data->youtube : old('youtube') }}">
                                        <small id="youtubeHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tiktok</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-tiktok"></i></span>
                                        <input type="text" class="form-control" name="tiktok" id="tiktok" placeholder="Username Tiktok" value="{{ @$data ? $data->tiktok : old('tiktok') }}">
                                        <small id="tiktokHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Embed Maps <i class="mdi mdi-help-circle-outline" data-bs-toggle="modal" data-bs-target="#modal-info-maps"></i></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-google-maps"></i></span>
                                        <input type="text" class="form-control" name="maps" id="maps" placeholder="<iframe src=..." value="{{ @$data ? $data->maps : old('maps') }}">
                                        <small id="mapsHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade py-4 px-2" id="nav-policy" role="tabpanel" aria-labelledby="nav-policy-tab">
                            <div class="form-group">
                                <label>Privacy Policy</label>
                                <textarea name="privacy" id="privacy" cols="30" rows="10" class="form-control">{{ @$data ? $data->privacy : old('privacy') }}</textarea>
                                <small id="privacyHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                            </div>
                            <div class="form-group">
                                <label>Refund Policy</label>
                                <textarea name="refund" id="refund" cols="30" rows="10" class="form-control">{{ @$data ? $data->refund : old('refund') }}</textarea>
                                <small id="refundHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                            </div>
                            <div class="form-group">
                                <label>Shipping Policy</label>
                                <textarea name="shipping" id="shipping" cols="30" rows="10" class="form-control">{{ @$data ? $data->shipping : old('shipping') }}</textarea>
                                <small id="shippingHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-info" onclick="simpan()"><i class="mdi mdi-content-save-check-outline"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-info-maps" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="font-size: 15px;">Embed Maps</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="{{ asset('assets/image/maps-embed.png') }}" alt="Contoh Embed Maps" style="width: 100%;height: 100%;">
        <h5 class="mt-4">Cara membuat link embed maps</h5>
        <ul>
            <li>Masuk ke <a href="https://www.google.com/maps" target="_blank">Google Maps</a> dan cari lokasi.</li>
            <li>Klik tombol "Bagikan"</li>
            <li>Pilih tab "Sematkan peta"</li>
            <li>Salin link yang tertera</li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
let lastImagesDesc = [];
let lastImagesPrivacy = [];
let lastImagesRefund = [];
let lastImagesShipping = [];
$(document).ready(function(){
    $('#description').summernote({
        height: 400,
        callbacks: {
            onImageUpload: function(files) {
                uploadImagesSummernote(files, '#description', 'company_profile/summernote');
            },
            onChange: function(contents, $editable) {
                const currentImages = extractImagesFromHtml(contents);

                // Deteksi gambar yang dihapus
                const deletedImages = lastImagesDesc.filter(src => !currentImages.includes(src));
                if (deletedImages.length > 0) {
                    deletedImages.forEach((url) => {
                        deleteImageSummernote(url, 'company_profile/summernote');
                    });
                }

                lastImagesDesc = currentImages;
            }
        }
    });
    $('#privacy').summernote({
        height: 400,
        callbacks: {
            onImageUpload: function(files) {
                uploadImagesSummernote(files, '#privacy', 'company_profile/summernote');
            },
            onChange: function(contents, $editable) {
                const currentImages = extractImagesFromHtml(contents);

                // Deteksi gambar yang dihapus
                const deletedImages = lastImagesPrivacy.filter(src => !currentImages.includes(src));
                if (deletedImages.length > 0) {
                    deletedImages.forEach((url) => {
                        deleteImageSummernote(url, 'company_profile/summernote');
                    });
                }

                lastImagesPrivacy = currentImages;
            }
        }
    });
    $('#refund').summernote({
        height: 400,
        callbacks: {
            onImageUpload: function(files) {
                uploadImagesSummernote(files, '#refund', 'company_profile/summernote');
            },
            onChange: function(contents, $editable) {
                const currentImages = extractImagesFromHtml(contents);

                // Deteksi gambar yang dihapus
                const deletedImages = lastImagesRefund.filter(src => !currentImages.includes(src));
                if (deletedImages.length > 0) {
                    deletedImages.forEach((url) => {
                        deleteImageSummernote(url, 'company_profile/summernote');
                    });
                }

                lastImagesRefund = currentImages;
            }
        }
    });
    $('#shipping').summernote({
        height: 400,
        callbacks: {
            onImageUpload: function(files) {
                uploadImagesSummernote(files, '#shipping', 'company_profile/summernote');
            },
            onChange: function(contents, $editable) {
                const currentImages = extractImagesFromHtml(contents);

                // Deteksi gambar yang dihapus
                const deletedImages = lastImagesShipping.filter(src => !currentImages.includes(src));
                if (deletedImages.length > 0) {
                    deletedImages.forEach((url) => {
                        deleteImageSummernote(url, 'company_profile/summernote');
                    });
                }

                lastImagesShipping = currentImages;
            }
        }
    });
})

function simpan(){
    $('.custom-loader-overlay').css('display', 'flex')

    var form = $('#formData'),
        url = form.attr('action');
    // Clear Validation
    form.find('.is-invalid').removeClass('is-invalid');
    form.find('.form-group').removeClass('has-error');

    $.ajax({
        url: url,
        method: 'POST',
        data: new FormData(document.getElementById("formData")),
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
            console.log(response);
            if (response.success == true) {
                showToastr('toast-top-right', 'success', "Data berhasil disimpan")
                window.location.reload()
            } else {
                showToastr('toast-top-right', 'error', "Terjadi kesalahan, silahkan ulangi kembali")
            }
        },
        error: function(xhr) {
            var res = xhr.responseJSON;
            if ($.isEmptyObject(res) == false) {
                console.log(res.errors);
                
                $.each(res.errors, function(key, value) {
                    $('#' + key)
                        // .closest('#error')
                        .addClass('is-invalid');
                    $('#' + key + 'Help').text(value.join(', '))
                });
            }
                
            showToastr('toast-top-right', 'error', "Please check the form for errors")
        },
        complete:function(){
            $('.custom-loader-overlay').css('display', 'none')
        }
    });
}
</script>
@include('backend.universal.summernote')
@endsection