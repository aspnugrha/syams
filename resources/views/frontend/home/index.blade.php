@extends('frontend.layouts.app')

@section('content')
<style>
.carousel-item img {
    border: none !important;
    border-radius: 0 !important;
    object-fit: cover;
}
.carousel-inner {
    padding: 0;
    cursor: grab;
}
.carousel-inner:active {
    cursor: grabbing;
}
/* Hilangkan indicators */
.carousel-indicators {
    display: none;
}
/* Custom scroll untuk horizontal drag */
.carousel-inner .row {
    flex-wrap: nowrap;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
}
.carousel-inner .row::-webkit-scrollbar {
    display: none;
}
.carousel-inner .row {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
/* Desktop: show 3, Mobile: show 1 */
.carousel-inner .col-md-4 {
    flex: 0 0 calc(100% / 3);
    scroll-snap-align: start;
}
@media (max-width: 768px) {
    .carousel-inner .col-md-4 {
        flex: 0 0 100%;
    }
}
</style>
{{-- <video autoplay="" muted="" loop="" playsinline="" style="width:100%; height:auto;">
  <source src="{{ asset('assets/video') }}/Syams-Manufacturing-Profile.mp4" type="video/mp4">
  Browser kamu tidak mendukung video.
</video> --}}
@php
    $banner = json_decode($company->banner, true);
@endphp
@if ($banner)
<img class="responsive-img" src="{{ asset('assets/image/upload/banner/'.$banner['banner_landing_page']) }}" alt="Banner" style="width: 100%;height: 100vh;object-fit: cover;">
@else
<img class="responsive-img" src="{{ asset('assets/image/upload/landing_page/bg-5.jpg') }}" alt="Banner" style="width: 100%;height: 100vh;object-fit: cover;">
@endif

<section id="billboard" class="bg-light pt-5" style="position: relative;margin-top: -10px;">
    <div class="w-100 container p-0">
      <div class="row justify-content-center">
        <h2 class="section-title text-center mt-4 text-uppercase" style="font-size: 6vh;" data-aos="fade-up">Turning the impossible<br>into wearable</h2>
        <div class="col-md-10 text-center" data-aos="fade-up" data-aos-delay="300">
          <p>
            Syams is a fashion manufacturing company that delivers more than just clothing. We create apparel through a process driven by precision, creativity, and intention. Each piece is crafted by skilled hands and intentional design thinking. Resulting in garments that are not only wearable, but meaningful. Turning the Impossible into Wearable is our commitment to pushing boundaries and transforming ambitious ideas into real, wearable fashion.
          </p>
        </div>
      </div>
      {{-- @if ($products)
      <div class="p-2 mt-5">
        <div id="imageCarousel" class="carousel slide">
            <div class="carousel-inner">
                <!-- SEMUA GAMBAR DALAM 1 DIV -->
                <div class="carousel-item active">
                    <div class="row g-0">
                      @foreach ($products as $item)
                      @php
                        $covers = explode(',', $item->image);
                        $cover = count($covers) ? $covers[0] : '';
                      @endphp
                      <a href="{{ route('showcase.detail', ['slug' => $item->slug]) }}" class="col-md-4">
                          <img src="{{ asset('assets/image/upload/product/'.$cover) }}" class="d-block w-100" alt="Cover {{ $item->name }}" style="width: 100%;height: 400px;object-fit: cover">
                      </a>
                      @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
      </div>
      @endif --}}

      <!--
      @if ($products)
      <div class="row">
        <div class="swiper main-swiper pt-4 mt-4" data-aos="fade-up" data-aos-delay="600">
          <div class="swiper-wrapper d-flex border-animation-left border-top">
            {{-- <div class="swiper-slide border-right">
              <div class="banner-item image-zoom-effect">
                <div class="image-holder">
                  <a href="#">
                    <img src="{{ asset('assets/frontend') }}/images/banner-image-6.jpg" alt="product" class="img-fluid" style="width: 100%;height: 100%;object-fit: cover;">
                  </a>
                </div>
                <div class="banner-content py-4">
                  <h5 class="element-title text-uppercase">
                    <a href="index.html" class="item-anchor">Soft leather jackets</a>
                  </h5>
                  <p>Scelerisque duis aliquam qui lorem ipsum dolor amet, consectetur adipiscing elit.</p>
                  <div class="btn-left">
                    <a href="#" class="btn-link fs-6 text-uppercase item-anchor text-decoration-none">Discover Now</a>
                  </div>
                </div>
              </div>
            </div> --}}
            @foreach ($products as $item)
              @php
                  $image_slider_main = [$item->image];
                  if(str_contains($item->image, ',')){
                    $image_slider_main = explode(',', $item->image);
                  }
              @endphp
              @foreach ($image_slider_main as $image)
              <div class="swiper-slide border-right">
                <div class="banner-item image-zoom-effect">
                  <div class="image-holder">
                    <a href="{{ route('showcase.detail', ['slug' => $item->slug]) }}">
                      <img src="{{ asset('assets/image/upload/product/'.$image) }}" alt="{{ 'Image '.$item->name }}" class="img-fluid" style="width: 100%;height: 100%;object-fit: cover;">
                    </a>
                  </div>
                </div>
              </div>
              @endforeach
            @endforeach
          </div>
          <div class="swiper-pagination"></div>
        </div>
        <div class="icon-arrow icon-arrow-left">
          <i class="ti ti-angle-left text-white"></i>
        </div>
        <div class="icon-arrow icon-arrow-right">
          <i class="ti ti-angle-right text-white"></i>
        </div>
      </div>
      @endif
    -->
    </div>
    <div class="w-100 container d-flex justify-content-center p-0 my-5">
      <div class="w-100 row justify-content-center g-1 pb-5">
      @foreach ($products as $item)
      @php
        $covers = explode(',', $item->image);
        $cover = count($covers) ? $covers[0] : '';

        $size_qty_count = 0;
        if($item->size_qty_options){
          $size_qty = json_decode($item->size_qty_options);
          $size_qty_count = count($size_qty);
        }
      @endphp
      <a href="{{ route('showcase.detail', ['slug' => $item->slug]) }}" class="col-md-3">
        <div class=" border-0 rounded-0">
          <img src="{{ asset('assets/image/upload/product/'.$cover) }}" class="d-block w-100" alt="Cover {{ $item->name }}" style="width: 100%;height: 320px;object-fit: cover">
          <div class="container py-2" style="min-height: 80px;">
            <p class="p-0 fw-semibold text-uppercase mb-1" style="font-size: 14px;color: #333;">{{ $item->name }}</p>
            <small class="text-muted">{{ $size_qty_count }} Size Options</small>
          </div>
        </div>
      </a>
      @endforeach
      </div>
    </div>
  </section>

  <section class="features py-5">
    <div class="container">
      {{-- <p class="text-center">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iure laudantium, saepe autem eum molestias eos beatae illum temporibus facilis necessitatibus.</p> --}}
      <div class="row">
        <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="0">
          <div class="py-3">
            <i class="mdi mdi-truck-fast-outline" style="font-size: 45px;"></i>
            <h4 class="element-title text-capitalize my-3">Free Shipping</h4>
            <p>We provide free shipping to ensure a smooth and seamless production process from start to destination. No hidden costs—just efficient and reliable delivery.</p>
          </div>
        </div>
        <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="300">
          <div class="py-3">
            <i class="mdi mdi-message-text-fast-outline" style="font-size: 45px;"></i>
            <h4 class="element-title text-capitalize my-3">Free Consultation</h4>
            <p>Every production begins with a clear and focused idea. Through our free consultation, we help refine concepts, material selection, and the right production approach before bringing them to life.</p>
          </div>
        </div>
        <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="600">
          <div class="py-3">
            <i class="mdi mdi-package-variant-closed-check" style="font-size: 45px;"></i>
            <h4 class="element-title text-capitalize my-3">Free Packaging</h4>
            <p>The final presentation is part of a product’s value. We offer free packaging designed to protect the product while enhancing its premium appeal.</p>
          </div>
        </div>
        <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="900">
          <div class="py-3">
            <i class="mdi mdi-tshirt-crew-outline" style="font-size: 45px;"></i>
            <h4 class="element-title text-capitalize my-3">Free Sample</h4>
            <p>Quality should be experienced before full production. We provide free samples so you can directly evaluate materials, fit, and craftsmanship with confidence.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- <div class="card-image border">
    <img src="{{ asset('assets/image/upload/product/banner1.png') }}" alt="">
    <div class="card-image-content">
      <a href="#" class="btn btn-outline-primary">
        More 
        <i class="ti ti-arrow-right"></i>
      </a>
    </div>
  </div>
  
  <div class="card-image border">
    <img src="{{ asset('assets/image/upload/product/banner2.png') }}" alt="">
    <div class="card-image-content">
      <a href="#" class="btn btn-outline-primary">
        More 
        <i class="ti ti-arrow-right"></i>
      </a>
    </div>
  </div> --}}

  <?php /* <section class="categories overflow-hidden">
    <div class="open-up" data-aos="zoom-out">
      <div class="row p-0 m-0">
        <div class="col-md-6 p-0 m-0">
          <div class="card-image">
            <img src="{{ asset('assets/image/upload/product/banner1.png') }}" alt="">
            <div class="card-image-content">
              <p>
                Check out our <br>exciting products
              </p>
              <a href="#" class="btn btn-outline-primary">
                More 
                <i class="ti ti-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 p-0 m-0">
          <div class="card-image">
            <img src="{{ asset('assets/image/upload/product/banner2.png') }}" alt="">
            <div class="card-image-content">
              <p>
                Check out our <br>exciting products
              </p>
              <a href="#" class="btn btn-outline-primary">
                More 
                <i class="ti ti-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
        {{-- <div class="col-md-6 p-0 m-0">
          <div class="cat-item image-zoom-effect">
            <div class="image-holder">
              <a href="index.html">
                <img src="{{ asset('assets/frontend') }}/images/cat-item1.jpg" alt="categories" class="product-image img-fluid" style="width: 100%;">
              </a>
            </div>
            <div class="category-content">
              <div class="product-button">
                <a href="index.html" class="btn btn-common text-uppercase">Shop for men</a>
              </div>
            </div>
          </div>
        </div> --}}
      </div>
    </div>
    {{-- <div class="container">
    </div> --}}
  </section> */?>

  {{-- <section id="new-arrival" class="new-arrival product-carousel py-5 position-relative overflow-hidden">
    <div class="container">
      <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
        <h4 class="text-uppercase">Our New Arrivals</h4>
        <a href="index.html" class="btn-link">View All Products</a>
      </div>
      <div class="swiper product-swiper open-up" data-aos="zoom-out">
        <div class="swiper-wrapper d-flex">
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder position-relative">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-1.jpg" alt="categories" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="element-title text-uppercase fs-5 mt-3">
                    <a href="index.html">Dark florish onepiece</a>
                  </h5>
                  <a href="#" class="text-decoration-none" data-after="Add to cart"><span>$95.00</span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder position-relative">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-2.jpg" alt="categories" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                    <a href="index.html">Baggy Shirt</a>
                  </h5>
                  <a href="#" class="text-decoration-none" data-after="Add to cart"><span>$55.00</span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder position-relative">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-3.jpg" alt="categories" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                    <a href="index.html">Cotton off-white shirt</a>
                  </h5>
                  <a href="#" class="text-decoration-none" data-after="Add to cart"><span>$65.00</span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder position-relative">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-4.jpg" alt="categories" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                    <a href="index.html">Crop sweater</a>
                  </h5>
                  <a href="#" class="text-decoration-none" data-after="Add to cart"><span>$50.00</span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder position-relative">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-10.jpg" alt="categories" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                    <a href="index.html">Crop sweater</a>
                  </h5>
                  <a href="#" class="text-decoration-none" data-after="Add to cart"><span>$70.00</span></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
      <div class="icon-arrow icon-arrow-left"><svg width="50" height="50" viewBox="0 0 24 24">
          <use xlink:href="#arrow-left"></use>
        </svg></div>
      <div class="icon-arrow icon-arrow-right"><svg width="50" height="50" viewBox="0 0 24 24">
          <use xlink:href="#arrow-right"></use>
        </svg></div>
    </div>
  </section>

  <section class="collection bg-light position-relative py-5">
    <div class="container">
      <div class="row">
        <div class="title-xlarge text-uppercase txt-fx domino">Collection</div>
        <div class="collection-item d-flex flex-wrap my-5">
          <div class="col-md-6 column-container">
            <div class="image-holder">
              <img src="{{ asset('assets/frontend') }}/images/single-image-2.jpg" alt="collection" class="product-image img-fluid">
            </div>
          </div>
          <div class="col-md-6 column-container bg-white">
            <div class="collection-content p-5 m-0 m-md-5">
              <h3 class="element-title text-uppercase">Classic winter collection</h3>
              <p>Dignissim lacus, turpis ut suspendisse vel tellus. Turpis purus, gravida orci, fringilla a. Ac sed eu
                fringilla odio mi. Consequat pharetra at magna imperdiet cursus ac faucibus sit libero. Ultricies quam
                nunc, lorem sit lorem urna, pretium aliquam ut. In vel, quis donec dolor id in. Pulvinar commodo mollis
                diam sed facilisis at cursus imperdiet cursus ac faucibus sit faucibus sit libero.</p>
              <a href="#" class="btn btn-dark text-uppercase mt-3">Shop Collection</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="best-sellers" class="best-sellers product-carousel py-5 position-relative overflow-hidden">
    <div class="container">
      <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
        <h4 class="text-uppercase">Best Selling Items</h4>
        <a href="index.html" class="btn-link">View All Products</a>
      </div>
      <div class="swiper product-swiper open-up" data-aos="zoom-out">
        <div class="swiper-wrapper d-flex">
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-4.jpg" alt="categories" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                    <a href="index.html">Dark florish onepiece</a>
                  </h5>
                  <a href="index.html" class="text-decoration-none" data-after="Add to cart"><span>$95.00</span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-3.jpg" alt="product" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                    <a href="index.html">Baggy Shirt</a>
                  </h5>
                  <a href="index.html" class="text-decoration-none" data-after="Add to cart"><span>$55.00</span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-5.jpg" alt="categories" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                    <a href="index.html">Cotton off-white shirt</a>
                  </h5>
                  <a href="index.html" class="text-decoration-none" data-after="Add to cart"><span>$65.00</span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-6.jpg" alt="categories" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                    <a href="index.html">Handmade crop sweater</a>
                  </h5>
                  <a href="index.html" class="text-decoration-none" data-after="Add to cart"><span>$50.00</span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-9.jpg" alt="categories" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                    <a href="index.html">Dark florish onepiece</a>
                  </h5>
                  <a href="index.html" class="text-decoration-none" data-after="Add to cart"><span>$70.00</span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-10.jpg" alt="categories" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                    <a href="index.html">Cotton off-white shirt</a>
                  </h5>
                  <a href="index.html" class="text-decoration-none" data-after="Add to cart"><span>$70.00</span></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
      <div class="icon-arrow icon-arrow-left"><svg width="50" height="50" viewBox="0 0 24 24">
          <use xlink:href="#arrow-left"></use>
        </svg></div>
      <div class="icon-arrow icon-arrow-right"><svg width="50" height="50" viewBox="0 0 24 24">
          <use xlink:href="#arrow-right"></use>
        </svg></div>
    </div>
  </section> --}}

  {{-- <section class="video overflow-hidden border-bottom">
    <div class="container-fluid p-0">
      <div class="row">
        <div class="video-content open-up" data-aos="zoom-out">
          <div class="video-bg">
            <img src="{{ asset('assets/frontend') }}/images/video-image.jpg" alt="video" class="video-image img-fluid">
          </div>
          <div class="video-player">
            <a class="youtube" href="https://www.youtube.com/embed/pjtsGzQjFM4">
              <svg width="24" height="24" viewBox="0 0 24 24">
                <use xlink:href="#play"></use>
              </svg>
              <img src="{{ asset('assets/frontend') }}/images/text-pattern.png" alt="pattern" class="text-rotate">
            </a>
          </div>
        </div>
      </div>
    </div>
  </section> --}}

  {{-- <section class="testimonials py-5 bg-light">
    <div class="section-header text-center mt-5">
      <h3 class="section-title">WE LOVE GOOD COMPLIMENT</h3>
    </div>
    <div class="swiper testimonial-swiper overflow-hidden my-5">
      <div class="swiper-wrapper d-flex">
        <div class="swiper-slide">
          <div class="testimonial-item text-center">
            <blockquote>
              <p>“More than expected crazy soft, flexible and best fitted white simple denim shirt.”</p>
              <div class="review-title text-uppercase">casual way</div>
            </blockquote>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="testimonial-item text-center">
            <blockquote>
              <p>“Best fitted white denim shirt more than expected crazy soft, flexible</p>
              <div class="review-title text-uppercase">uptop</div>
            </blockquote>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="testimonial-item text-center">
            <blockquote>
              <p>“Best fitted white denim shirt more white denim than expected flexible crazy soft.”</p>
              <div class="review-title text-uppercase">Denim craze</div>
            </blockquote>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="testimonial-item text-center">
            <blockquote>
              <p>“Best fitted white denim shirt more than expected crazy soft, flexible</p>
              <div class="review-title text-uppercase">uptop</div>
            </blockquote>
          </div>
        </div>
      </div>
    </div>
    <div class="testimonial-swiper-pagination d-flex justify-content-center mb-5"></div>
  </section>

  <section id="related-products" class="related-products product-carousel py-5 position-relative overflow-hidden">
    <div class="container">
      <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
        <h4 class="text-uppercase">You May Also Like</h4>
        <a href="index.html" class="btn-link">View All Products</a>
      </div>
      <div class="swiper product-swiper open-up" data-aos="zoom-out">
        <div class="swiper-wrapper d-flex">
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-5.jpg" alt="product" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                    <a href="index.html">Dark florish onepiece</a>
                  </h5>
                  <a href="index.html" class="text-decoration-none" data-after="Add to cart"><span>$95.00</span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-6.jpg" alt="product" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                    <a href="index.html">Baggy Shirt</a>
                  </h5>
                  <a href="index.html" class="text-decoration-none" data-after="Add to cart"><span>$55.00</span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-7.jpg" alt="product" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                    <a href="index.html">Cotton off-white shirt</a>
                  </h5>
                  <a href="index.html" class="text-decoration-none" data-after="Add to cart"><span>$65.00</span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-8.jpg" alt="product" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                    <a href="index.html">Handmade crop sweater</a>
                  </h5>
                  <a href="index.html" class="text-decoration-none" data-after="Add to cart"><span>$50.00</span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="product-item image-zoom-effect link-effect">
              <div class="image-holder">
                <a href="index.html">
                  <img src="{{ asset('assets/frontend') }}/images/product-item-1.jpg" alt="product" class="product-image img-fluid">
                </a>
                <a href="index.html" class="btn-icon btn-wishlist">
                  <svg width="24" height="24" viewBox="0 0 24 24">
                    <use xlink:href="#heart"></use>
                  </svg>
                </a>
                <div class="product-content">
                  <h5 class="text-uppercase fs-5 mt-3">
                    <a href="index.html">Handmade crop sweater</a>
                  </h5>
                  <a href="index.html" class="text-decoration-none" data-after="Add to cart"><span>$70.00</span></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
      <div class="icon-arrow icon-arrow-left"><svg width="50" height="50" viewBox="0 0 24 24">
          <use xlink:href="#arrow-left"></use>
        </svg></div>
      <div class="icon-arrow icon-arrow-right"><svg width="50" height="50" viewBox="0 0 24 24">
          <use xlink:href="#arrow-right"></use>
        </svg></div>
    </div>
  </section>

  <section class="blog py-5">
    <div class="container">
      <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
        <h4 class="text-uppercase">Read Blog Posts</h4>
        <a href="index.html" class="btn-link">View All</a>
      </div>
      <div class="row">
        <div class="col-md-4">
          <article class="post-item">
            <div class="post-image">
              <a href="index.html">
                <img src="{{ asset('assets/frontend') }}/images/post-image1.jpg" alt="image" class="post-grid-image img-fluid">
              </a>
            </div>
            <div class="post-content d-flex flex-wrap gap-2 my-3">
              <div class="post-meta text-uppercase fs-6 text-secondary">
                <span class="post-category">Fashion /</span>
                <span class="meta-day"> jul 11, 2022</span>
              </div>
              <h5 class="post-title text-uppercase">
                <a href="index.html">How to look outstanding in pastel</a>
              </h5>
              <p>Dignissim lacus,turpis ut suspendisse vel tellus.Turpis purus,gravida orci,fringilla...</p>
            </div>
          </article>
        </div>
        <div class="col-md-4">
          <article class="post-item">
            <div class="post-image">
              <a href="index.html">
                <img src="{{ asset('assets/frontend') }}/images/post-image2.jpg" alt="image" class="post-grid-image img-fluid">
              </a>
            </div>
            <div class="post-content d-flex flex-wrap gap-2 my-3">
              <div class="post-meta text-uppercase fs-6 text-secondary">
                <span class="post-category">Fashion /</span>
                <span class="meta-day"> jul 11, 2022</span>
              </div>
              <h5 class="post-title text-uppercase">
                <a href="index.html">Top 10 fashion trend for summer</a>
              </h5>
              <p>Turpis purus, gravida orci, fringilla dignissim lacus, turpis ut suspendisse vel tellus...</p>
            </div>
          </article>
        </div>
        <div class="col-md-4">
          <article class="post-item">
            <div class="post-image">
              <a href="index.html">
                <img src="{{ asset('assets/frontend') }}/images/post-image3.jpg" alt="image" class="post-grid-image img-fluid">
              </a>
            </div>
            <div class="post-content d-flex flex-wrap gap-2 my-3">
              <div class="post-meta text-uppercase fs-6 text-secondary">
                <span class="post-category">Fashion /</span>
                <span class="meta-day"> jul 11, 2022</span>
              </div>
              <h5 class="post-title text-uppercase">
                <a href="index.html">Crazy fashion with unique moment</a>
              </h5>
              <p>Turpis purus, gravida orci, fringilla dignissim lacus, turpis ut suspendisse vel tellus...</p>
            </div>
          </article>
        </div>
      </div>
    </div>
  </section>
 --}}
 

  <section class="newsletter bg-light" style="background: url(images/pattern-bg.png) no-repeat;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-7 py-5 my-5">
          <div class="subscribe-header text-center pb-3">
            <h3 class="section-title text-uppercase">I would like to request a sample</h3>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <input type="text" name="email" id="email_request_sample" placeholder="Your Email Addresss" class="form-control form-control-lg" required>
            <button type="button" onclick="$('#email_request_sample').val()&&(window.location.href='{{ route('order') }}?email='+$('#email_request_sample').val())" class="btn btn-dark btn-lg text-uppercase w-100">Send me a sample</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- <section class="logo-bar py-5 my-5">
    <div class="container">
      <div class="row">
        <div class="logo-content d-flex flex-wrap justify-content-start gap-0">
          <img src="{{ asset('assets/image/upload/collaboration/1.jpg') }}" alt="logo" class="logo-image img-fluid" style="max-width: 200px;">
          <img src="{{ asset('assets/image/upload/collaboration/2.jpg') }}" alt="logo" class="logo-image img-fluid" style="max-width: 200px;">
          <img src="{{ asset('assets/image/upload/collaboration/3.jpg') }}" alt="logo" class="logo-image img-fluid" style="max-width: 200px;">
          <img src="{{ asset('assets/image/upload/collaboration/4.jpg') }}" alt="logo" class="logo-image img-fluid" style="max-width: 200px;">
          <img src="{{ asset('assets/image/upload/collaboration/5.jpg') }}" alt="logo" class="logo-image img-fluid" style="max-width: 200px;">
          <img src="{{ asset('assets/image/upload/collaboration/6.jpg') }}" alt="logo" class="logo-image img-fluid" style="max-width: 200px;">
          <img src="{{ asset('assets/image/upload/collaboration/7.jpg') }}" alt="logo" class="logo-image img-fluid" style="max-width: 200px;">
          <img src="{{ asset('assets/image/upload/collaboration/8.jpg') }}" alt="logo" class="logo-image img-fluid" style="max-width: 200px;">
          <img src="{{ asset('assets/image/upload/collaboration/9.jpg') }}" alt="logo" class="logo-image img-fluid" style="max-width: 200px;">
          <img src="{{ asset('assets/image/upload/collaboration/10.jpg') }}" alt="logo" class="logo-image img-fluid" style="max-width: 200px;">
          <img src="{{ asset('assets/image/upload/collaboration/11.jpg') }}" alt="logo" class="logo-image img-fluid" style="max-width: 200px;">
        </div>
      </div>
    </div>
  </section> --}}

  <section class="instagram position-relative">
    <div class="d-flex justify-content-center w-100 position-absolute bottom-0 z-1">
      {{-- <a href="https://www.instagram.com/templatesjungle/" class="btn btn-dark px-5">Follow us on Social Media</a> --}}
      <span class="btn btn-dark px-5">Collaboration With</span>
    </div>
    {{-- @if ($products)
    <div class="row g-0">
      @php
          $no_slider_sosmed = 1;
      @endphp
      @foreach ($products as $item)
        @php
            $image_slider_sosmed = [$item->image];
            if(str_contains($item->image, ',')){
              $image_slider_sosmed = explode(',', $item->image);
            }
        @endphp
        @foreach ($image_slider_sosmed as $image)
        @if ($no_slider_sosmed <= 6)
        <div class="col-6 col-sm-4 col-6 col-md-2">
          <div class="insta-item">
            <a href="https://www.instagram.com/templatesjungle/" target="_blank">
              <img src="{{ asset('assets/image/upload/product/'.$image) }}" alt="{{ 'Image '.$item->name }}" class="insta-image img-fluid">
            </a>
          </div>
        </div>
        @endif
        @php
            $no_slider_sosmed++;
        @endphp
        @endforeach
      @endforeach
    </div>
    @endif --}}

    <div class="row g-0 justify-content-center">
        <div class="col-3 col-md-1">
          <img src="{{ asset('assets/image/upload/collaboration/1.jpg') }}" class="d-block w-100" alt="Cover {{ $item->name }}" style="">
        </div>
        <div class="col-3 col-md-1">
          <img src="{{ asset('assets/image/upload/collaboration/2.jpg') }}" class="d-block w-100" alt="Cover {{ $item->name }}" style="">
        </div>
        <div class="col-3 col-md-1">
          <img src="{{ asset('assets/image/upload/collaboration/3.jpg') }}" class="d-block w-100" alt="Cover {{ $item->name }}" style="">
        </div>
        <div class="col-3 col-md-1">
          <img src="{{ asset('assets/image/upload/collaboration/4.jpg') }}" class="d-block w-100" alt="Cover {{ $item->name }}" style="">
        </div>
        <div class="col-3 col-md-1">
          <img src="{{ asset('assets/image/upload/collaboration/5.jpg') }}" class="d-block w-100" alt="Cover {{ $item->name }}" style="">
        </div>
        <div class="col-3 col-md-1">
          <img src="{{ asset('assets/image/upload/collaboration/6.jpg') }}" class="d-block w-100" alt="Cover {{ $item->name }}" style="">
        </div>
        <div class="col-3 col-md-1">
          <img src="{{ asset('assets/image/upload/collaboration/7.jpg') }}" class="d-block w-100" alt="Cover {{ $item->name }}" style="">
        </div>
        <div class="col-3 col-md-1">
          <img src="{{ asset('assets/image/upload/collaboration/8.jpg') }}" class="d-block w-100" alt="Cover {{ $item->name }}" style="">
        </div>
        <div class="col-3 col-md-1">
          <img src="{{ asset('assets/image/upload/collaboration/9.jpg') }}" class="d-block w-100" alt="Cover {{ $item->name }}" style="">
        </div>
        <div class="col-3 col-md-1">
          <img src="{{ asset('assets/image/upload/collaboration/10.jpg') }}" class="d-block w-100" alt="Cover {{ $item->name }}" style="">
        </div>
        <div class="col-3 col-md-1">
          <img src="{{ asset('assets/image/upload/collaboration/11.jpg') }}" class="d-block w-100" alt="Cover {{ $item->name }}" style="">
        </div>
      </div>
  </section>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const carouselInner = document.querySelector('.carousel-inner .row');
    let isDragging = false;
    let startX;
    let scrollLeft;
    let autoSlideInterval;
    let isPaused = false;
    let resumeTimeout;

    // Duplikat gambar untuk infinite effect
    function duplicateImagesForInfinite() {
        const originalContent = carouselInner.innerHTML;
        carouselInner.innerHTML = originalContent + originalContent;
    }

    // Fungsi untuk mendapatkan jumlah item yang visible
    function getVisibleItemsCount() {
        return window.innerWidth <= 768 ? 1 : 3;
    }

    // Fungsi untuk mendapatkan scroll amount
    function getScrollAmount() {
        const visibleItems = getVisibleItemsCount();
        return carouselInner.offsetWidth / visibleItems;
    }

    // Fungsi untuk reset ke posisi awal ketika sampai duplikat
    function checkAndResetScroll() {
        const scrollThreshold = carouselInner.scrollWidth / 2;
        if (carouselInner.scrollLeft >= scrollThreshold) {
            // Reset ke awal tanpa animasi (invisible)
            carouselInner.style.scrollBehavior = 'auto';
            carouselInner.scrollLeft = carouselInner.scrollLeft - scrollThreshold;
            carouselInner.style.scrollBehavior = 'smooth';
        }
    }

    // Fungsi untuk auto slide infinite
    function startAutoSlide() {
        // Clear interval sebelumnya
        clearInterval(autoSlideInterval);
        
        autoSlideInterval = setInterval(() => {
            if (!isPaused) {
                const scrollAmount = getScrollAmount();
                carouselInner.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                
                // Check reset setelah animasi selesai
                setTimeout(checkAndResetScroll, 500);
            }
        }, 3000); // Auto slide setiap 3 detik
    }

    // Fungsi untuk pause auto slide saat interaksi
    function pauseAutoSlide() {
        isPaused = true;
        clearInterval(autoSlideInterval);
        clearTimeout(resumeTimeout); // Clear timeout yang numpuk
    }

    // Fungsi untuk resume auto slide dengan delay
    function resumeAutoSlide() {
        clearTimeout(resumeTimeout); // Clear timeout sebelumnya
        resumeTimeout = setTimeout(() => {
            isPaused = false;
            startAutoSlide();
        }, 3000); // Tunggu 3 detik baru resume
    }

    // Inisialisasi duplikat gambar
    duplicateImagesForInfinite();

    // Mouse events
    carouselInner.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.pageX - carouselInner.offsetLeft;
        scrollLeft = carouselInner.scrollLeft;
        carouselInner.style.cursor = 'grabbing';
        pauseAutoSlide();
    });

    carouselInner.addEventListener('mouseleave', () => {
        if (isDragging) {
            isDragging = false;
            carouselInner.style.cursor = 'grab';
            checkAndResetScroll();
            resumeAutoSlide();
        }
    });

    carouselInner.addEventListener('mouseup', () => {
        if (isDragging) {
            isDragging = false;
            carouselInner.style.cursor = 'grab';
            checkAndResetScroll();
            resumeAutoSlide();
        }
    });

    carouselInner.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - carouselInner.offsetLeft;
        const walk = (x - startX) * 2;
        carouselInner.scrollLeft = scrollLeft - walk;
    });

    // Touch events untuk mobile
    carouselInner.addEventListener('touchstart', (e) => {
        isDragging = true;
        startX = e.touches[0].pageX - carouselInner.offsetLeft;
        scrollLeft = carouselInner.scrollLeft;
        pauseAutoSlide();
    });

    carouselInner.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        const x = e.touches[0].pageX - carouselInner.offsetLeft;
        const walk = (x - startX) * 2;
        carouselInner.scrollLeft = scrollLeft - walk;
    });

    carouselInner.addEventListener('touchend', () => {
        if (isDragging) {
            isDragging = false;
            checkAndResetScroll();
            resumeAutoSlide();
        }
    });

    // Hover pause
    carouselInner.addEventListener('mouseenter', pauseAutoSlide);
    carouselInner.addEventListener('mouseleave', () => {
        if (!isDragging) {
            resumeAutoSlide();
        }
    });

    // Custom carousel controls dengan infinite loop
    const carousel = new bootstrap.Carousel(document.getElementById('imageCarousel'), {
        interval: false
    });

    // Previous button dengan infinite loop
    document.querySelector('.carousel-control-prev').addEventListener('click', function(e) {
        e.preventDefault();
        pauseAutoSlide();
        const scrollAmount = getScrollAmount();
        
        carouselInner.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        
        // Check reset setelah animasi
        setTimeout(checkAndResetScroll, 500);
        resumeAutoSlide();
    });

    // Next button dengan infinite loop
    document.querySelector('.carousel-control-next').addEventListener('click', function(e) {
        e.preventDefault();
        pauseAutoSlide();
        const scrollAmount = getScrollAmount();
        
        carouselInner.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        
        // Check reset setelah animasi
        setTimeout(checkAndResetScroll, 500);
        resumeAutoSlide();
    });

    // Scroll event untuk reset infinite
    carouselInner.addEventListener('scroll', checkAndResetScroll);

    // Mulai auto slide
    startAutoSlide();
});
</script>
@endsection