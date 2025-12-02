@extends('backend.layouts.app')
@section('content')
<form id="form-filter" class="row g-1 mb-3 p-0 pt-2">
    <div class="col-12 col-md-6 align-content-center">
        <h5 class="mb-0 mb-2">Total Data</h5>
    </div>
    <div class="col-4 col-md-2 justify-content-end">
        <select name="filter_order" id="filter_order" class="form-control" onchange="loadData()">
            <option value="">All</option>
            <option value="SAMPLE">Sample</option>
            <option value="ORDER">Order</option>
        </select>
    </div>
    <div class="col-8 col-md-4 justify-content-end">
        <input type="text" class="form-control" name="filter_date" id="filter_date">
    </div>
    {{-- <div class="w-100 w-md-auto">
        <div class="row g-1">
            <div class="col-6">
            </div>
            <div class="col-6">
            </div>
        </div>
    </div> --}}
</form>
<div class="row">
    <div class="col-6 col-md-6 col-xl-3">
        <div class="card">
        <div class="card-body">
            <h6 class="mb-2 f-w-400 text-muted">Total User</h6>
            <h4 class="mb-3">
                <i class="mdi mdi-shield-account fs-3"></i>
                <span id="text-total-user">0</span>
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
                <span id="text-total-customer">0</span>
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
                <span id="text-total-product">0</span>
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
                <span id="text-total-order">0</span>
                {{-- <span class="badge bg-light-danger border border-danger"><i class="ti ti-trending-down"></i> 27.4%</span> --}}
            </h4>
            <p class="mb-0 text-muted text-sm">Total <span class="text-info">{{ number_format($total_data['total_order_month'], 0, '.', '.') }}</span> order bulan ini
            </p>
        </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="mb-0">Grafik Order</h5>
            {{-- <ul class="nav nav-pills justify-content-end mb-0" id="chart-tab-tab" role="tablist">
                <li class="nav-item" role="presentation">
                <button class="nav-link" id="chart-tab-home-tab" data-bs-toggle="pill" data-bs-target="#chart-tab-home"
                    type="button" role="tab" aria-controls="chart-tab-home" aria-selected="true">Month</button>
                </li>
                <li class="nav-item" role="presentation">
                <button class="nav-link active" id="chart-tab-profile-tab" data-bs-toggle="pill"
                    data-bs-target="#chart-tab-profile" type="button" role="tab" aria-controls="chart-tab-profile"
                    aria-selected="false">Week</button>
                </li>
            </ul> --}}
        </div>
        <div class="card">
            <div class="card-body">
                <div id="chart"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xl-12">
        <h5 class="mb-3">Order Terbaru</h5>
        <div class="card tbl-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless mb-0" id="tbl-recent-order">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Order Number</th>
                                <th>Customer</th>
                                <th>Order Type</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-recent-order">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
let recent_order_table = ''
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });	
    
    recent_order_table = $('#tbl-recent-order').DataTable({
        lengthChange: false
    });
    
    loadData();

    $('#filter_date').daterangepicker({
        autoUpdateInput: false,
        locale: { format: 'DD/MM/YYYY' },
        startDate: moment().startOf('month'),
        endDate: moment().endOf('month'),
        alwaysShowCalendars: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'day'), moment().subtract(1, 'day')],

            'This Week': [moment().startOf('week'), moment().endOf('week')],
            'Last Week': [
                moment().subtract(1, 'week').startOf('week'),
                moment().subtract(1, 'week').endOf('week')
            ],

            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [
                moment().subtract(1, 'month').startOf('month'),
                moment().subtract(1, 'month').endOf('month')
            ]
        }
    }, function(start, end) {
        $('#filter_date').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        loadData();
    });
})

$('#filter_date').val(
    moment().startOf('month').format('DD/MM/YYYY') + 
    ' - ' +
    moment().endOf('month').format('DD/MM/YYYY')
);


const baseMonths = [
    'Jan','Feb','Mar','Apr','Mei','Jun',
    'Jul','Agu','Sep','Okt','Nov','Des'
];

// Data awal
let seriesData = [
    { name: 'Total Data', data: [0,0,0,0,0,0,0,0,0,0,0,0] },
    { name: 'Total Sample', data: [0,0,0,0,0,0,0,0,0,0,0,0] },
    { name: 'Total Order', data: [0,0,0,0,0,0,0,0,0,0,0,0] }
];

let options = {
    chart: {
        type: 'line',
        height: 350,
    },
    stroke: {
        width: 3
    },
    series: seriesData,
    xaxis: {
        categories: baseMonths
    },
    legend: {
        position: 'top'
    }
};

let chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();


function loadData(){
    $('.custom-loader-overlay').css('display', 'flex')

    $.ajax({
        url: "{{ route('api.dashboard.load-data') }}",
        method: 'POST',
        data : $('#form-filter').serialize(),
        // data: new FormData(document.getElementById("formData")),
        // processData: false,
        // contentType: false,
        // cache: false,
        success: function(response) {
            console.log(response);
            const order_type = $('#filter_order').val();

            if(response.total_data){
                $('#text-total-user').text(parseInt(response.total_data.total_user_month).toLocaleString('id-ID'))
                $('#text-total-customer').text(parseInt(response.total_data.total_customer_month).toLocaleString('id-ID'))
                $('#text-total-product').text(parseInt(response.total_data.total_product_month).toLocaleString('id-ID'))
                $('#text-total-order').text(parseInt(response.total_data.total_order_month).toLocaleString('id-ID'))
            }

            if(response.chart){
                const newMonths = response.chart.label;
                let newSeries = [];
                if(order_type == 'ORDER'){
                    newSeries = [
                        { name: 'Total Data', data: response.chart.data.total_data },
                        { name: 'Total Order', data: response.chart.data.total_data_order }
                    ];
                }else if(order_type == 'SAMPLE'){
                    newSeries = [
                        { name: 'Total Data', data: response.chart.data.total_data },
                        { name: 'Total Sample', data: response.chart.data.total_data_sample },
                    ];
                }else{
                    newSeries = [
                        { name: 'Total Data', data: response.chart.data.total_data },
                        { name: 'Total Sample', data: response.chart.data.total_data_sample },
                        { name: 'Total Order', data: response.chart.data.total_data_order }
                    ];
                }

                // Update data series
                chart.updateSeries(newSeries);

                // Update bulan (x-axis)
                chart.updateOptions({
                    xaxis: {
                        categories: newMonths
                    }
                });
            }

            if(recent_order_table) recent_order_table.clear();

            if(response.recent_orders){
                response.recent_orders.forEach((item, index) => {
                    var html = `
                    <tr>
                        <td>${(index+1)}</td>    
                        <td>${item.order_number}</td>    
                        <td>
                            <h5 class="mb-0">${item.customer_name}</h5>
                            <span>${item.customer_email}</span>
                            <span>${item.customer_phone_number}</span>
                        </td>    
                        <td><span class="badge rounded-pill bg-dark">${item.order_type}</span></td>    
                        <td>${item.order_date_format}</td>    
                        <td><span class="badge rounded-pill bg-${(item.status == 'PENDING' ? 'dark' : (item.status == 'APPROVED' ? 'success' : 'danger'))}">${item.status}</span></td>    
                    </tr>
                    `;

                    if(recent_order_table) recent_order_table.row.add($(html));
                });
            }
            if(recent_order_table) recent_order_table.draw();
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