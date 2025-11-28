@extends('backend.layouts.app')
@section('styles')
<style>
    .upload-box {
        border: 2px dashed #ccc;
        border-radius: 10px;
        height: 140px;
        cursor: pointer;
        transition: .2s;
    }
    .upload-box:hover {
        background-color: #f8f9fa;
    }
    .preview-item {
        position: relative;
        width: 140px;
        height: 140px;
        overflow: hidden;
        border-radius: 10px;
    }
    .preview-item img {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }
    .btn-remove {
        position: absolute;
        top: 3px;
        right: 3px;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        border: none;
        border-radius: 50%;
        width: 26px;
        height: 26px;
        text-align: center;
        line-height: 24px;
        cursor: pointer;
    }

    .custom-upload-box {
        border: 2px dashed #ccc;
        border-radius: 10px;
        height: 200px;
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

    /* .custom-btn-remove {
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
    } */
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <h5 class="card-header">Form Product</h5>
            <div class="card-body">
                <form class="w-100" action="{{ @$data->id ? route('product.update', @$data->id) : route('product.store') }}"
                    enctype="multipart/form-data" method="POST" id="formData">
                    @csrf
                    <input type="hidden" name="_method" value="{{ @$data->id ? 'PUT' : 'POST' }}">
                    <input type="hidden" name="id" value="{{ @$data->id ? $data->id : '' }}">

                    <div class="form-group">
                        <label>Cover</label>
                        <div class="w-100 mb-2">
                            <div class="container">
                                <div id="customUploadWrapper" class="d-flex flex-wrap gap-3">
                                    <div id="customUploadBox" class="custom-upload-box d-flex flex-column justify-content-center align-items-center w-100"
                                        onclick="document.getElementById('cover').click();">
                                        <i class="mdi mdi-image" style="font-size: 40px;color:#ccc;"></i>
                                        <span class="text-secondary">Unggah gambar</span>
                                    </div>
                                </div>

                                <input type="file" name="cover" id="cover" class="" accept="image/jpg,image/jpeg,image/png,image/webp" style="visibility: hidden;">
                            </div>
                        </div>
                        <small id="coverHelp" class="d-none form-text text-danger">Please provide a valid informations.</small>
                    </div>
                    <div class="form-group">
                        <label>Images</label>
                        <div class="w-100 mb-2">
                            <div class="container">
                                <div class="d-flex flex-wrap gap-3" id="previewContainer">
                                    <div class="upload-box d-flex justify-content-center align-items-center flex-column"
                                        id="uploadBox" onclick="document.getElementById('images').click();"
                                        style="width:140px">
                                        <span class="text-secondary">Unggah gambar</span>
                                    </div>
                                </div>

                                <input type="file" name="images[]" id="images" multiple accept="image/jpg,image/jpeg,image/png,image/webp" class="" style="visibility: hidden;">
                            </div>
                        </div>
                        <small id="imagesHelp" class="d-none form-text text-danger">Please provide a valid informations.</small>
                        <input type="hidden" name="old_images" id="old_images">
                    </div>
                    <div class="form-group">
                        <label>Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Pilih Category</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}" {{ $item->id == @$data->category_id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <small id="category_idHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                    </div>
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{ @$data ? $data->name : old('name') }}">
                        <small id="nameHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="description" rows="10" class="form-control" placeholder="Enter Description">{{ @$data ? $data->description : old('description') }}</textarea>
                        <small id="descriptionlHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                    </div>
                    <div class="form-group">
                        <label for="image">Size & Quantity Options</label>
                        
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-sm">Size <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm" name="size" id="size" placeholder="S/M/L/XL...">
                                            <small class="text-muted">Contoh : S/M/L/XL</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-sm">Quantity <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm" name="qty" id="qty" placeholder="10,20,30,40,50...">
                                            <small class="text-muted">Contoh : 10,20,30,40... (quantity diinput bersamaan, dipisah dengan koma tanpa spasi)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 align-content-start">
                                <button type="button" class="btn btn-sm btn-info w-100 mt-4" onclick="addSizeQtyOptions('create')"><i class="mdi mdi-plus"></i> Tambah</button>
                            </div>
                        </div>

                        <small id="size_optionsHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>

                        <div class="row mt-4" id="size_quantity_options"></div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="active" id="active" {{ @$data && $data->active ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">
                        Active
                        </label>
                    </div>

                    <div class="mt-3 d-flex justify-content-end">
                        <button type="button" class="btn btn-info" onclick="simpan()"><i class="mdi mdi-content-save-check-outline"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let lastImages = [];
let data = null;
if('{{ @$data }}'){
    data = @json(@$data ? $data : null)
}
// console.log('data', data, '{{ @$data }}');

$(document).ready(function(){
    $('#description').summernote({
        height: 400,
        callbacks: {
            onImageUpload: function(files) {
                uploadImagesSummernote(files, '#description', 'product/summernote');
            },
            onChange: function(contents, $editable) {
                const currentImages = extractImagesFromHtml(contents);

                // Deteksi gambar yang dihapus
                const deletedImages = lastImages.filter(src => !currentImages.includes(src));
                if (deletedImages.length > 0) {
                    deletedImages.forEach((url) => {
                        deleteImageSummernote(url, 'product/summernote');
                    });
                }

                lastImages = currentImages;
            }
        }
    });

    if(data) loadDataEdit(data)
})

// cover
const customInput = document.getElementById("cover");
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



// images
const images = document.getElementById('images');
const previewContainer = document.getElementById('previewContainer');
const uploadBox = document.getElementById('uploadBox');

let selectedFiles = [];

images.addEventListener('change', function (e) {
    let files = Array.from(e.target.files);

    files.forEach((file, index) => {
        selectedFiles.push(file);
        showPreview(file, index);
    });

    // images.value = "";
});

// Tampilkan preview
function showPreview(file, index) {
    let reader = new FileReader();
    reader.onload = function (e) {

        // buat container gambar
        let div = document.createElement('div');
        div.classList.add("preview-item");

        div.innerHTML = `
            <button type="button" class="btn-remove" onclick="removeImage(this, ${index})">×</button>
            <img src="${e.target.result}">
        `;

        // insert sebelum box upload
        previewContainer.insertBefore(div, uploadBox);
    };

    reader.readAsDataURL(file);
}

// Hapus gambar
function removeImage(btn, removeIndex, imageEdit = null) {
    let item = btn.parentElement;
    let index = Array.from(previewContainer.children).indexOf(item);
    
    // kurangi index karena uploadBox ada di akhir
    if (index > -1) {
        console.log('index > -1', index);
        
        // if(imageEdit == null){
            selectedFiles.splice(index, 1); 
        // }
    }
    
    // hapus image dalam input
    const dt = new DataTransfer();
    
    [...images.files].forEach((file, index) => {
        if(imageEdit == null){
            if (index !== removeIndex) {
                dt.items.add(file);
            }
        }else{
            dt.items.add(file);
        }
    });
    
    images.files = dt.files;

    item.remove();

    if(imageEdit) removeImageEdit(imageEdit)
}

function removeImageEdit(imagename){
    const list_image = ($('#old_images').val() ? $('#old_images').val().split(',') : []);
    
    const new_list_image = list_image.filter(item => item !== imagename);

    $('#old_images').val(new_list_image.join(','))
}

function randomCode(length = 8) {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    for (let i = 0; i < length; i++) {
        result += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return result;
}

function addSizeQtyOptions(condition, size = null, qty = null){
    if(condition == 'create'){
        size = $('#size').val()
        qty = $('#qty').val()
    }
    const code = randomCode(10);

    if(!size || !qty){
        showToastr('toast-top-right', 'error', "Masukan size dan quantity option dengan benar!")
    }else{
        let split_qty = null;
        if(condition == 'create'){
            split_qty = qty.split(',');
        }else{
            split_qty = qty;
        }

        var html = `
            <div class="col-12 col-md-4" id="size-qty-option-${code}">
                <div class="card card-sm" style="border: 2px dashed #ccc;border-radius: 10px;">
                    <button type="button" class="btn-remove" style="z-index: 2;" onclick="deleteSizeQtyOptions('${code}')">x</button>
                    <div class="card-body p-3">
                        <div class="row g-3">
                            <div class="col-auto">
                                <h2 class="bg-dark text-white avatar py-2 px-3 h-100 align-content-center">${size}</h2>
                            </div>
                            <div class="col">
                                <input type="hidden" name="size_options[]" id="size_options" value="${size}">
                                <input type="hidden" name="qty_options[]" id="qty_options" value="${qty}">
                                <div class="text-secondary">
                                    <div class="row g-1">`

                                        if(split_qty.length){
                                            split_qty.forEach(qty_item => {
                                                if(qty_item){
                                                    html += `
                                                        <div class="col-3 col-md-3">
                                                            <div class="card mb-0 text-sm text-center w-100 py-2">${qty_item}</div>
                                                        </div>
                                                    `
                                                }
                                            });
                                        }
                                        
                            html += `</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `

        $('#size_quantity_options').append(html)
        $('#size').val('')
        $('#qty').val('')
    }
}

function deleteSizeQtyOptions(code){
    $('#size-qty-option-'+code).remove()
}

function loadDataEdit(){
    $('.custom-loader-overlay').css('display', 'flex')

    if(data.cover){
        // Buat elemen preview
        const preview = document.createElement("div");
        preview.className = "custom-preview-item";
        preview.innerHTML = `
            <button type="button" class="btn-remove" onclick="customRemoveImage()">×</button>
            <img src="{{ asset('assets/image/upload/product') }}/${data.cover}">
        `;

        // Ganti upload box dengan preview
        customWrapper.replaceChild(preview, customUploadBox);
    }

    if(data.images){
        data.images.forEach((image, index) => {
            // buat container gambar
            let div = document.createElement('div');
            div.classList.add("preview-item");

            div.innerHTML = `
                <button type="button" class="btn-remove" onclick="removeImage(this, ${index}, '${image}')">×</button>
                <img src="{{ asset('assets/image/upload/product') }}/${image}">
            `;

            // insert sebelum box upload
            previewContainer.insertBefore(div, uploadBox);
        });

        $('#old_images').val(data.image)
    }

    if(data.size_qty_option_decode){
        data.size_qty_option_decode.forEach(size_qty => {
            addSizeQtyOptions('edit', size_qty.size, size_qty.qty)
        });
    }

    $('.custom-loader-overlay').css('display', 'none')
}

function simpan(){
    $('.custom-loader-overlay').css('display', 'flex')

    var form = $('#formData'),
        url = form.attr('action');
    // Clear Validation
    form.find('.is-invalid').removeClass('is-invalid');
    form.find('.form-group').removeClass('has-error');

    $('#coverHelp').removeClass('d-block').addClass('d-none')
    $('#imagesHelp').removeClass('d-block').addClass('d-none')

    let formData = new FormData(document.getElementById("formData"))
    if(selectedFiles){
        selectedFiles.forEach(file => {
            formData.append('list_images[]', file);
        });
    }else{
        formData.append('list_images[]', '')
    }

    console.log(selectedFiles, formData);
    

    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
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
                    let key_name = key
                    if(key.includes('.') || key == 'cover' || key == 'size_options'){
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
</script>
@include('backend.universal.summernote')
@endsection