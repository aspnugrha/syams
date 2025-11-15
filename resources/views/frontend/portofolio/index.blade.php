@extends('frontend.layouts.app')

@section('content')
@if ($covers)
<div class="swiper mySwiper border-bottom">
    <div class="swiper-wrapper">
        @foreach ($covers as $index_cover => $item)
            <div class="swiper-slide">
                <img src="{{ asset('assets/image/upload/product/'.$item->cover) }}" alt="Banner {{ $index_cover + 1 }}" style="width: 100%;height: 800px;object-fit: cover;">
            </div>
        @endforeach
    </div>

    {{-- <div class="swiper-pagination"></div> --}}
    <div class="icon-arrow icon-arrow-left swiper-button-prev text-white"></div>
    <div class="icon-arrow icon-arrow-right swiper-button-next text-white"></div>
</div>
@endif

@if ($products)
    @if (count($products) >= 3)
    <div class="p-0 m-0" style="display: flex;justify-content: center;align-items: center;">
        <div class="gallery">
            <div class="left">
                <a href="{{ route('portofolio.detail', ['slug' => $products[0]['slug']]) }}">
                    <img src="{{ asset('assets/image/upload/product/'.$products[0]['image']) }}" class="border-right" alt="Image {{ $products[0]['name'] }}">
                </a>
            </div>
            <div class="right">
                <a href="{{ route('portofolio.detail', ['slug' => $products[1]['slug']]) }}">
                    <img src="{{ asset('assets/image/upload/product/'.$products[1]['image']) }}" class="border-bottom" alt="Image {{ $products[1]['name'] }}">
                </a>
                <a href="{{ route('portofolio.detail', ['slug' => $products[2]['slug']]) }}">
                    <img src="{{ asset('assets/image/upload/product/'.$products[2]['image']) }}" class="" alt="Image {{ $products[2]['name'] }}">
                </a>
            </div>
        </div>
    </div>
    @endif
@endif


<section class="instagram position-relative border-bottom">
    {{-- <div class="d-flex justify-content-center w-100 position-absolute bottom-0 z-1">
      <a href="https://www.instagram.com/templatesjungle/" class="btn btn-dark px-5">Follow us on Social Media</a>
    </div> --}}
    <div class="row g-0">
        @if ($products && count($products) > 3)
            @foreach (array_slice($products, 3) as $item)
            <div class="col-6 col-sm-4 col-md-3 border-top">
                <div class="insta-item m-0 ">
                    <a href="{{ route('portofolio.detail', ['slug' => $item['slug']]) }}">
                    <img src="{{ asset('assets/image/upload/product/'.$item['image']) }}" alt="Image {{ $item['name'] }}" class="insta-image img-fluid border-right">
                    </a>
                </div>
            </div>
            @endforeach
        @else
            @for($i; $i < 6; $i++)
            <div class="col-6 col-sm-4 col-md-2">
                <div class="insta-item m-0 ">
                    {{-- <a href="https://www.instagram.com/templatesjungle/"> --}}
                    <img src="https://via.assets.so/img.jpg?w=400&h=300&bg=e5e7eb&text=+&f=png" alt="" class="insta-image img-fluid border-right">
                    {{-- </a> --}}
                </div>
            </div>
            @endfor
        @endif
    </div>
</section>
@endsection
@section('scripts')
<script>
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
</script>
@endsection