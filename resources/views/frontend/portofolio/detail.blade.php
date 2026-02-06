@extends('frontend.layouts.app')

@section('content')
{{-- <img class="responsive-img" src="{{ asset($product->cover ? 'assets/image/upload/product/'.$product->cover : 'https://via.assets.so/img.jpg?w=400&h=300&bg=e5e7eb&text=+&f=png') }}" alt="Cover Product" style="width: 100%;height: 100vh;object-fit: cover;"> --}}
<img class="responsive-img" src="{{ asset('assets/image/upload/banner/banner-showcase.png') }}" alt="Cover Product" style="width: 100%;height: 100vh;object-fit: cover;">

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
    <div class="col-md-5">
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
    <div class="col-md-7">
      <small class="text-muted">{{ ($product->hasCategory ? $product->hasCategory->name : '') }}</small>
      <h4>{{ $product->name }}</h4>

      <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active"
                    id="material-color-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#material-color"
                    type="button"
                    role="tab">
                    {{-- <i class="mdi mdi-palette-swatch-variant"></i> --}}
                Material & Color
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link"
                    id="sablon-type-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#sablon-type"
                    type="button"
                    role="tab">
                    {{-- <i class="mdi mdi-printer-3d-nozzle"></i> --}}
                Sablon Type
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link"
                    id="size-qty-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#size-qty"
                    type="button"
                    role="tab">
                    {{-- <i class="mdi mdi-ruler"></i> --}}
                Size & Quantity
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link"
                    id="bordir-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#bordir"
                    type="button"
                    role="tab">
                    {{-- <i class="mdi mdi-wizard-hat"></i> --}}
                Provide Bordir
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content p-3" id="myTabContent" style="background-color: #fcfcfc;">
        <div class="tab-pane fade show active" id="material-color" role="tabpanel">
          <table class="w-100 table table-bordered">
            <tr>
              <td style="width: 150px;">Material Options</td>
              <td>Color Options</td>
            </tr>
            @php
                $material_color = json_decode($product->material_color_options);
            @endphp
            @if ($product->material_color_options)
                @foreach ($material_color as $item)
                <tr>
                  <td>{{ $item->name }}</td>
                  <td>
                    @if (count($item->colors))
                      @foreach ($item->colors as $color)
                      {{-- <p class="p-0 m-0" style="vertical-align: middle;">
                        @if (isset($color->color_code))
                        <label style="width: 35px;height: 35px;border-radius: 100%;background-color: {{ $color->color_code }};"></label>
                        @else
                        <img src="{{ asset('assets/image/upload/product/material/'.$color->color_image) }}" alt="Color {{ $color->color }} Image" style="width: 35px;height: 35px;border-radius: 100%;">
                        @endif
                        &nbsp;{{ $color->color }}
                      </p> --}}
                      <label class="btn btn-outline-secondary rounded-pill fw-semibold d-inline-flex justify-content-start align-items-center mb-1" style="font-size: 13px;padding: 4px 5px;">
                          @if (isset($color->color_code))
                          <span style="width: 35px;height: 35px;border-radius: 100%;background-color: {{ $color->color_code }};"></span>
                          @else
                          <img src="{{ asset('assets/image/upload/product/material/'.$color->color_image) }}" alt="Color {{ $color->color }} Image" style="width: 35px;height: 35px;border-radius: 100%;">
                          @endif
                          &nbsp;{{ $color->color }}
                      </label>
                      @endforeach
                    @endif
                  </td>
                </tr>
                @endforeach
            @endif
          </table>
        </div>

        <div class="tab-pane fade" id="sablon-type" role="tabpanel">
          {{-- <div class="py-2 px-3 mb-3" style="border: 1px solid #ddd;"> --}}
            @if (in_array('Screen Printing', explode(',', $product->sablon_type)))
            <div class="mb-3">
              <h5>Screen Printing</h5>
              <article>
                Screen printing or sablon is a printing technique that uses a screen as a stencil to transfer ink to a surface such as cloth, paper, or plastic, producing sharp, brightly colored, and durable images, often used for t-shirts, with the process of creating a pattern on the screen before the ink is applied using a squeegee. This technique is popular because of its high-quality and durable prints, although the initial preparation is complex, especially for multi-colored designs.
              </article>
            </div>
            @endif
            @if (in_array('DTF', explode(',', $product->sablon_type)))
            <div class="mb-3">
              <h5>Direct To Film</h5>
              <article>
                DTF (Direct to Film) is a modern digital screen printing technique that prints designs onto special PET films using textile inks, then transfers them to various types of fabrics (cotton, polyester, etc.) with the help of powder glue (hotmelt powder) and a heat press machine, producing sharp prints, bright colors, flexibility, and durability, suitable for various media and single or mass production.
              </article>
            </div>
            @endif
          {{-- </div> --}}
        </div>

        <div class="tab-pane fade" id="size-qty" role="tabpanel">
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

        <div class="tab-pane fade" id="bordir" role="tabpanel">
            {{-- <div class="py-2 px-3 mb-3" style="border: 1px solid #ddd;"> --}}
              <div class="mb-3">
                <h5>Bordir</h5>
                <article>
                  Embroidery (or needlework) is the art of decorating fabric using a needle and thread to create beautiful patterns or designs. It can be done manually or using a computer embroidery machine for faster and more precise results, adding aesthetic value to clothing or other textile products, and can be combined with other materials such as sequins and beads for variety.
                </article>
              </div>
            {{-- </div> --}}
        </div>
    </div>

      {{-- @if ($product->material_color_options)
      <button class="btn btn-default w-100 text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMaterialColor" aria-expanded="false" aria-controls="collapseMaterialColor" style="border: 1px solid #ddd;">
        Material & Color
      </button>
      <div class="collapse mt-2" id="collapseMaterialColor">
        <table class="w-100 table table-bordered">
          <tr>
            <td>Material Options</td>
            <td>Color Options</td>
          </tr>
          @php
              $material_color = json_decode($product->material_color_options);
          @endphp
          @if ($material_color)
              @foreach ($material_color as $item)
              <tr>
                <td>{{ $item->material }}</td>
                <td>
                  @if (count($item->colors))
                    @foreach ($item->colors as $color)
                    <p class="p-0 m-0" style="vertical-align: middle;">
                      <label style="width: 18px;height: 18px;border-radius: 100%;background-color: {{ $color->color_code }};"></label> {{ $color->color }}
                    </p>
                    @endforeach
                  @endif
                </td>
              </tr>
              @endforeach
          @endif
        </table>
      </div>
      @endif
      @if ($product->sablon_type)
      <button class="btn btn-default w-100 text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSablonType" aria-expanded="false" aria-controls="collapseSablonType" style="border: 1px solid #ddd;">
        Sablon Type
      </button>
      <div class="collapse mt-2" id="collapseSablonType">
        <div class="py-2 px-3 mb-3" style="border: 1px solid #ddd;">
          @if (in_array('Screen Printing', explode(',', $product->sablon_type)))
          <div class="mb-3">
            <h5>Screen Printing</h5>
            <article>
              Screen printing or sablon is a printing technique that uses a screen as a stencil to transfer ink to a surface such as cloth, paper, or plastic, producing sharp, brightly colored, and durable images, often used for t-shirts, with the process of creating a pattern on the screen before the ink is applied using a squeegee. This technique is popular because of its high-quality and durable prints, although the initial preparation is complex, especially for multi-colored designs.
            </article>
          </div>
          @endif
          @if (in_array('DTF', explode(',', $product->sablon_type)))
          <div class="mb-3">
            <h5>Direct To Film</h5>
            <article>
              DTF (Direct to Film) is a modern digital screen printing technique that prints designs onto special PET films using textile inks, then transfers them to various types of fabrics (cotton, polyester, etc.) with the help of powder glue (hotmelt powder) and a heat press machine, producing sharp prints, bright colors, flexibility, and durability, suitable for various media and single or mass production.
            </article>
          </div>
          @endif
        </div>
      </div>
      @endif
      <button class="btn btn-default w-100 text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="border: 1px solid #ddd;">
        Size & Quantity
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
      @if ($product->is_bordir)
      <button class="btn btn-default w-100 text-start" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBordir" aria-expanded="false" aria-controls="collapseBordir" style="border: 1px solid #ddd;">
        Provide Bordir
      </button>
      <div class="collapse mt-2" id="collapseBordir">
        <div class="py-2 px-3 mb-3" style="border: 1px solid #ddd;">
          <div class="mb-3">
            <h5>Bordir</h5>
            <article>
              Embroidery (or needlework) is the art of decorating fabric using a needle and thread to create beautiful patterns or designs. It can be done manually or using a computer embroidery machine for faster and more precise results, adding aesthetic value to clothing or other textile products, and can be combined with other materials such as sequins and beads for variety.
            </article>
          </div>
        </div>
      </div>
      @endif --}}

      <article class="my-3">{!! $product->description !!}</article>

      @if ($product->type == 'ORDER')
      <a href="{{ route('order').'?order_type=SAMPLE&product='.\App\Helpers\CodeHelper::encodeCode($product->id) }}" class="btn btn-dark text-uppercase mt-3"><i class="ti ti-hand-open"></i> Sample</a>
      <a href="{{ route('order').'?order_type=ORDER&product='.\App\Helpers\CodeHelper::encodeCode($product->id) }}" class="btn btn-dark text-uppercase mt-3"><i class="ti ti-shopping-cart"></i> Order</a>
      @endif

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