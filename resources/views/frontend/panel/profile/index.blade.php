@extends('frontend.layouts.app')

@section('styles')
<style>
    #table-data th, td{
        border: 1px solid #212529 !important;
    }
</style>
@endsection
@section('content')
<div class="collection bg-light position-relative pt-5">
    <div class="container">
        <div class="collection-item d-flex flex-wrap pb-5">
            <div class="column-container bg-white w-100">
                <div class="collection-content p-4 m-0 m-md-5 text-dark">
                    <h4 class="mb-4 mt-1">Profile</h4>
                        
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="true">
                            Account
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">
                            Password
                            </button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content mt-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <img src="{{ $customer->image ? asset('assets/image/upload/customer/'.Auth::guard('customer')->user()->image) : 'https://via.assets.so/img.jpg?w=400&h=300&bg=e5e7eb&text=+&f=png' }}" alt="Image Profile" style="width: 100%;">
                                    <h4 class="mt-3">{{ $customer->name }}</h4>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="text-muted mb-2">Complete your data to make it easier to manage your orders.</span>
                                        {{-- <label class="form-label">Name</label> --}}
                                        <input type="text" class="form-control form-control-lg" name="name" id="name" placeholder="Your Fullname" value="{{ $customer->name }}">
                                        <input type="text" class="form-control form-control-lg" name="email" id="email" placeholder="example@email.com" value="{{ $customer->email }}">
                                        <input type="text" class="form-control form-control-lg" name="phone_number" id="phone_number" placeholder="628xxxxxxxx" value="{{ $customer->phone_number }}">
                                        <button type="submit" class="btn btn-dark btn-lg text-uppercase w-100">Update My Profile</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <div class="d-flex flex-wrap gap-2">
                                {{-- <label class="form-label">Name</label> --}}
                                <input type="text" class="form-control form-control-lg" id="name" placeholder="Your old password">
                                <input type="text" class="form-control form-control-lg" id="name" placeholder="New password">
                                <input type="text" class="form-control form-control-lg" id="name" placeholder="Confirm new password">
                                <button type="submit" class="btn btn-dark btn-lg text-uppercase w-100">Set New Password</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#table-data').DataTable()
</script>
@endsection