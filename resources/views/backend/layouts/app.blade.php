<!DOCTYPE html>
<html lang="en">
<head>
    <title>Syams Manufacturing</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="ecommerce,fashion,store">
    <meta name="description" content="ecommerce,fashion,store manufacturing">
    <meta name="author" content="aspnugrha">

    <!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $company_profile = App\Models\CompanyProfile::first();
        // dd($company_profile);
    @endphp

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset($company_profile && $company_profile->pavicon ? 'assets/image/upload/pavicon/'.$company_profile->pavicon : 'assets/image/logo-syams.jpg') }}" type="image/x-icon"> 
    
    <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Marcellus&display=swap" rel="stylesheet">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/backend') }}/fonts/tabler-icons.min.css" >
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/backend') }}/fonts/feather.css" >
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/backend') }}/fonts/fontawesome.css" >
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/backend') }}/fonts/material.css" >
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('assets/backend') }}/css/style.css" id="main-style-link" >
    <link rel="stylesheet" href="{{ asset('assets/backend') }}/css/style-preset.css" >
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/backend') }}/css/custom.css" >

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    {{-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet"> --}}
    
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@icon/themify-icons@1.0.1-alpha.3/themify-icons.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    
    @yield('styles')
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <div id="page-loader" class="custom-loader-overlay">
      <div class="custom-smoke"></div>
      <div style="text-align:center; z-index:10;">
        <div class="custom-spinner"></div>
        <div class="custom-loader-text">Loading...</div>
      </div>
    </div>
 
    @include('backend.layouts.sidebar')

    @include('backend.layouts.navbar')



    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
        
            @include('backend.layouts.breadcrumb')

            @yield('content')
        </div>
    </div>
    
    @include('backend.layouts.footer')
    @include('backend.layouts.modals')

  <script src="{{ asset('assets/frontend') }}/js/jquery.min.js"></script>
  <!-- [Page Specific JS] start -->
  {{-- <script src="{{ asset('assets/backend') }}/js/plugins/apexcharts.min.js"></script>
  <script src="{{ asset('assets/backend') }}/js/pages/dashboard-default.js"></script> --}}
  <!-- [Page Specific JS] end -->
  <!-- Required Js -->
  <script src="{{ asset('assets/backend') }}/js/plugins/popper.min.js"></script>
  <script src="{{ asset('assets/backend') }}/js/plugins/simplebar.min.js"></script>
  <script src="{{ asset('assets/backend') }}/js/plugins/bootstrap.min.js"></script>
  <script src="{{ asset('assets/backend') }}/js/fonts/custom-font.js"></script>
  <script src="{{ asset('assets/backend') }}/js/pcoded.js"></script>
  <script src="{{ asset('assets/backend') }}/js/plugins/feather.min.js"></script>
  <script>layout_change('light');</script>
  <script>change_box_container('false');</script>
  <script>layout_rtl_change('false');</script>
  <script>preset_change("preset-1");</script>
  <script>font_change("Public-Sans");</script>

  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
  
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

    function logout(){
      Swal.fire({
          title: "Confirmation",
          text: "Are you sure you want to leave?",
          showDenyButton: false,
          showCancelButton: true,
          confirmButtonText: "Yes, please",
          // denyButtonText: `Don't save`
      }).then((result) => {
          if (result.isConfirmed) {
              $('#btn-logout').text('Please Wait...').prop('disabled', true)
              var postData = new FormData($('#form-logout')[0]);
              $.ajax({
                  url: "{{ route('paneladmin.logout') }}",
                  type: "POST",
                  data: postData,
                  processData: false,
                  contentType: false,
                  cache: false,
                  success: function(res) {
                      console.log(res)
                      if(res.success){
                        showToastr('toast-top-right', 'success', res.message)
                        setTimeout(() => {
                          window.location.href = "{{ route('home') }}"
                        }, 1000);
                      }else{
                        showToastr('toast-top-right', 'error', res.message)
                      }
                  },
                  error:function(res){
                      console.log('error', res);
                  },
                  complete: function(){
                    $('#btn-logout').text('Logout').prop('disabled', false)
                  }
              });
          }
      });
  }
  </script>

  @yield('scripts')
</body>
</html>