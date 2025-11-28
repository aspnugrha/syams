<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'Syams Manufacturing')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="TemplatesJungle">
    <meta name="keywords" content="ecommerce,fashion,store">
    <meta name="description" content="ecommerce,fashion,store manufacturing">
    
    @php
      $company_profile = App\Models\CompanyProfile::first();
    @endphp
    <link rel="icon" href="{{ asset($company_profile && $company_profile->pavicon ? 'assets/image/upload/pavicon/'.$company_profile->pavicon : 'assets/image/logo-syams.jpg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend') }}/css/vendor.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend') }}/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Marcellus&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@icon/themify-icons@1.0.1-alpha.3/themify-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        /* Gaya default (mobile) */
      .responsive-img {
        width: 100%;
        height: 100vh; /* 100% tinggi layar di mobile */
        object-fit: cover;
      }

      /* Untuk layar besar (desktop, mulai dari breakpoint lg = 992px) */
      @media (min-width: 992px) {
        .responsive-img {
          height: 100vh; /* 50% tinggi layar */
        }
      }
      .size-badge {
        width: 32px;
        height: 32px;
        border: 1px solid rgba(255, 255, 255, 0.7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        background: rgba(255, 255, 255, 0.0);
      }
      .size-badge-dark {
        width: 32px;
        height: 32px;
        border: 1px solid rgba(53, 53, 53, 0.7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        background: rgba(255, 255, 255, 0.0);
      }

      /* Fullscreen overlay */
      .custom-loader-overlay{
          position:fixed;
          inset:0;
          display:none;
          align-items:center;
          justify-content:center;
          background:rgba(0,0,0,0.45);
          backdrop-filter:blur(1px);
          z-index:9999;
      }

      /* Simple smoke blob */
      .custom-smoke{
          position:absolute;
          width:180px;
          height:180px;
          border-radius:50%;
          background:radial-gradient(circle, rgba(255,255,255,0.25), rgba(255,255,255,0.05), transparent);
          filter:blur(18px);
          animation:float 3.5s ease-in-out infinite;
          opacity:0.55;
      }

      @keyframes float{
          0%,100%{transform:translateY(0)}
          50%{transform:translateY(-18px)}
      }

      /* Spinner */
      .custom-spinner{
          width:60px;
          height:60px;
          border:6px solid rgba(255,255,255,0.2);
          border-top-color:#fff;
          border-radius:50%;
          animation:spin 0.9s linear infinite;
          z-index:10;
      }

      @keyframes spin{to{transform:rotate(360deg)}}

      .custom-loader-text{
          margin-top:15px;
          font-size:14px;
          color:#fff;
          opacity:0.9;
          text-align:center;
      }

      .daterangepicker table tr td{
        border: 1px solid transparent !important;
      }
      .daterangepicker .drp-buttons .applyBtn{
        background-color: #212529;
      }
    </style>
    @yield('styles')
</head>

<body class="homepage">
  @section('title', ($company_profile && $company_profile->name ? $company_profile->name : 'Syams Manufacture'))
  
  <div class="preloader text-white fs-6 text-uppercase overflow-hidden" style="z-index: 9999;"></div>

  <div id="page-loader" class="custom-loader-overlay">
    <div class="custom-smoke"></div>
    <div style="text-align:center; z-index:10;">
      <div class="custom-spinner"></div>
      <div class="custom-loader-text">Loading...</div>
    </div>
  </div>

  <div class="search-popup">
    <div class="search-popup-container">

      <form role="search" method="get" class="form-group" action="">
        <input type="search" id="search-form" class="form-control border-0 border-bottom"
          placeholder="Type and press enter" value="" name="s" />
        <button type="submit" class="search-submit border-0 position-absolute bg-white"
          style="top: 15px;right: 15px;"><svg class="search" width="24" height="24">
            <use xlink:href="#search"></use>
          </svg></button>
      </form>

      <h5 class="cat-list-title">Browse Categories</h5>

      <ul class="cat-list">
        <li class="cat-list-item">
          <a href="#" title="Jackets">Jackets</a>
        </li>
        <li class="cat-list-item">
          <a href="#" title="T-shirts">T-shirts</a>
        </li>
        <li class="cat-list-item">
          <a href="#" title="Handbags">Handbags</a>
        </li>
        <li class="cat-list-item">
          <a href="#" title="Accessories">Accessories</a>
        </li>
        <li class="cat-list-item">
          <a href="#" title="Cosmetics">Cosmetics</a>
        </li>
        <li class="cat-list-item">
          <a href="#" title="Dresses">Dresses</a>
        </li>
        <li class="cat-list-item">
          <a href="#" title="Jumpsuits">Jumpsuits</a>
        </li>
      </ul>

    </div>
  </div>

  @if (
    // Auth::guard('customer')->user() &&
    (
      request()->segment(1) == 'dashboard' ||
      request()->segment(1) == 'my-sample' ||
      request()->segment(1) == 'my-order' ||
      request()->segment(1) == 'profile'
    )
  )
    @include('frontend.layouts.navbar-panel')
    {{-- @include('frontend.layouts.breadcrumb') --}}
  @else
    @include('frontend.layouts.navbar')
  @endif

  @yield('content')

  @include('frontend.layouts.footer')

  <script src="{{ asset('assets/frontend') }}/js/jquery.min.js"></script>
  <script src="{{ asset('assets/frontend') }}/js/plugins.js"></script>
  <script src="{{ asset('assets/frontend') }}/js/SmoothScroll.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="{{ asset('assets/frontend') }}/js/script.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

  <script>
    function showToastr(position, type, message){
      toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": position,
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
      }
      toastr[type](message)
    }
  </script>

  @yield('scripts')
</body>

</html>