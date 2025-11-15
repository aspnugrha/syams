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

.image-product-selected{
    width: 100%;
    height: 120px;
    object-fit: cover;
}


@media (max-width: 540px) {
    .image-product-selected{
        height: 200px;
    }
}

</style>
@endsection

@section('content')
<section class="newsletter bg-light border-bottom" style="background: url(images/pattern-bg.png) no-repeat;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 py-5 my-5">
          <div class="subscribe-header text-center pb-3">
            <h3 class="section-title text-uppercase">Order Form</h3>
            <span class="text-muted">Fill out the form and customize your order</span>
        </div>
          <form method="POST" id="form-data" class="d-flex flex-wrap gap-2">
            @csrf
            <span class="text-muted my-2">Personal Data Section</span>
            <input type="text" name="fullname" placeholder="Your Fullname" class="form-control form-control-lg" required value="" onkeydown="if(event.key === 'Enter') event.preventDefault();">
            <input type="email" name="email" placeholder="Your Email Addresss" class="form-control form-control-lg" required value="{{ request()->email }}" onkeydown="if(event.key === 'Enter') event.preventDefault();">
            <input type="text" name="phone_number" placeholder="628xxxxxxxx" class="form-control form-control-lg" required value="" oninput="this.value = this.value.replace(/[^0-9]/g, '')" onkeydown="if(event.key === 'Enter') event.preventDefault();">
            
            <input type="text" name="products_id" id="products_id" class="w-100">

            <div class="p-0 my-2" style="width: 100% !important;display: flex;justify-content: space-between;align-items: center;">
                <p class="text-muted m-0" style="vertical-align: middle;">Product Section</p>
                <a href="#modal-custom" class="btn btn-dark"><span class="mdi mdi-hanger"></span></a>
            </div>

            <div class="w-100 border mb-2" id="product-selected">
                
            </div>

            <textarea name="notes" id="notes" cols="30" rows="10" class="form-control form-control-lg" placeholder="Notes"></textarea>
            <span class="text-muted my-2">Login for easy ordering process <a href="{{ route('login').(request()->email? '?email='.request()->email : '') }}">Login</a></span>
            <button type="button" onclick="submitOrder()" class="btn btn-dark btn-lg text-uppercase w-100">Make an order</button>
          </form>
        </div>
      </div>
    </div>
</section>

@section('modal_header_text', 'Product')
@section('modal_body')
    <div class="list-product">
        <div class="row g-0">
            @foreach ($products as $product)
                @php
                    $image = $product->image;
                    if(str_contains($product->image, ',')){
                        $pisah_image = explode(',', $product->image);
                        $image = $pisah_image[0];
                    }
                @endphp
                <a href="#" onclick="setProduct({{ $product }})" class="col-6 col-md-3" title="Select This Product">
                    <div class="card rounded-0 border">
                        <img src="{{ ($image ? 'assets/image/upload/product/'.$image : 'https://via.assets.so/img.jpg?w=400&h=300&bg=e5e7eb&text=+&f=png') }}" alt="Image {{ $product->name }}" style="width: 100%;height: 170px;object-fit: cover;">
                        <p class="p-2 m-0 border-top text-dark fs-6">{{ $product->name }}</p>
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
function setProduct(product, id){
    console.log(product);
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
            <div class="w-100 p-3" id="product-selected-${code}">
                <div class="row">
                    <div class="col-12 col-md-3 col-lg-2">
                        <img src="${image}" alt="Image ${product.name}" class="image-product-selected">
                        <span class="py-2 fs-6">${product.name}</span>
                    </div>
                    <div class="col-12 col-md-9 col-lg-10">
                        <table class="w-100">`;
    
        if(product.size_qty){
            let index_options = 1;
            product.size_qty.forEach(item => {
                html += `
                <tr>
                    <td class="d-flex justify-content-start">
                        <div class="form-check me-2">
                            <input class="form-check-input ms-0" type="checkbox" value="" id="${product.id+'-'+item.size}" onchange="disabledQty('${item.size}', this)">
                            <label class="form-check-label text-dark" for="${product.id+'-'+item.size}" style="padding-left: 25px;">
                            ${item.size}
                            </label>
                        </div>
                    </td>
                    <td>`
                        if(item.qty){
                            item.qty.forEach(qty => {
                                html += `
                                <input type="radio" class="btn-check qty-size-${item.size}" name="qty_${index_options}" id="${product.id+'-'+item.size+'-'+qty}" autocomplete="off" disabled>
                                <label class="btn btn-outline-primary mb-1 qty-size-${item.size}" for="${product.id+'-'+item.size+'-'+qty}" disabled>${qty}</label>
                                `
                            });
                        }
                html += `</td>
                </tr>
                `
                index_options++;
            });
        }else{
            html += `<tr><td colspan="2" class="text-center">No Options<td></tr>`
        }
                html += `</table>
                        <textarea name="" id="" cols="30" rows="3" class="form-control mb-2 mt-2" placeholder="Notes"></textarea>
                    </div>
                </div>
                <button type="button" onclick="deleteProduct('${code}', '${product.id}')" class="btn btn-danger"><i class="mdi mdi-close"></i> Hapus</button>
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

function disabledQty(size, evn){
    $('.qty-size-'+size).prop('disabled', !evn.checked)

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
        },
        error:function(res){
            console.log('error', res);
            
        }
    });
}
</script>
@endsection