@extends('backend.layouts.app')
@section('content')
<div class="row g-2">
    <a href="{{ route('paneladmin.documentation.show', 'authentication') }}" class="col-md-4">
        <div class="bg-white h-100 p-4 border border-1 rounded d-flex gap-3 justify-content-start align-items-center">
            <div class="icon">
                <p class="m-0 p-0 mdi mdi-shield-lock-open-outline text-info" style="font-size: 50px;"></p>
            </div>
            <div class="detail">
                <h5 class="fw-semibold">Authentication</h5>
                <small class="text-muted">Documentation about authentication system.</small>
            </div>
        </div>
    </a>
    <a href="{{ route('paneladmin.documentation.show', 'dashboard') }}" class="col-md-4">
        <div class="bg-white h-100 p-4 border border-1 rounded d-flex gap-3 justify-content-start align-items-center">
            <div class="icon">
                <p class="m-0 p-0 mdi mdi-view-dashboard-outline text-info" style="font-size: 50px;"></p>
            </div>
            <div class="detail">
                <h5 class="fw-semibold">Dashboard</h5>
                <small class="text-muted">Documentation about dashboard page.</small>
            </div>
        </div>
    </a>
    <a href="{{ route('paneladmin.documentation.show', 'account') }}" class="col-md-4">
        <div class="bg-white h-100 p-4 border border-1 rounded d-flex gap-3 justify-content-start align-items-center">
            <div class="icon">
                <p class="m-0 p-0 mdi mdi-account-outline text-info" style="font-size: 50px;"></p>
            </div>
            <div class="detail">
                <h5 class="fw-semibold">Account</h5>
                <small class="text-muted">Documentation about your account.</small>
            </div>
        </div>
    </a>
    <a href="{{ route('paneladmin.documentation.show', 'master-user') }}" class="col-md-4">
        <div class="bg-white h-100 p-4 border border-1 rounded d-flex gap-3 justify-content-start align-items-center">
            <div class="icon">
                <p class="m-0 p-0 mdi mdi-shield-account text-info" style="font-size: 50px;"></p>
            </div>
            <div class="detail">
                <h5 class="fw-semibold">Master User</h5>
                <small class="text-muted">Documentation about master user menu.</small>
            </div>
        </div>
    </a>
    <a href="{{ route('paneladmin.documentation.show', 'master-customer') }}" class="col-md-4">
        <div class="bg-white h-100 p-4 border border-1 rounded d-flex gap-3 justify-content-start align-items-center">
            <div class="icon">
                <p class="m-0 p-0 mdi mdi-account-group-outline text-info" style="font-size: 50px;"></p>
            </div>
            <div class="detail">
                <h5 class="fw-semibold">Master Customer</h5>
                <small class="text-muted">Documentation about master customer menu.</small>
            </div>
        </div>
    </a>
    <a href="{{ route('paneladmin.documentation.show', 'product') }}" class="col-md-4">
        <div class="bg-white h-100 p-4 border border-1 rounded d-flex gap-3 justify-content-start align-items-center">
            <div class="icon">
                <p class="m-0 p-0 mdi mdi-tshirt-crew-outline text-info" style="font-size: 50px;"></p>
            </div>
            <div class="detail">
                <h5 class="fw-semibold">Product</h5>
                <small class="text-muted">Documentation about product menu.</small>
            </div>
        </div>
    </a>
    <a href="{{ route('paneladmin.documentation.show', 'order') }}" class="col-md-4">
        <div class="bg-white h-100 p-4 border border-1 rounded d-flex gap-3 justify-content-start align-items-center">
            <div class="icon">
                <p class="m-0 p-0 mdi mdi-cart-arrow-down text-info" style="font-size: 50px;"></p>
            </div>
            <div class="detail">
                <h5 class="fw-semibold">Order</h5>
                <small class="text-muted">Documentation about order menu.</small>
            </div>
        </div>
    </a>
    <a href="{{ route('paneladmin.documentation.show', 'company-profile') }}" class="col-md-4">
        <div class="bg-white h-100 p-4 border border-1 rounded d-flex gap-3 justify-content-start align-items-center">
            <div class="icon">
                <p class="m-0 p-0 mdi mdi-domain text-info" style="font-size: 50px;"></p>
            </div>
            <div class="detail">
                <h5 class="fw-semibold">Company Profile</h5>
                <small class="text-muted">Documentation about company profile menu.</small>
            </div>
        </div>
    </a>
</div>
@endsection