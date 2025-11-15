@extends('frontend.layouts.app')

@section('content')
@php
    $arr_image = [$product->image];
    if(str_contains($product->image, ',')){
        $arr_image = explode(',', $product->image);
    }
@endphp
<img class="border-bottom" src="{{ asset($product->cover ? 'assets/image/upload/product/'.$product->cover : 'https://via.assets.so/img.jpg?w=400&h=300&bg=e5e7eb&text=+&f=png') }}" alt="Cover Product {{ $product->name }}" style="width: 100%;height: auto;">
<section class="collection bg-light position-relative border-bottom">
    <div class="">
      <div class="row">
        {{-- <div class="title-xlarge text-uppercase txt-fx domino">Collection</div> --}}
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
    {{-- <div class="d-flex justify-content-center w-100 position-absolute bottom-0 z-1">
      <a href="https://www.instagram.com/templatesjungle/" class="btn btn-dark px-5">Follow us on Social Media</a>
    </div> --}}
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
@endif
@endsection