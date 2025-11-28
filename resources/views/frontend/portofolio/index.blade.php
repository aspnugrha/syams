@extends('frontend.layouts.app')

@section('content')

<img class="responsive-img" src="{{ asset('assets/image/upload/landing_page/bg-7.jpg') }}" alt="Banner" style="width: 100%;height: 100vh;object-fit: cover;">

<div class="container mt-4">
    <div class="row g-2">
        @foreach($products as $item)
        <a href="{{ route('showcase.detail', $item->slug) }}" class="col-6 col-md-3">
            <div class="card text-white border-0 position-relative" style="overflow:hidden;">
                <img src="{{ $item->image ? asset('assets/image/upload/product/'.explode(',', $item->image)[0]) : 'https://via.assets.so/img.jpg?w=800&h=800&bg=ddd' }}" class="card-img" alt="Product" style="width: 100%;height: 280px;object-fit: cover;">

                <!-- Overlay gradient -->
                <div class="position-absolute bottom-0 start-0 w-100 p-3"
                    style="background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));">

                    <p class="mb-1 p-0" style="font-size: 0.7rem; opacity: 0.9;">{{ ($item->hasCategory ? $item->hasCategory->name : '') }}</p>
                    <h5 class="m-0 p-0" style="font-size: .95rem;">{{ $item->name }}</h5>

                    <!--
                    <div class="d-flex gap-2">
                        @php
                            $size_qty = json_decode($item->size_qty_options);
                        @endphp
                        @if ($size_qty)
                            @foreach ($size_qty as $item2)
                            {{-- <span class="size-badge" style="font-size: 10px;padding: 2px !important;">{{ $item2->size }}</span> --}}
                            <span style="font-size: 8px;">{{ $item2->size }}</span>
                            @endforeach
                        @endif
                    </div>
                    -->

                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>

{{-- 
@if ($covers)
<div class="swiper mySwiper border-bottom">
    <div class="swiper-wrapper">
        @foreach ($covers as $index_cover => $item)
            <div class="swiper-slide">
                <img src="{{ asset('assets/image/upload/product/'.$item->cover) }}" alt="Banner {{ $index_cover + 1 }}" style="width: 100%;height: 800px;object-fit: cover;">
            </div>
        @endforeach
    </div>
    <div class="icon-arrow icon-arrow-left swiper-button-prev text-white"></div>
    <div class="icon-arrow icon-arrow-right swiper-button-next text-white"></div>
</div>
@endif

@if ($products)
    @if (count($products) >= 3)
    <div class="p-0 m-0" style="display: flex;justify-content: center;align-items: center;">
        <div class="gallery">
            <div class="left">
                <a href="{{ route('showcase.detail', ['slug' => $products[0]['slug']]) }}">
                    <img src="{{ asset('assets/image/upload/product/'.$products[0]['image']) }}" class="border-right" alt="Image {{ $products[0]['name'] }}">
                </a>
            </div>
            <div class="right">
                <a href="{{ route('showcase.detail', ['slug' => $products[1]['slug']]) }}">
                    <img src="{{ asset('assets/image/upload/product/'.$products[1]['image']) }}" class="border-bottom" alt="Image {{ $products[1]['name'] }}">
                </a>
                <a href="{{ route('showcase.detail', ['slug' => $products[2]['slug']]) }}">
                    <img src="{{ asset('assets/image/upload/product/'.$products[2]['image']) }}" class="" alt="Image {{ $products[2]['name'] }}">
                </a>
            </div>
        </div>
    </div>
    @endif
@endif --}}
{{-- 

<section class="instagram position-relative border-bottom">
    <div class="row g-0">
        @if ($products && count($products) > 3)
            @foreach (array_slice($products, 3) as $item)
            <div class="col-6 col-sm-4 col-md-3 border-top">
                <div class="insta-item m-0 ">
                    <a href="{{ route('showcase.detail', ['slug' => $item['slug']]) }}">
                    <img src="{{ asset('assets/image/upload/product/'.$item['image']) }}" alt="Image {{ $item['name'] }}" class="insta-image img-fluid border-right">
                    </a>
                </div>
            </div>
            @endforeach
        @else
            @for($i; $i < 6; $i++)
            <div class="col-6 col-sm-4 col-md-2">
                <div class="insta-item m-0 ">
                    <img src="https://via.assets.so/img.jpg?w=400&h=300&bg=e5e7eb&text=+&f=png" alt="" class="insta-image img-fluid border-right">
                </div>
            </div>
            @endfor
        @endif
    </div>
</section> --}}
@endsection
@section('scripts')
{{-- <script>
const swiper_porto = new Swiper(".mySwiper", {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 0,
    autoplay: {
        delay: 7000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    speed: 800,
});
</script> --}}
@endsection