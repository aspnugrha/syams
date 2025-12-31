@extends('frontend.layouts.app')

@section('styles')
<style>
.section {
    padding: 30px 0;
}

.section-number {
    font-size: 64px;
    color: #ddd;
    font-weight: 700;
    line-height: 1;
}

.section-title {
    font-size: 18px;
    letter-spacing: 1px;
}

.section-subtitle {
    font-size: 14px;
    color: #777;
    /* text-transform: uppercase; */
}

.image-item {
    position: relative;
}

.image-item img {
    width: 100%;
    height: 220px;
    object-fit: cover;
}

.image-label {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0,0,0,.6);
    color: #fff;
    font-size: 12px;
    padding: 4px 10px;
    letter-spacing: 1px;
}

.fabric-list {
    gap: 12px;
}

.fabric-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    border: 1px solid #eee;
}

.fabric-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
@endsection
@section('content')

@php
    $material_colors = [
        [
            'material' => 'Cutton 16s',
            'description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dignissimos explicabo ab iste perferendis, mollitia cumque repudiandae, quae voluptate aperiam aut atque deserunt quasi, voluptates voluptatibus itaque molestias nulla illum id reiciendis quod quas consectetur omnis suscipit. Temporibus vitae expedita iusto consectetur odit autem rerum perspiciatis minima nulla enim neque voluptas ipsa reprehenderit consequatur earum, doloremque distinctio.',
            'image' => 'cutton-combed-16s.webp',
            'colors' => [
                [
                    'color' => 'Sunset Blaze',
                    'color_code' => '#FF5F45'
                ],
                [
                    'color' => 'Mint Splash',
                    'color_code' => '#2EC4B6'
                ],
            ],
        ], 
        [
            'material' => 'Cutton 26s',
            'description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dignissimos explicabo ab iste perferendis, mollitia cumque repudiandae, quae voluptate aperiam aut atque deserunt quasi, voluptates voluptatibus itaque molestias nulla illum id reiciendis quod quas consectetur omnis suscipit.',
            'image' => 'cutton-combed-26s.webp',
            'colors' => [
                [
                    'color' => 'Lime Punch',
                    'color_code' => '#A7C957'
                ],
                [
                    'color' => 'Neon Peach',
                    'color_code' => '#FF9F9F'
                ],
            ],
        ], 
    ];

    $sablons = [
        [
            'name' => 'Screen Printing',
            'description' => 'Screen printing or sablon is a printing technique that uses a screen as a stencil to transfer ink to a surface such as cloth, paper, or plastic, producing sharp, brightly colored, and durable images, often used for t-shirts, with the process of creating a pattern on the screen before the ink is applied using a squeegee. This technique is popular because of its high-quality and durable prints, although the initial preparation is complex, especially for multi-colored designs.',
            'image' => 'sablon.jpg'
        ],
        [
            'name' => 'Direct to Film',
            'description' => 'DTF (Direct to Film) is a modern digital screen printing technique that prints designs onto special PET films using textile inks, then transfers them to various types of fabrics (cotton, polyester, etc.) with the help of powder glue (hotmelt powder) and a heat press machine, producing sharp prints, bright colors, flexibility, and durability, suitable for various media and single or mass production.',
            'image' => 'dtf.jpg'
        ],
    ];

    $material_colors = json_decode(json_encode($material_colors));
    $sablons = json_decode(json_encode($sablons));
@endphp

{{-- <img class="responsive-img" src="{{ asset('assets/image/upload/landing_page/bg-7.jpg') }}" alt="Banner" style="width: 100%;height: 100vh;object-fit: cover;"> --}}
<img class="responsive-img" src="{{ asset('assets/image/upload/banner/banner-showcase.png') }}" alt="Banner" style="width: 100%;height: 100vh;object-fit: cover;">

<div class="container mt-4">
    <div class="row g-2 mb-5">
        <h4 class="mb-3">Showcase</h4>
        @foreach($product_showcase as $item)
        <a href="{{ route('showcase.detail', $item->slug) }}" class="col-6 col-md-3">
            <div class="card text-white border-0 position-relative rounded-0" style="overflow:hidden;">
                <img src="{{ $item->image ? asset('assets/image/upload/product/'.explode(',', $item->image)[0]) : 'https://via.assets.so/img.jpg?w=800&h=800&bg=ddd' }}" class="card-img rounded-0" alt="Product" style="width: 100%;height: 280px;object-fit: cover;">

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
    <div class="row g-2 mb-5">
        <h4 class="mb-3">Order</h4>
        @foreach($product_order as $item)
        <a href="{{ route('showcase.detail', $item->slug) }}" class="col-6 col-md-3">
            <div class="card text-white border-0 position-relative rounded-0" style="overflow:hidden;">
                <img src="{{ $item->image ? asset('assets/image/upload/product/'.explode(',', $item->image)[0]) : 'https://via.assets.so/img.jpg?w=800&h=800&bg=ddd' }}" class="card-img rounded-0" alt="Product" style="width: 100%;height: 280px;object-fit: cover;">

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

<div class="bg-light">
    <div class="container pt-5">
        <div class="row g-2 mb-5">
            <h4 class="mb-3">Materials, colors, and workmanship</h4>
            
            <!-- SECTION 01 -->
            <section class="section pt-2">
                <div class="row align-items-start mb-4">
                    <div class="col-auto">
                        <div class="section-number">01</div>
                    </div>
                    <div class="col">
                        <div class="section-title fw-semibold">CHOOSE FABRIC AND COLOR</div>
                        <div class="section-subtitle">
                            We provide the best quality materials with a variety of attractive color choices.
                        </div>
                    </div>
                </div>
        
                <div class="row g-2 bg-white">
                    @foreach ($material_colors as $item)
                    <div class="col-12 mb-2">
                        <div class="row g-0">
                            <div class="col-md-4 p-2">
                                <img src="{{ asset('assets/image/upload/material/'.$item->image) }}" alt="Image {{ $item->material }}" class="w-100 w-md-40" style="object-fit: cover;">
                            </div>
                            <div class="col-md-8">
                                <div class="material-info p-3">
                                    <small class="text-muted">Material</small>
                                    <h5 class="mb-1">{{ $item->material }}</h5>
            
                                    <small class="text-muted">Available Colors</small>
                                    @if ($item->colors)
                                        <div class="mb-2 mt-1 d-flex">
                                            @foreach ($item->colors as $color)
                                                <label class="btn btn-outline-secondary rounded-pill fw-semibold d-inline-flex align-items-center mb-1 me-1" style="font-size: 13px;padding: 2px 4px;">
                                                    <span style="width: 15px;height: 15px;border-radius: 100%;background-color: {{ $color->color_code }};"></span>
                                                    &nbsp;{{ $color->color }}
                                                </label>
                                            @endforeach
                                        </div>
                                    @else
                                        <small class="text-muted">No colors available yet</small>
                                    @endif
            
                                    <article>{{ $item->description }}</article>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
        
            </section>
        
            <!-- SECTION 02 -->
            <section class="section">
                <div class="row align-items-start mb-4">
                    <div class="col-auto">
                        <div class="section-number">02</div>
                    </div>
                    <div class="col">
                        <div class="section-title fw-semibold">SCREEN PRINTING TYPE</div>
                        <div class="section-subtitle">
                            Several screen printing processes that we can do on a large or small scale.
                        </div>
                    </div>
                </div>
        
                @foreach ($sablons as $index_sablon => $item)
                    @if ($index_sablon % 2 == 0)
                        <div class="row g-0 bg-white">
                            <div class="col-md-4 mb-4 p-3">
                                <img src="{{ asset('assets/image/upload/sablon/'.$item->image) }}" alt="Image {{ $item->name }}" class="w-100 w-md-40" style="height: 100%;max-height: 200px;object-fit: cover;background-position: center;">
                            </div>
                            <div class="col-md-8 mb-4">
                                <div class="p-3">
                                    <small class="text-muted">Printing Type</small>
                                    <h5 class="mb-1">{{ $item->name }}</h5>
                                    <article>{{ $item->description }}</article>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row g-0 bg-white">
                            <div class="col-md-8 mb-4">
                                <div class="p-3">
                                    <small class="text-muted">Printing Type</small>
                                    <h5 class="mb-1">{{ $item->name }}</h5>
                                    <article>{{ $item->description }}</article>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4 p-3">
                                <img src="{{ asset('assets/image/upload/sablon/'.$item->image) }}" alt="Image {{ $item->name }}" class="w-100 w-md-40" style="height: 100%;max-height: 200px;object-fit: cover;background-position: center;">
                            </div>
                        </div>
                    @endif
                @endforeach
            </section>
            
            <!-- SECTION 03 -->
            <section class="section">
                <div class="row align-items-start mb-4">
                    <div class="col-auto">
                        <div class="section-number">03</div>
                    </div>
                    <div class="col">
                        <div class="section-title fw-semibold">PROVIDING EMBROIDERY</div>
                        <div class="section-subtitle">
                            We provide custom embroidery services on request.
                        </div>
                    </div>
                </div>
        
                <div class="row justify-content-center mb-3 g-4">
                    <div class="col-6 col-md-auto text-center">
                        <img src="{{ asset('assets/image/upload/bordir/bordir-1.jpg') }}" alt="Image Bordir" style="width: 150px;height: 150px;object-fit: cover;background-position: center;border-radius: 100%;">
                    </div>
                    <div class="col-6 col-md-auto text-center">
                        <img src="{{ asset('assets/image/upload/bordir/bordir-2.jpg') }}" alt="Image Bordir" style="width: 150px;height: 150px;object-fit: cover;background-position: center;border-radius: 100%;">
                    </div>
                    <div class="col-6 col-md-auto text-center">
                        <img src="{{ asset('assets/image/upload/bordir/bordir-3.jpg') }}" alt="Image Bordir" style="width: 150px;height: 150px;object-fit: cover;background-position: center;border-radius: 100%;">
                    </div>
                    <div class="col-6 col-md-auto text-center">
                        <img src="{{ asset('assets/image/upload/bordir/bordir-4.jpg') }}" alt="Image Bordir" style="width: 150px;height: 150px;object-fit: cover;background-position: center;border-radius: 100%;">
                    </div>
                </div>
        
                <article class="p-3 bg-white my-4">
                    Embroidery (or needlework) is the art of decorating fabric using a needle and thread to create beautiful motifs or designs, it can be done manually (by hand) or using modern embroidery machines which are sometimes computer-assisted, adding texture and aesthetic value to clothing, logos, or decorations, often using additional materials such as sequins, beads, or cord for variation.
                </article>
            </section>
        
        </div>

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

@if ($product_showcase)
    @if (count($product_showcase) >= 3)
    <div class="p-0 m-0" style="display: flex;justify-content: center;align-items: center;">
        <div class="gallery">
            <div class="left">
                <a href="{{ route('showcase.detail', ['slug' => $product_showcase[0]['slug']]) }}">
                    <img src="{{ asset('assets/image/upload/product/'.$product_showcase[0]['image']) }}" class="border-right" alt="Image {{ $product_showcase[0]['name'] }}">
                </a>
            </div>
            <div class="right">
                <a href="{{ route('showcase.detail', ['slug' => $product_showcase[1]['slug']]) }}">
                    <img src="{{ asset('assets/image/upload/product/'.$product_showcase[1]['image']) }}" class="border-bottom" alt="Image {{ $product_showcase[1]['name'] }}">
                </a>
                <a href="{{ route('showcase.detail', ['slug' => $product_showcase[2]['slug']]) }}">
                    <img src="{{ asset('assets/image/upload/product/'.$product_showcase[2]['image']) }}" class="" alt="Image {{ $product_showcase[2]['name'] }}">
                </a>
            </div>
        </div>
    </div>
    @endif
@endif --}}
{{-- 

<section class="instagram position-relative border-bottom">
    <div class="row g-0">
        @if ($product_showcase && count($product_showcase) > 3)
            @foreach (array_slice($product_showcase, 3) as $item)
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