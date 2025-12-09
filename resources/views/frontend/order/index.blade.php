@extends('frontend.layouts.app')

@section('styles')
<style>
.list-product{
    width: 100%;
    height: 400px;
    overflow: auto;
}

@media (max-width: 540px) {
    .list-product{
        height: 450px;
    }
}

@media (min-width: 768px) {
    .list-product{
        height: 600px;
    }
}

@media (min-width: 1024px) {
    .list-product{
        height: 400px;
    }
}

/* .image-product-selected{
    width: 100%;
    height: 120px;
    object-fit: cover;
}


@media (max-width: 540px) {
    .image-product-selected{
        height: 200px;
    }
} */

</style>
@endsection

@section('content')
<section class="newsletter bg-light" style="background: url(images/pattern-bg.png) no-repeat;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 py-5 my-5">
          <div class="subscribe-header text-center pb-3">
            <h3 class="section-title text-uppercase">Order Form</h3>
            <span class="text-muted">Fill out the form and customize your order</span>
        </div>
          <form method="POST" id="form-data" class="d-flex flex-wrap gap-2">
            @csrf
            <input type="hidden" name="customer_id" id="customer_id" value="{{ (Auth::guard('customer')->user() ? Auth::guard('customer')->user()->id : '') }}">

            <h5 class="text-muted my-2" style="font-size: 17px;">Personal Data Section</h5>
            <input type="text" name="fullname" id="fullname" placeholder="Your fullname" class="form-control form-control-lg" required onkeydown="if(event.key === 'Enter') event.preventDefault();" value="{{ (Auth::guard('customer')->user() ? Auth::guard('customer')->user()->name : '') }}">
            <small id="fullnameHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
            
            <input type="email" name="email" id="email" placeholder="Your email addresss" class="form-control form-control-lg" required onkeydown="if(event.key === 'Enter') event.preventDefault();" value="{{ (Auth::guard('customer')->user() ? Auth::guard('customer')->user()->email : request()->email) }}">
            <small id="emailHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
            
            <input type="text" name="phone_number" id="phone_number" placeholder="628xxxxxxxx" class="form-control form-control-lg" required oninput="this.value = this.value.replace(/[^0-9]/g, '')" onkeydown="if(event.key === 'Enter') event.preventDefault();" value="{{ (Auth::guard('customer')->user() ? Auth::guard('customer')->user()->phone_number : '') }}">
            <small id="phone_numberHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
            
            <div class="w-100">
                <div class="row g-1">
                    <div class="col-6">
                        <input type="radio" class="btn-check" name="order_type" id="option_sample" value="SAMPLE" autocomplete="off" checked onchange="setOrderType('sample')">
                        <label class="btn btn-outline-dark w-100" for="option_sample">
                            Sample<br>
                            <small style="font-size: 13px;">(only 1pcs/product)</small>
                        </label>
                    </div>
                    <div class="col-6">
                        <input type="radio" class="btn-check" name="order_type" id="option_order" value="ORDER" autocomplete="off" onchange="setOrderType('order')">
                        <label class="btn btn-outline-dark w-100" for="option_order">
                            Order<br>
                            <smal style="font-size: 13px;">(Adjust your quantity)</small>
                        </label>
                    </div>
                </div>
                <small id="order_typeHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
            </div>
            
            <div class="p-0" style="width: 100% !important;display: flex;justify-content: space-between;align-items: center;">
                <h5 class="text-muted m-0" style="vertical-align: middle;font-size: 17px;">Product Section</h5>
                <a href="#modal-custom" class="btn btn-dark"><span class="mdi mdi-hanger"></span></a>
            </div>
            <input type="hidden" name="products_id" id="products_id" class="w-100">
            <small id="products_idHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
            
            <div class="w-100" id="product-selected">
                
            </div>
            {{-- <small id="size_optionsHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small>
            <small id="qty_optionsHelp" class="invalid-feedback form-text text-danger">Please provide a valid informations.</small> --}}

            <textarea name="notes" id="notes" cols="30" rows="7" class="form-control form-control-lg" placeholder="Notes"></textarea>
            <span class="text-muted my-2">Login for easy ordering process <a href="{{ route('login').(request()->email? '?email='.request()->email : '') }}">Login</a></span>
            <button type="button" onclick="submitOrder()" class="btn btn-dark btn-lg text-uppercase w-100">Make an order</button>
          </form>
        </div>
      </div>
    </div>
</section>

@section('modal_header_text', 'Product')
@section('modal_body')
    <div class="list-product w-100">
        <div class="row g-2">
            @foreach ($products as $product)
                @php
                    $image = $product->image;
                    if(str_contains($product->image, ',')){
                        $pisah_image = explode(',', $product->image);
                        $image = $pisah_image[0];
                    }
                @endphp
                {{-- <a href="#" onclick="setProduct({{ $product }})" class="col-6 col-md-3" title="Select This Product">
                    <div class="card rounded-0 border">
                        <img src="{{ ($image ? 'assets/image/upload/product/'.$image : 'https://via.assets.so/img.jpg?w=400&h=300&bg=e5e7eb&text=+&f=png') }}" alt="Image {{ $product->name }}" style="width: 100%;height: 170px;object-fit: cover;">
                        <p class="p-2 m-0 border-top text-dark fs-6">{{ $product->name }}</p>
                    </div>
                </a> --}}
                <a href="#" onclick="setProduct({{ $product }})" class="col-6 col-md-3">
                    <div class="card text-white border-0 position-relative" style="overflow:hidden;">
                        <img src="{{ ($image ? 'assets/image/upload/product/'.$image : 'https://via.assets.so/img.jpg?w=400&h=300&bg=e5e7eb&text=+&f=png') }}" class="card-img" alt="Image {{ $product->name }}" style="width: 100%;height: 280px;object-fit: cover;">

                        <!-- Overlay gradient -->
                        <div class="position-absolute bottom-0 start-0 w-100 p-3"
                            style="background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));">

                            <p class="mb-1 p-0" style="font-size: 0.7rem; opacity: 0.9;">{{ ($product->hasCategory ? $product->hasCategory->name : '') }}</p>
                            <h5 class="m-0 p-0" style="font-size: .95rem;">{{ $product->name }}</h5>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
@include('frontend.layouts.modal')

@endsection

@section('scripts')
<script>
$(document).ready(function(){
    if("{{ $order_type }}"){
        $('input[name="order_type"][value="{{ $order_type }}"]').prop('checked', true);
    }
    if("{{ $request_product }}"){
        setTimeout(() => {
            setProduct(@json($request_product), '{{ $request_product->id }}');
        }, 1500);
    }
});

function setProduct(product, id){
    const order_type = $('[name="order_type"]:checked').val()

    console.log('set product', product, order_type);
    const products_id = $('#products_id').val() ? $('#products_id').val() : [];

    setSelectedProductId(product.id, 'add')

    if(!products_id.includes(product.id)){
        let image = `https://via.assets.so/img.jpg?w=400&h=300&bg=e5e7eb&text=+&f=png`
        if(product.image){
            if(product.image.includes(',')){
                const pisah_image = product.image.split(',')
                image = `{{ asset('assets/image/upload/product') }}/`+pisah_image[0]
            }else{
                image = `{{ asset('assets/image/upload/product') }}/`+product.image
            }
        }
    
        const code = generateRandomCode(10);
        
        var html = `
            <div class="w-100 p-2 bg-white rounded mb-2" id="product-selected-${code}" style="position: relative;box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <a href="javascript:void(0)"
                    onclick="deleteProduct('${code}', '${product.id}')"
                    class="bg-danger text-light"
                    style="position:absolute;margin:auto;top: 8px;right: 8px;padding: 1px 4px;border-radius: 100%;">
                    <i class="mdi mdi-close"></i>
                </a>
                <div class="row g-3">
                    <div class="col-3 col-md-3 col-lg-3 align-content-center">
                        <center>
                            <img src="${image}" alt="Image ${product.name}" class="image-product-selected" style="width: 100%;height: 100%;object-fit:cover;">
                        </center>
                    </div>
                    <div class="col-9 col-md-9 col-lg-9 pt-2">
                        <input type="hidden" name="product_id[]" value="${product.id}">
                        <h5 class="m-0 p-0" style="font-size: 17px;">${product.name}</h5>
                        <p class="mb-2 p-0" style="font-size: 13px;">Category</p>
                        `;
    
                if(order_type == 'ORDER'){
                    if(product.size_qty){
                        // let index_options = 1;
                        product.size_qty.forEach((item, index_options) => {
                            html += `
                            <table class="w-100">
                            <tr>
                                <td class="d-flex justify-content-start" width="20">
                                    <div class="form-check me-2">
                                        <input class="form-check-input ms-0" type="checkbox" name="size_options[${product.id}][]" value="${item.size}" id="${product.id+'-'+item.size}" onchange="disabledQty('${product.id}', '${item.size}', this)">
                                        <label class="form-check-label text-dark" for="${product.id+'-'+item.size}" style="padding-left: 25px;font-size: 16px;">
                                        ${item.size}
                                        </label>
                                    </div>
                                </td>
                                <td>`
                                    if(item.qty){
                                        item.qty.forEach(qty => {
                                            html += `
                                            <input type="radio" class="btn-check qty-size-${product.id}-${item.size}" name="qty_options[${product.id}][${item.size}]" id="${product.id+'-'+item.size+'-'+qty}" value="${qty}" autocomplete="off" disabled>
                                            <label class="btn btn-outline-primary rounded-pill mb-1 qty-size-${item.size}" for="${product.id+'-'+item.size+'-'+qty}" disabled style="font-size: 13px;padding: 2px 3px;">${qty}</label>
                                            `
                                        });
                                    }
                            html += `</td>
                            </tr>
                            `
                            // index_options++;
                        });
                    }else{
                        html += `<tr><td colspan="2" class="text-center" style="font-size: 13px;">No Options</td></tr>`
                    }
                    html += `</table>`
                }else{
                    if(product.size_qty){
                        html += `<div class="w-100 d-flex">`
                        product.size_qty.forEach((item, index_options) => {
                            html += `
                            <span class="d-flex justify-content-start">
                                <div class="form-check me-3">
                                    <input class="form-check-input ms-0" type="radio" name="size_options[${product.id}]" value="${item.size}" id="${product.id+'-'+item.size}" onchange="disabledQty('${product.id}', '${item.size}', this)">
                                    <label class="form-check-label text-dark" for="${product.id+'-'+item.size}" style="padding-left: 25px;font-size: 16px;">
                                    ${item.size}
                                    </label>
                                </div>
                            </span>`
                        });
                        html += `</div>`
                    }else{
                        html += `<span lass="text-center" style="font-size: 13px;">No Options</span>`
                    }
                }
                html += `
                        <textarea name="product_notes[${product.id}]" id="" cols="30" rows="3" class="form-control mb-2 mt-2" placeholder="Notes" style="font-size: 13px;"></textarea>
                    </div>
                </div>
                
            </div>
        `
    
        $('#product-selected').append(html)
    }else{
        showToastr('toast-top-right', 'error', 'Product has been added')
    }
}

function setSelectedProductId(id, condition){
    const products_id = $('#products_id').val()
    let arr_product = (products_id ? products_id.split(',') : [])
    
    if(condition == 'add'){
        if(!arr_product.includes(id)){
            arr_product.push(id)
        }
    }else{
        if(arr_product.includes(id)){
            arr_product = arr_product.filter(item => item !== id);
        }
    }
    $('#products_id').val(arr_product.join(','))
}

function setOrderType(type){
    $('#products_id').val('')
    $('#product-selected').html('')
}

function disabledQty(id, size, evn){
    $('.qty-size-'+id+'-'+size).prop('disabled', !evn.checked)

    if(!evn.checked) $('input.qty-size-'+size).prop('checked', false)
}

function deleteProduct(code, id){
    $(`#product-selected-${code}`).remove()
    setSelectedProductId(id)
}

function generateRandomCode(length = 8) {
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  let result = '';
  const charactersLength = characters.length;

  for (let i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }

  return result;
}

function submitOrder(){
    $('input.is-invalid').removeClass('is-invalid');
    $('.custom-loader-overlay').css('display', 'flex')
    var postData = new FormData($('#form-data')[0]);
    $.ajax({
        url: "{{ route('order.process') }}",
        type: "POST",
        data: postData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {
            console.log(data)
            if(data.success){
                $('#form-data')[0].reset();
                $('#product-selected').html('')
                showToastr('toast-top-right', 'success', data.message)
            }else{
                showToastr('toast-top-right', 'error', data.message)
            }
        },
        error:function(xhr){
            console.log('error', xhr);
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
        },
    });
}
</script>
@endsection