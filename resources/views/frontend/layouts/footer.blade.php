<footer id="footer" class="mt-4">
    <div class="container">
        <div class="row d-flex flex-wrap justify-content-between py-5">
            <div class="col-md-3 col-sm-6">
                <div class="footer-menu footer-menu-001">
                    <div class="footer-intro mb-4">
                        <a href="{{ route('home') }}">
                        {{-- <img src="{{ asset('assets/frontend') }}/images/main-logo.png" alt="logo"> --}}
                        <img src="{{ asset($company_profile && $company_profile->logo ? 'assets/image/upload/logo/'.$company_profile->logo : 'assets/image/logo-syams.png') }}" alt="{{ ($company_profile && $company_profile->name ? $company_profile->name : 'Syams Manufacturing') }} Logo" style="max-width: 80px;max-height: 40px;">
                        </a>
                    </div>
                    {{-- <p>Gravida massa volutpat aenean odio. Amet, turpis erat nullam fringilla elementum diam in. Nisi, purus
                        vitae, ultrices nunc. Sit ac sit suscipit hendrerit.</p> --}}
                    <div class="social-links">
                        <ul class="list-unstyled d-flex flex-wrap gap-3">
                            <li>
                                <a href="#" class="text-secondary">
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#facebook"></use>
                                </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-secondary">
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#twitter"></use>
                                </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-secondary">
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#youtube"></use>
                                </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-secondary">
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#pinterest"></use>
                                </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-secondary">
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#instagram"></use>
                                </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-menu footer-menu-002">
                <h5 class="widget-title text-uppercase mb-4">Quick Links</h5>
                {{-- <ul class="menu-list list-unstyled text-uppercase border-animation-left fs-6"> --}}
                <ul class="menu-list list-unstyled border-animation-left fs-6">
                    <li class="menu-item" style="font-size: 15px;">
                    <a href="{{ route('home') }}" class="item-anchor">Home</a>
                    </li>
                    <li class="menu-item" style="font-size: 15px;">
                    <a href="{{ route('showcase') }}" class="item-anchor">Showcase</a>
                    </li>
                    <li class="menu-item" style="font-size: 15px;">
                    <a href="{{ route('about') }}" class="item-anchor">About Us</a>
                    </li>
                    <li class="menu-item" style="font-size: 15px;">
                    <a href="{{ route('contact-us') }}" class="item-anchor">Contact</a>
                    </li>
                    {{-- <li class="menu-item" style="font-size: 15px;">
                    <a href="{{ route('contact-us') }}" class="item-anchor">Service</a>
                    </li> --}}
                    <li class="menu-item mb-4" style="font-size: 15px;">
                    <a href="{{ route('order') }}" class="item-anchor">Order</a>
                    </li>
                </ul>
                </div>
            </div>
            {{-- <div class="col-md-3 col-sm-6">
                <div class="footer-menu footer-menu-002">
                <h5 class="widget-title text-uppercase mb-4">Contact & Order</h5>
                <ul class="menu-list list-unstyled border-animation-left fs-6">
                    <li class="menu-item" style="font-size: 15px;">
                    <a href="{{ route('contact-us') }}" class="item-anchor">Contact</a>
                    </li>
                    <li class="menu-item mb-4" style="font-size: 15px;">
                    <a href="{{ route('order') }}" class="item-anchor">Order</a>
                    </li>
                </ul>
                </div>
            </div> --}}
            <div class="col-md-2 col-sm-6">
                <div class="footer-menu footer-menu-003">
                <h5 class="widget-title text-uppercase mb-4">Policy</h5>
                <ul class="menu-list list-unstyled border-animation-left fs-6">
                    <li class="menu-item" style="font-size: 15px;">
                    <a href="{{ route('policies', 'privacy') }}" class="item-anchor">Privacy</a>
                    </li>
                    <li class="menu-item" style="font-size: 15px;">
                    <a href="{{ route('policies', 'refund') }}" class="item-anchor">Refund</a>
                    </li>
                    <li class="menu-item mb-4" style="font-size: 15px;">
                    <a href="{{ route('policies', 'shipping') }}" class="item-anchor">Shipping</a>
                    </li>
                </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-menu footer-menu-004 border-animation-left">
                    <h5 class="widget-title text-uppercase mb-4">Help & Info</h5>
                    <p style="word-break: break-all;">
                        Do you have any questions or suggestions?
                        <a href="mailto:{{ ($company_profile && $company_profile->email ? $company_profile->email : 'example@email.com') }}"
                        class="item-anchor">{{ ($company_profile && $company_profile->email ? $company_profile->email : 'example@email.com') }}</a>
                        </p>
                    <p>
                        Do you need support? Give us a call. 
                        <a href="tel:+{{ ($company_profile && $company_profile->phone_number ? $company_profile->phone_number : '+62') }}" class="item-anchor">
                        +{{ ($company_profile && $company_profile->phone_number ? $company_profile->phone_number : '+62') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="py-4 bg-light">
        <div class="container">
            <div class="row">
                {{-- <div class="col-md-6 d-flex flex-wrap">
                    <div class="shipping">
                        <span>We ship with:</span>
                        <img src="{{ asset('assets/frontend') }}/images/arct-icon.png" alt="icon">
                        <img src="{{ asset('assets/frontend') }}/images/dhl-logo.png" alt="icon">
                    </div>
                    <div class="payment-option">
                        <span>Payment Option:</span>
                        <img src="{{ asset('assets/frontend') }}/images/visa-card.png" alt="card">
                        <img src="{{ asset('assets/frontend') }}/images/paypal-card.png" alt="card">
                        <img src="{{ asset('assets/frontend') }}/images/master-card.png" alt="card">
                    </div>
                </div> --}}
                <div class="col-md-6">
                    <p class="text-dark p-0 m-0" style="font-size: 14px;">© 2025 {{ ($company_profile && $company_profile->name ? $company_profile->name : 'Syams Manufacturing') }}
                        {{-- <a href="https://templatesjungle.com" target="_blank">TemplatesJungle</a>
                        Distribution By <a href="https://themewagon.com" target="blank">ThemeWagon</a> --}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>