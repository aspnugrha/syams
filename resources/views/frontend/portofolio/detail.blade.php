@extends('frontend.layouts.app')

@section('content')
<img class="responsive-img" src="{{ asset($product->cover ? 'assets/image/upload/product/'.$product->cover : 'https://via.assets.so/img.jpg?w=400&h=300&bg=e5e7eb&text=+&f=png') }}" alt="Cover Product" style="width: 100%;height: 100vh;object-fit: cover;">

{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

<style>
    .thumb-img {
        cursor: pointer;
        border: 2px solid transparent;
        border-radius: 4px;
    }
    .thumb-img.active {
        border-color: #212529;
    }
</style>

<div class="container mt-4">
  <div class="row">
    <div class="col-5 col-md-5">
      <div id="productSlider" class="carousel slide mb-3" data-bs-ride="carousel">
          <div class="carousel-inner">
              @foreach (explode(',', $product->image) as $index => $item)
              <div class="carousel-item {{ !$index ? 'active' : '' }}">
                  <img src="{{ asset('assets/image/upload/product/'.$item) }}" class="d-block w-100">
              </div>
              @endforeach
          </div>
      
          <!-- Controls -->
          <button class="carousel-control-prev" type="button" data-bs-target="#productSlider" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#productSlider" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
          </button>
      </div>
      
      <!-- Thumbnail -->
      <div class="d-flex gap-2 justify-content-center">
        @foreach (explode(',', $product->image) as $index_thumb => $item)
          <img src="{{ asset('assets/image/upload/product/'.$item) }}" class="thumb-img {{ !$index_thumb ? 'active' : '' }}" width="55" data-bs-target="#productSlider" data-bs-slide-to="{{ $index_thumb }}">
        @endforeach
      </div>
    </div>
    <div class="col-7 col-md-7">
      <small class="text-muted">{{ ($product->hasCategory ? $product->hasCategory->name : '') }}</small>
      <h4>{{ $product->name }}</h4>

      <button class="btn btn-default" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="border: 1px solid #ddd;">
        Size & Quantity Product
      </button>
      <div class="collapse mt-2" id="collapseExample">
        <table class="w-100 table table-bordered">
          <tr>
            <td>Size Options</td>
            <td>Quantity Options</td>
          </tr>
          @php
              $size_qty = json_decode($product->size_qty_options);
          @endphp
          @if ($size_qty)
              @foreach ($size_qty as $item)
              <tr>
                <td>{{ $item->size }}</td>
                <td>
                  <div class="d-flex gap-2">
                    @foreach ($item->qty as $item)
                    <span class="size-badge-dark">{{ $item }}</span>
                    @endforeach
                  </div>
                </td>
              </tr>
              @endforeach
          @endif
        </table>
      </div>

      <article class="my-3">{!! $product->description !!}</article>

      <a href="#" class="btn btn-dark text-uppercase mt-3"><i class="ti ti-hand-open"></i> Sample</a>
      <a href="#" class="btn btn-dark text-uppercase mt-3"><i class="ti ti-shopping-cart"></i> Order</a>

    </div>
  </div>
</div>


{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}

<script>
    // update active border on click
    document.querySelectorAll('.thumb-img').forEach((el, index) => {
        el.addEventListener('click', () => {
            document.querySelectorAll('.thumb-img').forEach(img => img.classList.remove('active'));
            el.classList.add('active');
        });
    });

    // update active thumbnail when slider changed
    const slider = document.querySelector('#productSlider');
    slider.addEventListener('slid.bs.carousel', function (event) {
        let index = event.to;
        document.querySelectorAll('.thumb-img').forEach(img => img.classList.remove('active'));
        document.querySelectorAll('.thumb-img')[index].classList.add('active');
    });
</script>


{{-- @php
    $arr_image = [$product->image];
    if(str_contains($product->image, ',')){
        $arr_image = explode(',', $product->image);
    }
@endphp
<img class="border-bottom" src="{{ asset($product->cover ? 'assets/image/upload/product/'.$product->cover : 'https://via.assets.so/img.jpg?w=400&h=300&bg=e5e7eb&text=+&f=png') }}" alt="Cover Product {{ $product->name }}" style="width: 100%;height: auto;">
<section class="collection bg-light position-relative border-bottom">
    <div class="">
      <div class="row">
        <div class="collection-item d-flex flex-wrap">
          <div class="col-md-6 column-container">
            <div class="image-holder" style="width: 100% !important;height: 100% !important;">
              <img src="{{ asset(count($arr_image) ? 'assets/image/upload/product/'.$arr_image[0] : 'https://via.assets.so/img.jpg?w=400&h=300&bg=e5e7eb&text=+&f=png') }}" alt="collection" class="product-image img-fluid" style="width: 100% !important;height: 100% !important;object-fit: cover !important;">
            </div>
          </div>
          <div class="col-md-6 column-container bg-white border-left">
            <div class="collection-content p-5 m-0 m-md-5">
              <h3 class="element-title text-uppercase">{{ $product->name }}</h3>
              <p>{!! $product->description !!}</p>
              <a href="#" class="btn btn-dark text-uppercase mt-3"><i class="ti ti-hand-open"></i> Sample</a>
              <a href="#" class="btn btn-dark text-uppercase mt-3"><i class="ti ti-shopping-cart"></i> Order</a>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

@if (count($arr_image) > 1)
<section class="instagram position-relative border-bottom">
    <div class="row g-0">
        @foreach ($arr_image as $index => $image)
            @if ($index > 0)
            <div class="col-6 col-sm-4 col-md-2">
                <div class="insta-item m-0 ">
                    <a href="https://www.instagram.com/templatesjungle/" target="_blank">
                    <img src="{{ asset('assets/image/upload/product/'.$image) }}" alt="{{ 'Image '.$product->name }}" class="insta-image img-fluid border-right">
                    </a>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</section>
@endif --}}
@endsection