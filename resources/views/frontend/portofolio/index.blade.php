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
            // 'description' => 'Screen printing or sablon is a printing technique that uses a screen as a stencil to transfer ink to a surface such as cloth, paper, or plastic, producing sharp, brightly colored, and durable images, often used for t-shirts, with the process of creating a pattern on the screen before the ink is applied using a squeegee. This technique is popular because of its high-quality and durable prints, although the initial preparation is complex, especially for multi-colored designs.',
            'description' => 'Screen printing or sablon is a printing technique that uses a screen as a stencil to transfer ink to a surface such as cloth, paper, or plastic, producing sharp, brightly colored, and durable images, often used for t-shirts, with the process of creating a pattern on the screen before the ink is applied using a squeegee.',
            'image' => 'sablon.jpg',
            'examples' => [
                [
                    'image' => 'plastisol.png',
                    'name' => 'Plastisol',
                    'description' => 'Is a PVC-based ink that stands as the industry standard in screen printing.',
                ],
                [
                    'image' => 'discharge.png',
                    'name' => 'Discharge',
                    'description' => 'Is a printing technique that works by altering the color of the fabric itself.',
                ],
                [
                    'image' => 'high-destiny.png',
                    'name' => 'High Destiny',
                    'description' => 'Is a variation of plastisol that is printed with extra thickness using a special, thicker emulsion on the screen.',
                ],
                [
                    'image' => 'puff-ink.png',
                    'name' => 'Puff Ink',
                    'description' => 'Is a specialized ink containing an expanding agent in its formula.',
                ],
            ],
        ],
        [
            'name' => 'Direct to Film',
            'description' => 'DTF (Direct to Film) is a modern digital screen printing technique that prints designs onto special PET films using textile inks, then transfers them to various types of fabrics (cotton, polyester, etc.) with the help of powder glue (hotmelt powder) and a heat press machine, producing sharp prints, bright colors, flexibility, and durability, suitable for various media and single or mass production.',
            'image' => 'dtf.jpg',
            'examples' => [
                [
                    'image' => 'sublimation.png',
                    'name' => 'Sublimation',
                    'description' => 'Is a printing process that uses heat to transfer dye from a special paper medium (sublimation paper) directly onto the material.',
                ],
                [
                    'image' => 'dtf2.png',
                    'name' => 'DTF',
                    'description' => 'The main advantages of DTF Printing lie in its flexibility, as it can print full-color and detailed designs on almost all textile types.',
                ],
            ],
        ],
    ];

    $material_colors = json_decode(json_encode($material_colors));
    $sablons = json_decode(json_encode($sablons));
@endphp

{{-- <img class="responsive-img" src="{{ asset('assets/image/upload/landing_page/bg-7.jpg') }}" alt="Banner" style="width: 100%;height: 100vh;object-fit: cover;"> --}}

@php
    $banner = json_decode($company->banner, true);
@endphp
@if ($banner)
<img class="responsive-img" src="{{ asset('assets/image/upload/banner/'.$banner['banner_showcase']) }}" alt="Banner" style="width: 100%;height: 100vh;object-fit: cover;">
@else
<img class="responsive-img" src="{{ asset('assets/image/upload/banner/banner-showcase.png') }}" alt="Banner" style="width: 100%;height: 100vh;object-fit: cover;">
@endif

<div class="bg-light">
    <div class="container pt-4">
        <div class="row g-1 pb-5">
            <h4 class="mb-3">Showcase</h4>
            @foreach($product_showcase as $item)
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
            {{-- <a href="{{ route('showcase.detail', $item->slug) }}" class="col-6 col-md-3">
                <div class="card text-white border-0 position-relative rounded-0" style="overflow:hidden;">
                    <img src="{{ $item->image ? asset('assets/image/upload/product/'.explode(',', $item->image)[0]) : 'https://via.assets.so/img.jpg?w=800&h=800&bg=ddd' }}" class="card-img rounded-0" alt="Product" style="width: 100%;height: 280px;object-fit: cover;">

                    <div class="position-absolute bottom-0 start-0 w-100 p-3"
                        style="background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));">

                        <p class="mb-1 p-0" style="font-size: 0.7rem; opacity: 0.9;">{{ ($item->hasCategory ? $item->hasCategory->name : '') }}</p>
                        <h5 class="m-0 p-0" style="font-size: .95rem;">{{ $item->name }}</h5>

                    </div>
                </div>
            </a> --}}
            @endforeach
        </div>
        <div class="row g-1 pb-3">
            <h4 class="mb-3">Order</h4>
            @foreach($product_order as $item)
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
            {{-- <a href="{{ route('showcase.detail', $item->slug) }}" class="col-6 col-md-3">
                <div class="card text-white border-0 position-relative rounded-0" style="overflow:hidden;">
                    <img src="{{ $item->image ? asset('assets/image/upload/product/'.explode(',', $item->image)[0]) : 'https://via.assets.so/img.jpg?w=800&h=800&bg=ddd' }}" class="card-img rounded-0" alt="Product" style="width: 100%;height: 280px;object-fit: cover;">

                    <div class="position-absolute bottom-0 start-0 w-100 p-3"
                        style="background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));">

                        <p class="mb-1 p-0" style="font-size: 0.7rem; opacity: 0.9;">{{ ($item->hasCategory ? $item->hasCategory->name : '') }}</p>
                        <h5 class="m-0 p-0" style="font-size: .95rem;">{{ $item->name }}</h5>

                    </div>
                </div>
            </a> --}}
            @endforeach
        </div>
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
        
                <div class="row g-1">
                    @foreach ($materials as $index_material => $item)
                    @if ($index_material <= 3)
                    <div class="col-md-6">
                        <div class="material-info p-3 bg-white h-100">
                            <small class="text-muted">Material</small>
                            <h5 class="mb-1">{{ $item->name }}</h5>
    
                            <small class="text-muted">Available Colors</small>
                            @if ($item->colors)
                                <div class="mb-2 mt-1 d-flex flex-wrap w-100">
                                    @foreach ($item->colors as $index_color => $color)
                                        @if ($index_color <= 2)
                                        <label class="btn btn-outline-secondary fw-semibold rounded-pill d-inline-flex align-items-center mb-1 me-1" style="font-size: 13px;padding: 4px 5px;">
                                            @if (isset($color->color_code))
                                            <span style="width: 35px;height: 35px;background-color: {{ $color->color_code }};border-radius: 100%;"></span>
                                            @else
                                            <img src="{{ asset('assets/image/upload/product/material/'.$color->color_image) }}" alt="Color {{ $color->color }} Image" style="width: 35px;height: 35px;border-radius: 100%;">
                                            @endif
                                            &nbsp;{{ $color->color }}
                                        </label>
                                        @endif
                                    @endforeach
                                    @if (count($item->colors) > 3)
                                        <a href="#modal-custom" class="btn btn-outline-secondary fw-semibold rounded-pill d-inline-flex align-items-center mb-1 me-1" style="font-size: 13px;padding: 4px 5px;" onclick='seeMoreColor(@json($item))'>
                                            <span class="mdi mdi-arrow-right align-content-center" style="height: 35px;font-size: 20px;"></span>
                                            &nbsp;See {{ count($item->colors) - 3 }} more
                                        </a>
                                    @endif
                                </div>
                            @else
                                <small class="text-muted">No colors available yet</small>
                            @endif
    
                            <article>{{ $item->desc ? $item->desc : 'No Description' }}</article>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @if (count($materials) > 3)
                    <a href="{{ route('showcase.all-materials') }}" class="btn btn-dark"><i class="mdi mdi-arrow-right"></i> See More</a>
                    @endif
                    {{-- @foreach ($material_colors as $item)
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
                    @endforeach --}}
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
                        <div class="row mb-1 g-0 bg-white">
                            <div class="col-md-4 p-3">
                                <img src="{{ asset('assets/image/upload/sablon/'.$item->image) }}" alt="Image {{ $item->name }}" class="w-100 w-md-40" style="height: 100%;height: 100%;object-fit: cover;background-position: center;">
                            </div>
                            <div class="col-md-8">
                                <div class="p-3">
                                    <small class="text-muted">Printing Type</small>
                                    <h5 class="mb-1">{{ $item->name }}</h5>
                                    <article>{{ $item->description }}</article>
                                    <div class="row g-1 bg-white mt-3 mb-1">
                                        @foreach ($item->examples as $example)
                                        <div class="col-md-6">
                                            <div class="row g-2">
                                                <div class="col-4">
                                                    <img class="rounded" src="{{ asset('assets/image/upload/sablon/'.$example->image) }}" alt="{{ $example->name }}" style="width: 100%;height: 100px;object-fit: cover;">
                                                </div>
                                                <div class="col-8">
                                                    <p class="p-0 mb-0 fw-semibold" style="color: #555;">{{ $example->name }}</p>
                                                    <p class="p-0 mb-0">{!! $example->description !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row g-0 mb-1 bg-white">
                            <div class="col-md-8">
                                <div class="p-3">
                                    <small class="text-muted">Printing Type</small>
                                    <h5 class="mb-1">{{ $item->name }}</h5>
                                    <article>{{ $item->description }}</article>
                                    <div class="row g-1 bg-white mt-3 mb-1">
                                        @foreach ($item->examples as $example)
                                        <div class="col-md-6">
                                            <div class="row g-2">
                                                <div class="col-4">
                                                    <img class="rounded" src="{{ asset('assets/image/upload/sablon/'.$example->image) }}" alt="{{ $example->name }}" style="width: 100%;height: 100px;object-fit: cover;">
                                                </div>
                                                <div class="col-8">
                                                    <p class="p-0 mb-0 fw-semibold" style="color: #555;">{{ $example->name }}</p>
                                                    <p class="p-0 mb-0">{!! $example->description !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 p-3">
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
        
                {{-- <div class="row justify-content-center mb-3 g-4">
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
                    Embroidery (or needlework) is the art of decorating fabric using a needle and thread to create beautiful motifs or designs, it can be done manually (by hand) or using modern embroidery machines which are sometimes computer-assisted, adding texture and aesthetic value to clothing, logos, or decorations, often using additional materials such as sequins, beads, or cord for variation. <br>
                    Embroidery options: <b>3D</b>, <b>Patch</b> and <b>Regular</b>.
                </article> --}}

                <div class="row justify-content-center mb-3 g-1">
                    <div class="col-md-6">
                        <div class="row g-1">
                            <div class="col-md-5">
                                <img src="{{ asset('assets/image/upload/bordir/3d.png') }}" alt="Image Bordir" style="width: 100%;height: 100%;object-fit: cover;background-position: center;">
                            </div>
                            <div class="col-md-7">
                                <div class="card w-100 rounded-0 border-0">
                                    <div class="card-body">
                                        <h5 class="mb-1">3D</h5>
                                        <article style="max-height: 270px;min-height: 270px;overflow-y: auto;">
                                            <p>3D embroidery is a specialized embroidery technique that uses foam padding underneath the stitches to create a very pronounced embossed or raised effect. The process involves placing EVA foam with a thickness of 2-4mm on top of the fabric before the embroidery process begins.</p>
                                            <p>This foam is then sewn together with the fabric, and the embroidery machine will stitch through the foam following the design pattern. After the embroidery is complete, the foam not covered by stitches (the area outside the design) is cut or torn manually or by using a heat gun to melt it. The result is an embroidery design that is highly prominent and dimensional.</p>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row g-1">
                            <div class="col-md-5">
                                <img src="{{ asset('assets/image/upload/bordir/towel.png') }}" alt="Image Bordir" style="width: 100%;height: 100%;object-fit: cover;background-position: center;">
                            </div>
                            <div class="col-md-7">
                                <div class="card w-100 rounded-0 border-0">
                                    <div class="card-body">
                                        <h5 class="mb-1">Towel</h5>
                                        <article style="max-height: 270px;min-height: 270px;overflow-y: auto;">Towel embroidery is a specialized technique that produces a furry or fuzzy texture resembling a towel or carpet. This technique uses special chenille yarn that is thicker and possesses fine fibers on its surface, or utilizes a chain stitch.</article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row g-1">
                            <div class="col-md-5">
                                <img src="{{ asset('assets/image/upload/bordir/regular.png') }}" alt="Image Bordir" style="width: 100%;height: 100%;object-fit: cover;background-position: center;">
                            </div>
                            <div class="col-md-7">
                                <div class="card w-100 rounded-0 border-0">
                                    <div class="card-body">
                                        <h5 class="mb-1">Regular</h5>
                                        <article style="max-height: 270px;min-height: 270px;overflow-y: auto;">Regular embroidery is the most commonly used standard embroidery technique, utilizing normal stitch density to produce a surface that is relatively flat or slightly raised from the fabric. Regular embroidery can be applied to almost any type of fabric, ranging from thin materials like polo shirts to thick ones like jackets, by adjusting the type of backing and stabilizer used.</article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row g-1">
                            <div class="col-md-5">
                                <img src="{{ asset('assets/image/upload/bordir/velcro-patch.png') }}" alt="Image Bordir" style="width: 100%;height: 100%;object-fit: cover;background-position: center;">
                            </div>
                            <div class="col-md-7">
                                <div class="card w-100 rounded-0 border-0">
                                    <div class="card-body">
                                        <h5 class="mb-1">Velcro Patches</h5>
                                        <article style="max-height: 270px;min-height: 270px;overflow-y: auto;">Velcro Patches are badges that feature a hook backing, allowing them to be instantly attached and detached from jackets, bags, or other garments that have a corresponding loop surface. Their main advantage is high flexibility. These patches are often used on coach jackets, leather jackets, backpacks, and hats to add an eye-catching accent, enabling the wearer to quickly and easily change their outfit's appearance according to their mood or event.</article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            
            <!-- SECTION 04 -->
            <section class="section">
                <div class="row align-items-start mb-4">
                    <div class="col-auto">
                        <div class="section-number">04</div>
                    </div>
                    <div class="col">
                        <div class="section-title fw-semibold">OTHERS</div>
                        <div class="section-subtitle">
                            We provide other services on request.
                        </div>
                    </div>
                </div>
                
                <div class="row justify-content-center mb-3 g-1">
                    <div class="col-md-6">
                        <div class="row g-1">
                            <div class="col-md-5">
                                <img src="{{ asset('assets/image/upload/others/rhinestone.png') }}" alt="Image Others" style="width: 100%;height: 100%;object-fit: cover;background-position: center;">
                            </div>
                            <div class="col-md-7">
                                <div class="card w-100 rounded-0 border-0">
                                    <div class="card-body">
                                        <h5 class="mb-1">Rhinestone</h5>
                                        <article style="max-height: 270px;min-height: 270px;overflow-y: auto;">The use of rhinestones is a fantastic way to instantly elevate the look of clothing. These shimmering stones are not just decorations; they provide a dramatic sense of glamor and luxury, making plain clothes or simple designs look far more exclusive and eye-catching (a true statement piece). The sparkle reflected by the rhinestones can lend a cool and unique visual dimension to any outfit.</article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row g-1">
                            <div class="col-md-5">
                                <img src="{{ asset('assets/image/upload/others/distress.png') }}" alt="Image Others" style="width: 100%;height: 100%;object-fit: cover;background-position: center;">
                            </div>
                            <div class="col-md-7">
                                <div class="card w-100 rounded-0 border-0">
                                    <div class="card-body">
                                        <h5 class="mb-1">Distress</h5>
                                        <article style="max-height: 270px;min-height: 270px;overflow-y: auto;">
                                            <p>Distressing in fashion is a deliberate finishing process applied to fabric or garments to create a worn-out, old, faded, or torn look. This technique mimics the natural damage that occurs over time and through use, often achieved through harsh washing processes, abrasion, or mechanical tearing.</p>
                                            <p>This distressing effect significantly adds an edgy feel to the fashion being worn. With its imperfect and rugged appearance, distressing imparts a vibe of rebellion, cool casualness, and authentic vintage style. Distressed garments, such as faded hoodies or ripped jeans, immediately become a statement piece that attracts attention, radiating an aura of <i>effortlessly cool</i> and <i>anti-establishment</i>.</p>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <img src="{{ asset('assets/image/upload/others/velcro-patch.png') }}" alt="Image Others" style="width: 100%;height: 350px;object-fit: cover;background-position: center;">
                        <div class="card w-100 rounded-0 border-0">
                            <div class="card-body">
                                <h5 class="mb-1">Velcro Patches</h5>
                                <article>Velcro Patches are badges that feature a hook backing, allowing them to be instantly attached and detached from jackets, bags, or other garments that have a corresponding loop surface. Their main advantage is high flexibility. These patches are often used on coach jackets, leather jackets, backpacks, and hats to add an eye-catching accent, enabling the wearer to quickly and easily change their outfit's appearance according to their mood or event.</article>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </section>
        
        </div>

    </div>
</div>
@section('modal_header_text', 'Material Details')
@section('modal_body')
<div class="w-100" id="modal-custom-body" style="max-height: 80vh;overflow: scroll;">
    <div class="mb-2">
        <label>Material :</label>
        <h5 id="modal-material-name"></h5>
    </div>
    <div class="mb-2">
        <label>Description :</label>
        <p id="modal-material-desc" style="font-size: 16px;color: #555;"></p>
    </div>
    <div class="mb-2">
        <label>Available Colors :</label>
        <div id="modal-material-colors"></div>
    </div>
</div>
@endsection
@include('frontend.layouts.modal')

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
<script>
function seeMoreColor(item){
    console.log(item);
    $('#modal-material-name').text(item.name);
    $('#modal-material-desc').text(item.desc ?? 'No Description');

    let html_colors = `
    <div class="mb-2 mt-1 d-flex flex-wrap w-100">`;
        item.colors.forEach(color => {
            html_colors += `
            <label class="btn btn-outline-secondary fw-semibold rounded-pill d-inline-flex align-items-center mb-1 me-1" style="font-size: 13px;padding: 4px 5px;">`;
            if (color.color_code !== undefined && color.color_code !== null) {
                html_colors += `<span style="width: 35px;height: 35px;background-color: ${color.color_code};border-radius: 100%;"></span>`;
            }else{
                html_colors += `<img src="{{ asset('assets/image/upload/product/material') }}/${color.color_image}" alt="Color ${color.color} Image" style="width: 35px;height: 35px;border-radius: 100%;">`;
            }

            html_colors += `&nbsp;${color.color}</label>`;
        });
    html_colors += `</div>`;
    $('#modal-material-colors').html(html_colors);
    $('#modal-more-color').modal('show');
}
</script>
@endsection