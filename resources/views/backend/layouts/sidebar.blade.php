<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="{{ route('paneladmin.dashboard') }}" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img src="{{ asset($company_profile && $company_profile->logo ? 'assets/image/upload/logo/'.$company_profile->logo : 'assets/image/logo-syams.png') }}" class="img-fluid logo-lg" alt="logo" style="height: 30px;">
      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-item">
          <a href="{{ route('paneladmin.dashboard') }}" class="pc-link">
            <span class="pc-micon"><i class="mdi mdi-view-dashboard-outline"></i></span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
          <label>Master Data</label>
          <i class="ti ti-dashboard"></i>
        </li>
        <li class="pc-item">
          <a href="{{ route('master-user.index') }}" class="pc-link">
            <span class="pc-micon"><i class="mdi mdi-shield-account"></i></span>
            <span class="pc-mtext">Master User</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{ route('product.index') }}" class="pc-link">
            <span class="pc-micon"><i class="mdi mdi-tshirt-crew-outline"></i></span>
            <span class="pc-mtext">Product</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
          <label>Customer</label>
          <i class="ti ti-news"></i>
        </li>
        <li class="pc-item">
          <a href="{{ route('paneladmin.master-customer.index') }}" class="pc-link">
            <span class="pc-micon"><i class="mdi mdi-account-group-outline"></i></span>
            <span class="pc-mtext">Master Customer</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{ route('paneladmin.order.index') }}" class="pc-link">
            <span class="pc-micon"><i class="mdi mdi-cart-arrow-down"></i></span>
            <span class="pc-mtext">Order</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
          <label>Utilities</label>
          <i class="ti ti-news"></i>
        </li>
        <li class="pc-item">
          @php
            $encode = App\Helpers\CodeHelper::encodeCode('CPNPFL20000000rtg8ly');
          @endphp
          <a href="{{ route('company-profile.edit', $encode) }}" class="pc-link">
            <span class="pc-micon"><i class="mdi mdi-domain"></i></span>
            <span class="pc-mtext">Company Profile</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{ route('paneladmin.documentation.index') }}" class="pc-link">
            <span class="pc-micon"><i class="mdi mdi-book-open-page-variant-outline"></i></span>
            <span class="pc-mtext">Documentation</span>
          </a>
        </li>
        {{-- <li class="pc-item">
          <a href="{{ asset('assets/backend') }}/pages/register.html" class="pc-link">
            <span class="pc-micon"><i class="mdi mdi-book-open-page-variant-outline"></i></span>
            <span class="pc-mtext">Landing Pages</span>
          </a>
        </li> --}}

      </ul>
    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end --> 