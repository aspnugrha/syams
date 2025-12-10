@extends('frontend.email.layouts.email-app')
@section('content')
    <div class="header" style="padding: 25px;margin-bottom: 20px;">
        <a class="text-decoration-none" href="{{ route('home') }}">
            <img src="{{ asset($company_profile && $company_profile->logo ? 'assets/image/upload/logo/'.$company_profile->logo : 'assets/image/logo-syams.png') }}" alt="{{ ($company_profile && $company_profile->name ? $company_profile->name : 'Syams Manufacturing') }} Logo" style="width: 140px;">
        </a>
    </div>
    <div class="border-bottom" style="padding: 0 25px 80px 25px;">

        <h2 class="header-text" style="margin: 0 0 25px 0;">Hallo, {{ $customer->name }}!</h2>
        <p style="margin: 0 0 10px 0;font-size: 15px;">Don't worry, your account will be restored in one step. Please click the button below to prepare your account for recovery.</p>
        <div style="width: 100%;display: flex;justify-content: center;margin-top: 50px;">
            <a href="{{ $url }}" target="_blank" class="btn" style="background-color: #212529;color: white;padding: 10px 20px;text-decoration: none;">SET UP MY ACCOUNT</a>
        </div>
    </div>
@endsection