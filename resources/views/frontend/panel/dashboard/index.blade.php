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
                                <a href="{{ route('my-order') }}?order_type=SAMPLE" class="btn btn-dark text-uppercase mt-3">Show More</a>
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
                                <a href="{{ route('my-order') }}?order_type=ORDER" class="btn btn-dark text-uppercase mt-3">Show More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="collection bg-light position-relative">
    <div class="container">
        <div class="collection-item d-flex flex-wrap pb-5">
            <div class="column-container bg-white w-100 pb-3">
                <div class="collection-content p-4 m-0 m-md-5 text-dark">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-2 mt-1">My Request Order</h5>
                            <p class="text-muted mb-4 p-0">Your 5 most recent order request data.</p>
                        </div>
                    </div>

                    <div class="w-100" id="list-orders">
                        @if ($count_recent_orders)
                            @foreach ($recent_orders as $item)
                                <a href="{{ route('my-order.show', $item->order_number_encode) }}" class="card w-100">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3 col-md-1 d-flex justify-content-center align-content-center">
                                                @if($item->status == 'PENDING')
                                                    <i class="mdi mdi-invoice-text-clock-outline text-dark" style="font-size: 40px;"></i>
                                                @elseif($item->status == 'APPROVED')
                                                    <i class="mdi mdi-invoice-text-check-outline text-success" style="font-size: 40px;"></i>
                                                @elseif($item->status == 'CANCELED')
                                                    <i class="mdi mdi-invoice-text-remove-outline text-danger" style="font-size: 40px;"></i>
                                                @endif
                                            </div>
                                            <div class="col-9 col-md-4">
                                                <span class="badge bg-dark mb-2">{{ $item->order_type }}</span>
                                                <h5 class="p-0 m-0" style="font-weight: 500;font-size: 16px;">{{ $item->order_number }}</h5>
                                            </div>
                                            <div class="col-12 col-md-3 align-content-center">
                                                <p class="my-2 p-0 text-dark" style="font-size: 15px;">{{ $item->order_date_format }}</p>
                                            </div>
                                            <div class="col-12 col-md-2 align-content-center">
                                                <p class="mb-2 p-0" style="font-size: 15px;">{{ count($item->details) }} Product</p>
                                            </div>
                                            <div class="col-12 col-md-2 justify-content-center align-content-center">
                                                @if($item->status == 'PENDING')
                                                    <span class="badge bg-dark w-100 w-sm-100 w-md-auto py-2 py-md-auto"><i class="mdi mdi-clock-outline" style="font-size: 14px;"></i> {{ $item->status }}</span>
                                                @elseif($item->status == 'APPROVED')
                                                    <span class="badge bg-success w-100 w-sm-100 w-md-auto py-2 py-md-auto"><i class="mdi mdi-check-decagram-outline" style="font-size: 14px;"></i> {{ $item->status }}</span>
                                                @elseif($item->status == 'CANCELED')
                                                    <span class="badge bg-danger w-100 w-sm-100 w-md-auto py-2 py-md-auto"><i class="mdi mdi-close-outline" style="font-size: 14px;"></i> {{ $item->status }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                        <div class="d-flex justify-content-center flex-column align-items-center">
                            <img class="my-3" src="{{ asset('assets/frontend/images/not-found.svg') }}" alt="No Data" style="width: 50vh;">
                            <span class="my-3 text-muted">You don't have any order requests yet. Click the button below to place your first order!</span>
                            <a href="{{ route('order') }}" class="btn btn-dark text-uppercase">Make Order</a>
                        </div>
                        @endif
                    </div>
                    @if ($count_recent_orders)
                        <a href="{{ route('my-order') }}" type="button" class="btn btn-dark w-100 mt-4">See More</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection