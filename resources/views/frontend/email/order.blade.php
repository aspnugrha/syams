@extends('frontend.email.layouts.email-app')
@section('content')
    <div class="header" style="padding: 25px;margin-bottom: 20px;">
        <a class="text-decoration-none" href="{{ route('home') }}">
            <img src="{{ asset($company_profile && $company_profile->logo ? 'assets/image/upload/logo/'.$company_profile->logo : 'assets/image/logo-syams.png') }}" alt="{{ ($company_profile && $company_profile->name ? $company_profile->name : 'Syams Manufacturing') }} Logo" style="width: 140px;">
        </a>
    </div>
    <div class="border-bottom" style="padding: 0 25px 80px 25px;">

        <h2 class="header-text" style="margin: 0 0 25px 0;">Hallo, {{ $customer->name }}!</h2>
        <p style="margin: 0 0 10px 0;font-size: 15px;">Thank you for submitting your {{ strtolower($orders->order_type) }} request at {{ $company_profile->name ? $company_profile->name : 'Syams Manufacture' }}. Here are the details of your {{ strtolower($orders->order_type) }} :</p>

        <table style="width: 100%;margin: 10px 0;">
            <tr>
                <td style="width: 120px;">Order Number</td>
                <td style="width: 10px;">:</td>
                <td>
                    <h5 style="background: #000;
                        color: #fff;
                        padding: 4px 8px;
                        border-radius: 4px;
                        font-size: 15px;
                        display: inline-block;">{{ $orders->order_number }}</h5>
                </td>
            </tr>
            <tr>
                <td>Order Type</td>
                <td>:</td>
                <td>{{ $orders->order_type }}</td>
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
                        <span style="background: #000;
                        color: #fff;
                        padding: 4px 8px;
                        border-radius: 4px;
                        font-size: 12px;
                        display: inline-block;">{{ ucfirst(strtolower($orders->status)) }}</span>
                    @elseif($orders->status == 'APPROVED')
                        <span style="background: #198754;
                        color: #fff;
                        padding: 4px 8px;
                        border-radius: 4px;
                        font-size: 12px;
                        display: inline-block;">{{ ucfirst(strtolower($orders->status)) }}</span>
                    @else
                        <span style="background: #dc3545;
                        color: #fff;
                        padding: 4px 8px;
                        border-radius: 4px;
                        font-size: 12px;
                        display: inline-block;">{{ ucfirst(strtolower($orders->status)) }}</span>
                    @endif
            </tr>
            <tr>
                <td>Name</td>
                <td>:</td>
                <td>{{ $customer->name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>{{ $customer->email }}</td>
            </tr>
            <tr>
                <td>Phone Number</td>
                <td>:</td>
                <td>{{ $customer->phone_number }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Notes</td>
                <td style="vertical-align: top;">:</td>
                <td>{{ $orders->notes ? '"'.$orders->notes.'"' : '-' }}</td>
            </tr>
        </table>

        <table style="width: 100%;margin: 10px 0;">
            @if ($orders->details)
                @foreach ($orders->details as $item)
                    @php
                        $sizes = explode(',', $item->size_selected);
                        $qtys = json_decode($item->qty_selected);
                        $material_colors = json_decode($item->material_color_selected);
                        $product_image = ($item->product_image ? explode(',',$item->product_image)[0] : '');
                    @endphp
                    <tr style="border: 1px solid #aaa;">
                        <td style="width: 140px;max-height: 200px;padding: 10px;">
                            <img src="{{ asset('assets/image/upload/product/'.$product_image) }}" alt="Image {{ $item->product_name }}" style="width: 100%;object-fit: cover;">
                        </td>
                        <td>
                            <p style="font-size: 12px;margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">{{ $item->product_category }}</p>
                            <h5 style="font-size: 16px;margin-bottom: 10px;">{{ $item->product_name }}</h5>

                            <p style="font-size: 12px;margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Material & Color</p>
                            <div style="margin-bottom: 10px;display: flex;align-items:center;">
                                <label style="font-size: 15px;font-weight: semibold;color: #212122bf;">{{ $item->material_selected }}</label> &nbsp;&nbsp;
                                <p style="padding: 4px 5px;border: 1px solid #212122bf;border-radius: 50rem;font-size: 13px;margin: 0;display: flex;align-items:center;">
                                    @if (isset($material_colors->color_code))
                                    <label style="width: 35px;height: 35px;border-radius: 100%;background-color: {{ $material_colors->color_code }};"></label>
                                    @else
                                    <img src="{{ asset('assets/image/upload/product/material/'.$material_colors->color_image) }}" alt="Color {{ $material_colors->color }} Image" style="width: 35px;height: 35px;border-radius: 100%;">
                                    @endif
                                    &nbsp;{{ $material_colors->color }}
                                </p>
                            </div>
                            <p style="font-size: 12px;margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Sablon Type</p>
                            <div style="margin-bottom: 10px;">
                                <label style="font-size: 15px;font-weight: semibold;color: #212122bf;">{{ $item->sablon_selected }}</label>
                            </div>
                            <p style="font-size: 12px;margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Bordir</p>
                            <div style="margin-bottom: 10px;">
                                <label style="font-size: 15px;font-weight: semibold;color: #212122bf;">{{ $item->is_bordir ? 'YES' : 'No' }}</label>
                            </div>
                            @foreach ($sizes as $size)
                            <span style="background: #000;
                                color: #fff;
                                padding: 4px 8px;
                                border-radius: 4px;
                                font-size: 12px;
                                display: inline-block;margin-bottom: 5px;">
                                {{ $size }} 
                                @if ($orders->order_type == 'ORDER')
                                ({{ $qtys->$size }})
                                @endif
                            </span>
                            @endforeach
                            <p style="font-size: 12px;margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Mockup</p>
                            <div style="margin-bottom: 10px;">
                                <a href="{{ asset('assets/image/upload/order/mockup/'.$item->mockup) }}" target="_blank" class="form-check-label text-muted fw-semibold" style="font-size: 15px;">See Mockup <i class="mdi mdi-open-in-new"></i></a>
                            </div>
                            <p style="font-size: 12px;margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Raw File</p>
                            <div style="margin-bottom: 10px;">
                                <a href="{{ asset('assets/image/upload/order/raw_file/'.$item->raw_file) }}" target="_blank" class="form-check-label text-muted fw-semibold" style="font-size: 15px;">See Raw File <i class="mdi mdi-open-in-new"></i></a>
                            </div>
                            <p style="font-size: 12px;margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Notes :</p>
                            {{-- <p style="font-size: 12px;margin-bottom: 5px;margin-top: 5px;padding: 0;">Notes :</p> --}}
                            <p style="font-size: 12px;margin-bottom: 5px;margin-top: 0;padding: 0;">{{ ($item->notes ? '"'.$item->notes.'"' : '-') }}</p>
                        </td>
                    </tr>
                @endforeach
            @endif
            {{-- <tr style="border: 1px solid #aaa;">
                <td style="width: 70px;">
                    <img src="{{ route('assets/image/upload/') }}" alt="Image {{  }}">
                </td>
                <td>
                    <h5 style="font-size: 16px;margin-bottom: 5px;">nama product</h5>
                    <p style="font-size: 12px;margin-bottom: 5px;padding: 0;color: #aaa;">kategori</p>
                    <span style="background: #000;
                        color: #fff;
                        padding: 4px 8px;
                        border-radius: 4px;
                        font-size: 12px;
                        display: inline-block;">L (30)</span>
                    <span style="background: #000;
                        color: #fff;
                        padding: 4px 8px;
                        border-radius: 4px;
                        font-size: 12px;
                        display: inline-block;">XL (40)</span>
                    <p style="font-size: 12px;margin-bottom: 5px;padding: 0;">Notes :</p>
                    <p style="font-size: 12px;margin-bottom: 5px;padding: 0;">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Necessitatibus, incidunt.</p>
                </td>
            </tr>
            <tr>
                <td style="width: 70px;">
                    <img src="{{ route('assets/image/upload/') }}" alt="Image {{  }}">
                </td>
                <td>
                    <h5 style="font-size: 16px;margin-bottom: 5px;">nama product</h5>
                    <p style="font-size: 12px;margin-bottom: 5px;padding: 0;color: #aaa;">kategori</p>
                    <span style="background: #000;
                        color: #fff;
                        padding: 4px 8px;
                        border-radius: 4px;
                        font-size: 12px;
                        display: inline-block;">M</span>
                    <p style="font-size: 12px;margin-bottom: 5px;padding: 0;">Notes :</p>
                    <p style="font-size: 12px;margin-bottom: 5px;padding: 0;">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Necessitatibus, incidunt.</p>
                </td>
            </tr> --}}
        </table>
        <p style="margin: 20px 0 10px 0;font-size: 15px;">For order details, you can check on the website by clicking the link below.</p>
        <div style="width: 100%;display: flex;justify-content: center;margin-top: 50px;">
            <a href="{{ $url }}" target="_blank" class="btn" style="background-color: #212529;color: white;padding: 10px 20px;text-decoration: none;">Order Details</a>
        </div>
    </div>

@endsection