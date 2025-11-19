@extends('frontend.layouts.app')

@section('content')
<section class="collection bg-light position-relative pt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="container">
                    <div class="collection-item d-flex flex-wrap mb-5">
                        <div class="column-container bg-white w-100">
                            <div class="collection-content p-5 m-0 m-md-5">
                                <h5 class="element-title text-uppercase">My Sample</h5>
                                <p>
                                    {{ $sample_pending }} Requested, {{ $sample_approved }} Accepted, {{ $sample_canceled }} Cancel
                                </p>
                                <a href="{{ route('my-order') }}" class="btn btn-dark text-uppercase mt-3">Show More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="container">
                    <div class="collection-item d-flex flex-wrap mb-5">
                        <div class="column-container bg-white w-100">
                            <div class="collection-content p-5 m-0 m-md-5">
                                <h5 class="element-title text-uppercase">My Order</h5>
                                <p>
                                    {{ $order_pending }} Requested, {{ $order_approved }} Accepted, {{ $order_canceled }} Cancel
                                </p>
                                <a href="{{ route('my-order') }}" class="btn btn-dark text-uppercase mt-3">Show More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection