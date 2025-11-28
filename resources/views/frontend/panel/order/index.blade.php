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
            <div class="column-container bg-white w-100 pb-3">
                <div class="collection-content p-4 m-0 m-md-5 text-dark">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-2 mt-1">My Request Order</h5>
                            <p class="text-muted mb-4 p-0">List of orders you have made with the status Pending, Approved and Canceled.</p>
                        </div>
                        {{-- <div class="">
                            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modal-filter"><i class="mdi mdi-filter-cog-outline"></i> Filter</button>
                        </div> --}}
                    </div>
                    <form id="form-filter" class="row g-1 mb-4">
                        @csrf
                        <div class="col-12 col-md-4">
                            <input type="text" name="search" class="form-control mb-2 w-100" placeholder="Search order number..." onkeyup="loadData()">
                        </div>
                        <div class="col-12 col-md-2">
                            <input type="text" name="created_at" id="created_at" class="form-control mb-2 w-100" placeholder="Filter date" onchange="loadData()">
                        </div>
                        <div class="col-6 col-md-2">
                            <select name="order_type" id="order_type" class="form-control mb-2" onchange="loadData()">
                                <option value="">Select order type</option>
                                <option value="SAMPLE" {{ request()->order_type == 'SAMPLE' ? 'selected' : '' }}>Sample</option>
                                <option value="ORDER" {{ request()->order_type == 'ORDER' ? 'selected' : '' }}>Order</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <select name="status" id="status" class="form-control mb-2" onchange="loadData()">
                                <option value="">Select status</option>
                                <option value="PENDING">Pending</option>
                                <option value="APPROVED">Approved</option>
                                <option value="CANCELED">Canceled</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <select name="order_by" id="order_by" class="form-control mb-2" onchange="loadData()">
                                <option value="desc" selected>Newest</option>
                                <option value="asc">Oldest</option>
                            </select>
                        </div>
                    </form>

                    <div class="w-100" id="list-orders">
                        
                    </div>
                    <button type="button" class="btn btn-dark w-100 mt-4 d-none" id="btn-load-more" onclick="loadMore()">Load More</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let start = 0;
let length = 10;
let total_showed_data = 0;
let total_data = 0;

$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#created_at').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('#created_at').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        loadData();
    });

    $('#created_at').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        loadData();
    });

    loadData('html')
});

function loadData(condition){
    $('.custom-loader-overlay').css('display', 'flex')
    var postData = new FormData($('#form-filter')[0]);
    postData.append('start', start)
    postData.append('length', length)

    // console.log(start, length);

    $.ajax({
        url: "{{ route('my-order.load-data') }}",
        type: "POST",
        data: postData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(data) {
            console.log(data)
            total_data = data.recordsTotal;
            total_showed_data = parseInt(total_showed_data) + parseInt(data.recordsFiltered);
            
            // console.log(total_data, total_showed_data);

            if(total_showed_data < total_data){
                $('#btn-load-more').removeClass('d-none');
            }else{
                $('#btn-load-more').addClass('d-none');
            }

            showData(data.data, condition)
        },
        error:function(xhr){
            console.log('error', xhr);
        },
        complete:function(){
            $('.custom-loader-overlay').css('display', 'none')
        },
    });
}

function loadMore(){
    start = parseInt(start) + parseInt(length);
    length = parseInt(length);

    if(start <= total_data){
        loadData('append')
    }
}

function showData(data, condition){
    var html = ``;

    if(data){
        data.forEach(item => {
            let link_detail = "{{ route('my-order.show', ':id') }}";
            link_detail = link_detail.replace(':id', item.order_number_encode);

            html += `
                <a href="${link_detail}" class="card w-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 col-md-1 d-flex justify-content-center align-content-center">`
                                if(item.status == 'PENDING'){
                                    html += `<i class="mdi mdi-invoice-text-clock-outline text-dark" style="font-size: 40px;"></i>`
                                }else if(item.status == 'APPROVED'){
                                    html += `<i class="mdi mdi-invoice-text-check-outline text-success" style="font-size: 40px;"></i>`
                                }else if(item.status == 'CANCELED'){
                                    html += `<i class="mdi mdi-invoice-text-remove-outline text-danger" style="font-size: 40px;"></i>`
                                }
                    html += `</div>
                            <div class="col-9 col-md-4">
                                <span class="badge bg-dark mb-2">${item.order_type}</span>
                                <h5 class="p-0 m-0" style="font-weight: 500;font-size: 16px;">${item.order_number}</h5>
                            </div>
                            <div class="col-12 col-md-3 align-content-center">
                                <p class="my-2 p-0 text-dark" style="font-size: 15px;">${item.order_date_format}</p>
                            </div>
                            <div class="col-12 col-md-2 align-content-center">
                                <p class="mb-2 p-0" style="font-size: 15px;">${item.details.length} Product</p>
                            </div>
                            <div class="col-12 col-md-2 justify-content-center align-content-center">`
                                if(item.status == 'PENDING'){
                                    html += `<span class="badge bg-dark w-100 w-sm-100 w-md-auto py-2 py-md-auto"><i class="mdi mdi-clock-outline" style="font-size: 14px;"></i> ${item.status}</span>`
                                }else if(item.status == 'APPROVED'){
                                    html += `<span class="badge bg-success w-100 w-sm-100 w-md-auto py-2 py-md-auto"><i class="mdi mdi-check-decagram-outline" style="font-size: 14px;"></i> ${item.status}</span>`
                                }else if(item.status == 'CANCELED'){
                                    html += `<span class="badge bg-danger w-100 w-sm-100 w-md-auto py-2 py-md-auto"><i class="mdi mdi-close-outline" style="font-size: 14px;"></i> ${item.status}</span>`
                                }
                    html += `</div>
                        </div>
                    </div>
                </a>
            `;
        });
    }

    if(condition == 'append'){
        $('#list-orders').append(html)
    }else{
        $('#list-orders').html(html)
    }
}
</script>
@endsection