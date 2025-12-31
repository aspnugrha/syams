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
                                $material_colors = json_decode($item->material_color_selected);
                                $product_image = ($item->product_image ? explode(',',$item->product_image)[0] : '');
                            @endphp
                            <div class="container bg-white rounded p-4 mb-2">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="{{ asset('assets/image/upload/product/'.$product_image) }}" alt="Image {{ $item->product_name }}" style="width: 100%;object-fit: cover;">
                                    </div>
                                    <div class="col-8">
                                        <p style="font-size: 12px;margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">{{ $item->product_category }}</p>
                                        <h5 style="font-size: 16px;margin-bottom: 15px;">{{ $item->product_name }}</h5>
                                        
                                        <p style="margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Material & Color</p>
                                        <div class="mb-2 d-flex">
                                            <label class="form-check-label ps-0 text-muted fw-semibold" style="font-size: 15px;">{{ $item->material_selected }}</label> &nbsp;&nbsp;
                                            <label class="btn btn-outline-secondary rounded-pill fw-semibold d-inline-flex align-items-center mb-1" style="font-size: 13px;padding: 2px 4px;">
                                                <span style="width: 15px;height: 15px;border-radius: 100%;background-color: {{ $material_colors->color_code }};"></span>
                                                &nbsp;{{ $material_colors->color }}
                                            </label>
                                        </div>
                                        <p style="margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Sablon Type</p>
                                        <div class="mb-2 d-flex">
                                            <label class="form-check-label ps-0 text-muted fw-semibold" style="font-size: 15px;">{{ $item->sablon_selected }}</label>
                                        </div>
                                        <p style="margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Bordir</p>
                                        <div class="mb-2 d-flex">
                                            <label class="form-check-label ps-0 text-muted fw-semibold" style="font-size: 15px;">{{ $item->is_bordir ? 'YES' : 'No' }}</label>
                                        </div>
                                        <p style="margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Size & Quantity</p>
                                        @foreach ($sizes as $size)
                                        <span class="badge bg-dark mb-1">
                                            {{ $size }} 
                                            @if ($orders->order_type == 'ORDER')
                                            ({{ $qtys->$size }})
                                            @endif
                                        </span>
                                        @endforeach
                                        <p style="margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Mockup</p>
                                        <div class="mb-2 d-flex">
                                            <a href="{{ asset('assets/image/upload/order/mockup/'.$item->mockup) }}" target="_blank" class="form-check-label ps-0 text-muted fw-semibold" style="font-size: 15px;">See Mockup <i class="mdi mdi-open-in-new"></i></a>
                                        </div>
                                        <p style="margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Raw File</p>
                                        <div class="mb-2 d-flex">
                                            <a href="{{ asset('assets/image/upload/order/raw_file/'.$item->raw_file) }}" target="_blank" class="form-check-label ps-0 text-muted fw-semibold" style="font-size: 15px;">See Raw File <i class="mdi mdi-open-in-new"></i></a>
                                        </div>
                                        <p style="margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Notes</p>
                                        {{-- <p style="font-size: 12px;margin-bottom: 5px;margin-top: 5px;padding: 0;">Notes :</p> --}}
                                        <p style="font-size: 15px;margin-bottom: 5px;margin-top: 0;padding: 0;">{{ ($item->notes ? '"'.$item->notes.'"' : '-') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
@php
$message_template = "
Halo, ".($company_profile && $company_profile->name ? $company_profile->name : 'Syams Manufacturing')."!

I have placed an order with the following details:
Order Number : *".$orders->order_number."*
Type : ".$orders->order_type."
Date : ".date('d F Y H:i', strtotime($orders->order_date))."
Name : ".$orders->customer_name."
Email : ".$orders->customer_email."
Phone Number : ".$orders->customer_phone_number."

I would like to confirm and process the order.
Thank you.
";

$encodedMessage = urlencode(trim($message_template));

$waLink = "https://wa.me/{$company_profile->whatsapp}?text={$encodedMessage}";
$iMessageLink = "imessage://+{$company_profile->imessage}?body={$encodedMessage}";
@endphp
                <div class="row g-1">
                    @if ($orders->status == 'PENDING')
                    <div class="col-md-9">
                        <div class="dropdown h-100">
                            <button class="btn btn-success w-100 text-uppercase h-100 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-thumb-up-outline"></i> &nbsp; Confirm and process orders
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ $waLink }}" target="_blank"><i class="mdi mdi-whatsapp"></i> Confirm via Whatsapp</a></li>
                                <li><a class="dropdown-item" href="{{ $iMessageLink }}" target="_blank"><i class="mdi mdi-chat-outline"></i> Confirm via iMessage</a></li>
                            </ul>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-{{ ($orders->status == 'PENDING') ? '3' : '12' }}">
                        @if ($orders->status == 'PENDING')
                            <a href="javascript:void(0)" onclick="cancelOrder('{{ $orders->id }}', '{{ $orders->order_number_encode }}')" class="btn btn-outline-secondary w-100 text-uppercase"><i class="mdi mdi-close"></i> CANCEL</a>
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

function cancelOrder(id, order_number_encode = null){
    if("{{ Auth::guard('customer')->check() }}"){
        var url = "{{ route('my-order.cancel-order', ':id') }}";
            url = url.replace(':id', id);
    }else{
        var url = "{{ route('order.cancel-order', ':order_number') }}";
            url = url.replace(':order_number', order_number_encode);
    }

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
            $('.custom-loader-overlay').css('display', 'flex')
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
                },
                complete:function(){
                    $('.custom-loader-overlay').css('display', 'none')
                },
            });
        }
    });
}
</script>
@endsection