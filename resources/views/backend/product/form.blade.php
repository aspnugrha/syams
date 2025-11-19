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
                                        onclick="document.getElementById('customFileInput').click();">
                                        <i class="mdi mdi-image" style="font-size: 40px;color:#ccc;"></i>
                                        <span class="text-secondary">Unggah gambar</span>
                                    </div>
                                </div>

                                <input type="file" id="customFileInput" class="d-none" accept="image/*">
                            </div>
                            {{-- <img src="https://via.assets.so/img.jpg?w=600&h=300&pattern=dots&bg=e5e7eb&text=cover&f=png" alt="Cover Default" style="width: 100%;height: 350px;object-fit: cover;"> --}}
                        </div>
                        {{-- <input type="file" class="form-control" name="cover" id="cover" accept="image/*"> --}}
                        <small id="nameHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                    </div>
                    <div class="form-group">
                        <label>Images</label>
                        <div class="w-100 mb-2">
                            <div class="container">
                                <div class="d-flex flex-wrap gap-3" id="previewContainer">
                                    <div class="upload-box d-flex justify-content-center align-items-center flex-column"
                                        id="uploadBox" onclick="document.getElementById('fileInput').click();"
                                        style="width:140px">
                                        <span class="text-secondary">Unggah gambar</span>
                                    </div>
                                </div>

                                <input type="file" id="fileInput" multiple accept="image/*" class="d-none">
                            </div>
                        </div>
                        <small id="nameHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                    </div>
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{ @$data ? $data->name : old('name') }}">
                        <small id="nameHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="description" rows="10" class="form-control" placeholder="Enter Description"></textarea>
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
                                            <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Enter Name" value="{{ @$data ? $data->name : old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-sm">Quantity <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Enter Name" value="{{ @$data ? $data->name : old('name') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 align-content-center">
                                <button type="button" class="btn btn-sm btn-info w-100"><i class="mdi mdi-plus"></i> Tambah</button>
                            </div>
                        </div>

                        <small id="coverHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>

                        <div class="row mt-4">
                            @for($i=0;$i<5;$i++)
                            <div class="col-12 col-md-4">
                                <div class="card card-sm" style="border: 2px dashed #ccc;border-radius: 10px;">
                                    <button type="button" class="btn-remove" style="z-index: 2;">x</button>
                                    <div class="card-body p-3">
                                        <div class="row g-3">
                                            <div class="col-auto">
                                                <h2 class="bg-primary text-white avatar py-2 px-3 h-100 align-content-center">S</h2>
                                            </div>
                                            <div class="col">
                                                {{-- <div class="font-weight-medium">Quantity</div> --}}
                                                <div class="text-secondary">
                                                    <div class="row g-1">
                                                        <div class="col-3 col-md-3">
                                                            <div class="card mb-0 text-sm text-center w-100 py-2">10</div>
                                                        </div>
                                                        <div class="col-3 col-md-3">
                                                            <div class="card mb-0 text-sm text-center w-100 py-2">20</div>
                                                        </div>
                                                        <div class="col-3 col-md-3">
                                                            <div class="card mb-0 text-sm text-center w-100 py-2">40</div>
                                                        </div>
                                                        <div class="col-3 col-md-3">
                                                            <div class="card mb-0 text-sm text-center w-100 py-2">60</div>
                                                        </div>
                                                        <div class="col-3 col-md-3">
                                                            <div class="card mb-0 text-sm text-center w-100 py-2">80</div>
                                                        </div>
                                                        <div class="col-3 col-md-3">
                                                            <div class="card mb-0 text-sm text-center w-100 py-2">100</div>
                                                        </div>
                                                        <div class="col-3 col-md-3">
                                                            <div class="card mb-0 text-sm text-center w-100 py-2">150</div>
                                                        </div>
                                                        <div class="col-3 col-md-3">
                                                            <div class="card mb-0 text-sm text-center w-100 py-2">2300</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="active" id="active" {{ @$data && $data->active ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">
                        Active
                        </label>
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
})

// cover
const customInput = document.getElementById("customFileInput");
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
            <button class="btn-remove" onclick="customRemoveImage()">×</button>
            <img src="${e.target.result}">
        `;

        // Ganti upload box dengan preview
        customWrapper.replaceChild(preview, customUploadBox);
        
        customInput.value = ''
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
const fileInput = document.getElementById('fileInput');
const previewContainer = document.getElementById('previewContainer');
const uploadBox = document.getElementById('uploadBox');

let selectedFiles = [];

fileInput.addEventListener('change', function (e) {
    let files = Array.from(e.target.files);

    files.forEach(file => {
        selectedFiles.push(file);
        showPreview(file);
    });

    fileInput.value = "";
});

// Tampilkan preview
function showPreview(file) {
    let reader = new FileReader();
    reader.onload = function (e) {

        // buat container gambar
        let div = document.createElement('div');
        div.classList.add("preview-item");

        div.innerHTML = `
            <button class="btn-remove" onclick="removeImage(this)">×</button>
            <img src="${e.target.result}">
        `;

        // insert sebelum box upload
        previewContainer.insertBefore(div, uploadBox);
    };

    reader.readAsDataURL(file);
}

// Hapus gambar
function removeImage(btn) {
    let item = btn.parentElement;
    let index = Array.from(previewContainer.children).indexOf(item);

    // kurangi index karena uploadBox ada di akhir
    if (index > -1) {
        selectedFiles.splice(index, 1); 
    }

    item.remove();
}
</script>
@include('backend.universal.summernote')
@endsection