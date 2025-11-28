@extends('frontend.layouts.app')

@section('content')
    @if ($orders)
    <section class="collection bg-light position-relative">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 py-5 {{ Auth::guard('customer')->user() ? 'mb-5' : 'my-5' }}">
                <div class="subscribe-header text-center pb-3">
                    <h3 class="section-title text-uppercase">Order Details</h3>
                    <span class="text-muted">Your order details</span><br>
                    <h5 class="badge bg-dark mt-2 fs-6">{{ $orders->order_number }}</h5>
                </div>
                <div class="bg-white rounded p-4 mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 style="font-size: 17px;">Order Detail</h5>
                            <table class="w-100 mb-4">
                                <tr>
                                    <td style="width: 120px;vertical-align: top;">Order Type</td>
                                    <td style="width: 10px;vertical-align: top;">:</td>
                                    <td style="vertical-align: top;">{{ $orders->order_type }}</td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>:</td>
                                    <td>{{ date('d F Y H:i', strtotime($orders->order_date)) }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td>
                                        @if ($orders->status == 'PENDING')
                                        <span class="badge bg-dark">{{ ucfirst(strtolower($orders->status)) }}</span>
                                        @elseif($orders->status == 'APPROVED')
                                        <span class="badge bg-success">{{ ucfirst(strtolower($orders->status)) }}</span>
                                        @else
                                        <span class="badge bg-danger">{{ ucfirst(strtolower($orders->status)) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;">Notes</td>
                                    <td style="vertical-align: top;">:</td>
                                    <td style="vertical-align: top;">{{ $orders->notes }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 style="font-size: 17px;">Order Customer</h5>
                            <table class="w-100 mb-4">
                                <tr>
                                    <td style="width: 120px;">Name</td>
                                    <td style="width: 10px;">:</td>
                                    <td>{{ $orders->customer_name }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td>{{ $orders->customer_email }}</td>
                                </tr>
                                <tr>
                                    <td>Phone Number</td>
                                    <td>:</td>
                                    <td>{{ $orders->customer_phone_number }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    @if ($orders->details)
                        @foreach ($orders->details as $item)
                            @php
                                $sizes = explode(',', $item->size_selected);
                                $qtys = json_decode($item->qty_selected);
                                $product_image = ($item->product_image ? explode(',',$item->product_image)[0] : '');
                            @endphp
                            <div class="container bg-white rounded p-4 mb-2">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="{{ asset('assets/image/upload/product/'.$product_image) }}" alt="Image {{ $item->product_name }}" style="width: 100%;height: 100%;object-fit: cover;">
                                    </div>
                                    <div class="col-8">
                                        <h5 style="font-size: 16px;margin-bottom: 5px;">{{ $item->product_name }}</h5>
                                        <p style="font-size: 12px;margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">{{ $item->product_category }}</p>
                                        @foreach ($sizes as $size)
                                        <span class="badge bg-dark mb-1">
                                            {{ $size }} 
                                            @if ($orders->order_type == 'ORDER')
                                            ({{ $qtys->$size }})
                                            @endif
                                        </span>
                                        @endforeach
                                        <p style="font-size: 12px;margin-bottom: 5px;margin-top: 5px;padding: 0;">Notes :</p>
                                        <p style="font-size: 12px;margin-bottom: 5px;margin-top: 0;padding: 0;">{{ ($item->notes ? $item->notes : '-') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                @if ($orders->status == 'PENDING')
                    <a href="javascript:void(0)" onclick="cancelOrder('{{ $orders->id }}')" class="btn btn-dark btn-lg w-100 text-uppercase">CANCEL THIS ORDER</a>
                @elseif($orders->status == 'APPROVED')
                    <button type="button" class="btn btn-success btn-lg w-100" disabled>
                        This order was Approved on {{ date('d F Y H:i', strtotime($orders->approved_at)) }}
                    </button>
                @else
                    @if ($orders->canceled_by_customer)
                        <button type="button" class="btn btn-danger btn-lg w-100" disabled>
                            You have cancelled this order on {{ date('d F Y H:i', strtotime($orders->canceled_at)) }}
                        </button>
                    @else
                        <button type="button" class="btn btn-danger btn-lg w-100" disabled>
                            This order was cancelled on {{ date('d F Y H:i', strtotime($orders->canceled_at)) }}
                        </button>
                    @endif
                @endif
            </div>
        </div>
        </div>
    </section>
    @else
    <div class="collection bg-light position-relative">
        <div class="container">
            <div class="collection-item d-flex flex-wrap pb-5 pt-5">
                <div class="column-container bg-white w-100">
                    <div class="collection-content p-4 m-0 m-md-5 text-dark">
                        <h4 class="mb-4 mt-1">There is something wrong!</h4>
                        <p class="mb-4">Sorry, an error occurred. Your order number was not found. You can contact our admin to resolve this issue. Thank you.</p>
                        {{-- <div class="d-flex justify-content-center">
                            <a href="{{ route('forgot-password') }}" class="btn btn-dark btn-lg text-uppercase w-100" style="width: 280px !important;">Forgot Password</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

function cancelOrder(id){
    var url = "{{ route('my-order.cancel-order', ':id') }}";
        url = url.replace(':id', id);
    var confirmText = 'Are you sure you want to cancel this order?';
    
    var confirmButtonText = 'Yes, cancel it!';
    var confirmButtonColor = '#dc3545';
    
    Swal.fire({
        title: 'Confirmation',
        text: confirmText,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: confirmButtonColor,
        cancelButtonColor: '#6c757d',
        confirmButtonText: confirmButtonText,
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    console.log('delete', response);
                    
                    if(response.success) {
                        // Show success toast notification
                        toastr.success('Data has been cancel successfully!', 
                            'Success!'
                        );
                        window.location.reload()
                    } else {
                        toastr.error(
                            'Failed to process your request',
                            'Error!'
                        );
                    }
                },
                error: function(xhr) {
                    console.log('error', xhr);
                    
                    toastr.error(
                        'An error occurred while processing your request',
                        'Error!'
                    );
                }
            });
        }
    });
}
</script>
@endsection