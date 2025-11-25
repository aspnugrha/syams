@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-6 col-md-6 col-xl-3">
        <div class="card">
        <div class="card-body">
            <h6 class="mb-2 f-w-400 text-muted">Total User</h6>
            <h4 class="mb-3">
                <i class="mdi mdi-shield-account fs-3"></i>
                {{ number_format($total_data['total_user'], 0, '.', '.') }}
                {{-- <span class="badge bg-light-primary border border-primary"><i class="ti ti-trending-up"></i> 59.3%</span> --}}
            </h4>
            <p class="mb-0 text-muted text-sm">Total <span class="text-info">{{ number_format($total_data['total_user_month'], 0, '.', '.') }}</span> user bulan ini
            </p>
        </div>
        </div>
    </div>
    <div class="col-6 col-md-6 col-xl-3">
        <div class="card">
        <div class="card-body">
            <h6 class="mb-2 f-w-400 text-muted">Total Customer</h6>
            <h4 class="mb-3">
                <i class="mdi mdi-account-group-outline fs-3"></i>
                {{ number_format($total_data['total_customer'], 0, '.', '.') }}
                {{-- <span class="badge bg-light-success border border-success"><i class="ti ti-trending-up"></i> 70.5%</span> --}}
            </h4>
            <p class="mb-0 text-muted text-sm">Total <span class="text-info">{{ number_format($total_data['total_customer_month'], 0, '.', '.') }}</span> customer bulan ini</p>
        </div>
        </div>
    </div>
    <div class="col-6 col-md-6 col-xl-3">
        <div class="card">
        <div class="card-body">
            <h6 class="mb-2 f-w-400 text-muted">Total Product</h6>
            <h4 class="mb-3">
                <i class="mdi mdi-tshirt-crew-outline fs-3"></i>
                {{ number_format($total_data['total_product'], 0, '.', '.') }}
                {{-- <span class="badge bg-light-warning border border-warning"><i class="ti ti-trending-down"></i> 27.4%</span> --}}
            </h4>
            <p class="mb-0 text-muted text-sm">Total <span class="text-info">{{ number_format($total_data['total_product_month'], 0, '.', '.') }}</span> sample bulan ini</p>
        </div>
        </div>
    </div>
    <div class="col-6 col-md-6 col-xl-3">
        <div class="card">
        <div class="card-body">
            <h6 class="mb-2 f-w-400 text-muted">Total Order</h6>
            <h4 class="mb-3">
                <i class="mdi mdi-cart-arrow-down fs-3"></i>
                {{ number_format($total_data['total_order'], 0, '.', '.') }}
                {{-- <span class="badge bg-light-danger border border-danger"><i class="ti ti-trending-down"></i> 27.4%</span> --}}
            </h4>
            <p class="mb-0 text-muted text-sm">Total <span class="text-info">{{ number_format($total_data['total_order'], 0, '.', '.') }}</span> order bulan ini
            </p>
        </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="mb-0">Unique Visitor</h5>
        <ul class="nav nav-pills justify-content-end mb-0" id="chart-tab-tab" role="tablist">
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="chart-tab-home-tab" data-bs-toggle="pill" data-bs-target="#chart-tab-home"
                type="button" role="tab" aria-controls="chart-tab-home" aria-selected="true">Month</button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link active" id="chart-tab-profile-tab" data-bs-toggle="pill"
                data-bs-target="#chart-tab-profile" type="button" role="tab" aria-controls="chart-tab-profile"
                aria-selected="false">Week</button>
            </li>
        </ul>
        </div>
        <div class="card">
        <div class="card-body">
            <div class="tab-content" id="chart-tab-tabContent">
            <div class="tab-pane" id="chart-tab-home" role="tabpanel" aria-labelledby="chart-tab-home-tab"
                tabindex="0">
                <div id="visitor-chart-1"></div>
            </div>
            <div class="tab-pane show active" id="chart-tab-profile" role="tabpanel"
                aria-labelledby="chart-tab-profile-tab" tabindex="0">
                <div id="visitor-chart"></div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xl-12">
        <h5 class="mb-3">Recent Orders</h5>
        <div class="card tbl-card">
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-hover table-borderless mb-0">
                <thead>
                <tr>
                    <th>TRACKING NO.</th>
                    <th>PRODUCT NAME</th>
                    <th>TOTAL ORDER</th>
                    <th>STATUS</th>
                    <th class="text-end">TOTAL AMOUNT</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><a href="#" class="text-muted">84564564</a></td>
                    <td>Camera Lens</td>
                    <td>40</td>
                    <td><span class="d-flex align-items-center gap-2"><i
                        class="fas fa-circle text-danger f-10 m-r-5"></i>Rejected</span>
                    </td>
                    <td class="text-end">$40,570</td>
                </tr>
                <tr>
                    <td><a href="#" class="text-muted">84564564</a></td>
                    <td>Laptop</td>
                    <td>300</td>
                    <td><span class="d-flex align-items-center gap-2"><i
                        class="fas fa-circle text-warning f-10 m-r-5"></i>Pending</span>
                    </td>
                    <td class="text-end">$180,139</td>
                </tr>
                <tr>
                    <td><a href="#" class="text-muted">84564564</a></td>
                    <td>Mobile</td>
                    <td>355</td>
                    <td><span class="d-flex align-items-center gap-2"><i
                        class="fas fa-circle text-success f-10 m-r-5"></i>Approved</span></td>
                    <td class="text-end">$180,139</td>
                </tr>
                <tr>
                    <td><a href="#" class="text-muted">84564564</a></td>
                    <td>Camera Lens</td>
                    <td>40</td>
                    <td><span class="d-flex align-items-center gap-2"><i
                        class="fas fa-circle text-danger f-10 m-r-5"></i>Rejected</span>
                    </td>
                    <td class="text-end">$40,570</td>
                </tr>
                <tr>
                    <td><a href="#" class="text-muted">84564564</a></td>
                    <td>Laptop</td>
                    <td>300</td>
                    <td><span class="d-flex align-items-center gap-2"><i
                        class="fas fa-circle text-warning f-10 m-r-5"></i>Pending</span>
                    </td>
                    <td class="text-end">$180,139</td>
                </tr>
                <tr>
                    <td><a href="#" class="text-muted">84564564</a></td>
                    <td>Mobile</td>
                    <td>355</td>
                    <td><span class="d-flex align-items-center gap-2"><i
                        class="fas fa-circle text-success f-10 m-r-5"></i>Approved</span></td>
                    <td class="text-end">$180,139</td>
                </tr>
                <tr>
                    <td><a href="#" class="text-muted">84564564</a></td>
                    <td>Camera Lens</td>
                    <td>40</td>
                    <td><span class="d-flex align-items-center gap-2"><i
                        class="fas fa-circle text-danger f-10 m-r-5"></i>Rejected</span>
                    </td>
                    <td class="text-end">$40,570</td>
                </tr>
                <tr>
                    <td><a href="#" class="text-muted">84564564</a></td>
                    <td>Laptop</td>
                    <td>300</td>
                    <td><span class="d-flex align-items-center gap-2"><i
                        class="fas fa-circle text-warning f-10 m-r-5"></i>Pending</span>
                    </td>
                    <td class="text-end">$180,139</td>
                </tr>
                <tr>
                    <td><a href="#" class="text-muted">84564564</a></td>
                    <td>Mobile</td>
                    <td>355</td>
                    <td><span class="d-flex align-items-center gap-2"><i
                        class="fas fa-circle text-success f-10 m-r-5"></i>Approved</span></td>
                    <td class="text-end">$180,139</td>
                </tr>
                <tr>
                    <td><a href="#" class="text-muted">84564564</a></td>
                    <td>Mobile</td>
                    <td>355</td>
                    <td><span class="d-flex align-items-center gap-2"><i
                        class="fas fa-circle text-success f-10 m-r-5"></i>Approved</span></td>
                    <td class="text-end">$180,139</td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });	
    loadData();
})

function loadData(){
    $('.custom-loader-overlay').css('display', 'flex')

    $.ajax({
        url: "{{ route('api.dashboard.load-data') }}",
        method: 'POST',
        // data: new FormData(document.getElementById("formData")),
        // processData: false,
        // contentType: false,
        // cache: false,
        success: function(response) {
            console.log(response);
        },
        error: function(xhr) {
            console.log(xhr);
            
        },
        complete:function(){
            $('.custom-loader-overlay').css('display', 'none')
        }
    });
}
</script>
@endsection