<div class="row">
    <div class="col-12 col-md-6">
        <h5 class="mb-2">Order</h5>

        <div class="card mb-3">
            <div class="card-body">
                <span class="p-2" style="background-color: #eee;font-size: 15px;"><b>{{ $data->order_number }}</b></span>

                <div class="d-flex gap-1 mb-2 mt-3">
                    <span class="badge bg-dark rounded-pill px-2">{{ $data->order_type }}</span>
                    <span class="badge bg-{{ $data->status == 'APPROVED' ? 'success' : ($data->status == 'CANCELED' ? 'danger' : 'dark') }} rounded-pill px-2">{{ $data->status }}</span>
                </div>
                
                <p class="p-0 m-0"><i class="mdi mdi-calendar-outline fs-5"></i> {{ date('d F Y H:i', strtotime($data->order_date)) }}</p>
                {{-- <p class="p-0 m-0"><i class="mdi mdi-phone-outline fs-5"></i> {{ $data->customer_phone_number }}</p> --}}
                <p class="p-0 m-0"><span class="text-muted">Notes :</span> <br>{{ $data->notes ? '"'.$data->notes.'"' : '-' }}</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <h5 class="mb-2">Customer</h5>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <img src="{{ ($data->hasCustomer ? ($data->hasCustomer->image ? asset('assets/image/upload/customer/'.$data->hasCustomer->image) : 'https://via.assets.so/img.jpg?w=400&h=300&bg=e5e7eb&text=+&f=png') : 'https://via.assets.so/img.jpg?w=400&h=300&bg=e5e7eb&text=+&f=png' ) }}" alt="Profile Customer" style="width: 100%;object-fit: cover;">
                    </div>
                    <div class="col-8">
                        <h4>{{ $data->customer_name }}</h4>
                        <p class="p-0 m-0"><a class="text-dark" href="mailto:{{ $data->customer_email }}"><i class="mdi mdi-email-outline fs-5"></i> {{ $data->customer_email }}</a></p>
                        <p class="p-0 m-0"><a class="text-dark" href="telp:{{ $data->customer_phone_number }}"><i class="mdi mdi-phone-outline fs-5"></i> {{ $data->customer_phone_number }}</a></p>
                        <p class="p-0 m-0"><i class="mdi mdi-{{ $data->hasCustomer ? ($data->hasCustomer->active ? 'check-decagram text-success' : 'check-decagram text-danger') : 'alert-decagram-outline text-dark' }} fs-5"></i> {{ $data->hasCustomer ? ($data->hasCustomer->active ? 'Active' : 'Not Active') : 'Not Login' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <h5 class="mb-2">Order Product</h5>
    @if ($data->details)
        @foreach ($data->details as $item)
        @php
            $product_image = '';
            if($item->product_image){
                $product_image = explode(',', $item->product_image)[0];
            }

            $sizes = explode(',', $item->size_selected);
            $material_colors = json_decode($item->material_color_selected);
            $qtys = json_decode($item->qty_selected);
        @endphp
        <div class="card mb-1">
            <div class="container bg-white rounded p-3">
                <div class="row">
                    <div class="col-4">
                        <img src="{{ asset('assets/image/upload/product/'.$product_image) }}" alt="Image {{ $item->product_name }}" style="width: 100%;object-fit: cover;">
                    </div>
                    <div class="col-8">
                        <p style="margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">{{ $item->product_category }}</p>
                        <h5 class="fs-4 fw-semibold" style="margin-bottom: 15px;">{{ $item->product_name }}</h5>
                        
                        <p style="margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Material & Color</p>
                        <div class="mb-2 d-flex">
                            <label class="form-check-label text-muted fw-semibold" style="font-size: 15px;">{{ $item->material_selected }}</label> &nbsp;&nbsp;
                            {{-- <label class="btn btn-outline-secondary rounded-pill fw-semibold d-inline-flex align-items-center mb-1" style="font-size: 13px;padding: 2px 4px;">
                                <span style="width: 15px;height: 15px;border-radius: 100%;background-color: {{ $material_colors->color_code }};"></span>
                                &nbsp;{{ $material_colors->color }}
                            </label> --}}
                            <label class="btn btn-outline-secondary rounded-pill fw-semibold d-inline-flex justify-content-start align-items-center mb-1" style="font-size: 13px;padding: 4px 5px;">
                                @if (isset($material_colors->color_code))
                                <span style="width: 35px;height: 35px;border-radius: 100%;background-color: {{ $material_colors->color_code }};"></span>
                                @else
                                <img src="{{ asset('assets/image/upload/product/material/'.$material_colors->color_image) }}" alt="Color {{ $material_colors->color }} Image" style="width: 35px;height: 35px;border-radius: 100%;">
                                @endif
                                &nbsp;{{ $material_colors->color }}
                            </label>
                        </div>
                        <p style="margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Sablon Type</p>
                        <div class="mb-2 d-flex">
                            <label class="form-check-label text-muted fw-semibold" style="font-size: 15px;">{{ $item->sablon_selected }}</label>
                        </div>
                        <p style="margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Bordir</p>
                        <div class="mb-2 d-flex">
                            <label class="form-check-label text-muted fw-semibold" style="font-size: 15px;">{{ $item->is_bordir ? 'YES' : 'No' }}</label>
                        </div>
                        <p style="margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Size & Quantity</p>
                        @foreach ($sizes as $size)
                        <span class="badge bg-dark mb-2" style="font-size: 13px;">{{ $size }} ({{ $qtys->$size }})</span>
                        @endforeach
                        <p style="margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Mockup</p>
                        <div class="mb-2 d-flex">
                            <a href="{{ asset('assets/image/upload/order/mockup/'.$item->mockup) }}" target="_blank" class="form-check-label text-muted fw-semibold" style="font-size: 15px;">See Mockup <i class="mdi mdi-open-in-new"></i></a>
                        </div>
                        <p style="margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Raw File</p>
                        <div class="mb-2 d-flex">
                            <a href="{{ asset('assets/image/upload/order/raw_file/'.$item->raw_file) }}" target="_blank" class="form-check-label text-muted fw-semibold" style="font-size: 15px;">See Raw File <i class="mdi mdi-open-in-new"></i></a>
                        </div>
                        <p style="margin-bottom: 5px;margin-top: 0;padding: 0;color: #aaa;">Notes</p>
                        {{-- <p style="font-size: 12px;margin-bottom: 5px;margin-top: 5px;padding: 0;">Notes :</p> --}}
                        <p style="font-size: 13px;margin-bottom: 5px;margin-top: 0;padding: 0;" class="text-muted">{{ $item->notes ? '"'.$item->notes.'"' : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        
    @endif
</div>