@extends('backend.layouts.app')
@section('content')
<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-content-center">
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal-filter"><i class="mdi mdi-filter-cog-outline"></i> Filter</button>
                    <div class="btn-group">
                        <button class="btn btn-info btn-sm" onclick="$('#form-filter').submit()"><i class="mdi mdi-file-export-outline"></i> Export</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="table-data">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Order Number</th>
                                <th>Customer</th>
                                <th>Order Date</th>
                                <th>Total Product</th>
                                <th>Order Type</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->
</div>
<div class="modal fade" id="modal-filter" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="font-size: 15px;">Filter Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('api.order.export') }}" method="POST" id="form-filter">
            @csrf
            {{-- <div class="form-group">
                <label>Dibuat tanggal</label>
                <input type="text" class="form-control" name="filter_created_at" id="filter_created_at">
            </div> --}}
            <div class="form-group">
                <label>Customers</label>
                <select name="filter_customer_id" id="filter_customer_id" class="form-control w-100">
                    <option value="">Pilih Customer</option>
                    @foreach ($customers as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} | {{ $item->email }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Order tanggal</label>
                <input type="text" class="form-control" name="filter_order_date" id="filter_order_date">
            </div>
            <div class="form-group">
                <label>Order Type</label>
                <select name="filter_order_type" id="filter_order_type" class="form-control">
                    <option value="">Pilih Type</option>
                    <option value="SAMPLE">Sample</option>
                    <option value="ORDER">Order</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="filter_status" id="filter_status" class="form-control">
                    <option value="">Pilih Status</option>
                    <option value="PENDING">Pending</option>
                    <option value="APPROVED">Approved</option>
                    <option value="CANCELED">Canceled</option>
                </select>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-dark btn-sm" id="btn-apply-filter" onclick="loadData();$('#modal-filter').modal('hide')">Apply</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
    let table = '';
    $(document).ready(function(){
        $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});	
        loadData()

        $('#filter_customer_id').select2({
            placeholder: "Pilih Customer",
            dropdownParent: $('#form-filter')
        })

        // $('#filter_created_at').daterangepicker({
        //     autoUpdateInput: false,
        //     locale: {
        //         cancelLabel: 'Clear'
        //     }
        // });
  
        // $('#filter_created_at').on('apply.daterangepicker', function(ev, picker) {
        //     $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        // });
  
        // $('#filter_created_at').on('cancel.daterangepicker', function(ev, picker) {
        //     $(this).val('');
        // });

        $('#filter_order_date').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
  
        $('#filter_order_date').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });
  
        $('#filter_order_date').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    })

    $('.card').on('click','.modal-show',function(event){
        event.preventDefault();

        var me = $(this),
            url = me.attr('href'),
            title = me.attr('title'),
            status = me.attr('data-status'),
            id = me.attr('data-id');

        $('#modal-lg-title').text(title);
        $('#modal-lg-btn-save').removeClass('hidden').removeClass('d-none')
        .html('<i class="mdi mdi-content-save-check-outline"></i> '+(me.hasClass('edit') ? 'Update' : 'Create'));
        if(me.hasClass('detail') || me.hasClass('delete')) $('#modal-lg-btn-save').addClass('d-none');

        $.ajax({
            url: url,
            dataType: 'html',
            success: function(response){
                var btn_cancel = `<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>`
                var btn_approve_request = `<button type="button" class="btn btn-success btn-sm" onclick="setStatus('approved', '${id}')">Approve This Request</button>`
                var btn_cancel_request = `<button type="button" class="btn btn-danger btn-sm" onclick="setStatus('canceled', '${id}')">Cancel This Request</button>`
                var html = ``

                if(status == 'PENDING'){
                    html += btn_approve_request+btn_cancel_request;
                }else if(status == 'APPROVED'){
                    html += btn_cancel_request;
                }else if(status == 'CANCELED'){
                    html += btn_approve_request;
                }

                $('#modal-footer-lg').html(html);
                $('#modal-lg-body').html(response);
            }
        });

        $('#modal-lg').modal('show');
    });

    $('.modal-btn-save').on('click', function(event) {
        event.preventDefault();

        $('.custom-loader-overlay').css('display', 'flex')

        var form = $('.modal-body #formData'),
            url = form.attr('action');
        // Clear Validation
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.form-group').removeClass('has-error');

        $.ajax({
            url: url,
            method: 'POST',
            data: new FormData(document.getElementById("formData")),
            processData: false,
            contentType: false,
            cache: false,
            success: function(response) {
                console.log(response);
                if (response.success == true) {
                    form.trigger('reset');
                    $('#modal-default').modal('hide');

                    showToastr('toast-top-right', 'success', "Data berhasil disimpan")

                    table.ajax.reload(null, false);
                } else {
                    showToastr('toast-top-right', 'error', "Terjadi kesalahan, silahkan ulangi kembali")
                }
            },
            error: function(xhr) {
                var res = xhr.responseJSON;
                if ($.isEmptyObject(res) == false) {
                    console.log(res.errors);
                    
                    $.each(res.errors, function(key, value) {
                        $('#' + key)
                            // .closest('#error')
                            .addClass('is-invalid');
                        $('#' + key + 'Help').text(value.join(', '))
                    });
                }
                    
                showToastr('toast-top-right', 'error', "Please check the form for errors")
            },
            complete:function(){
                $('.custom-loader-overlay').css('display', 'none')
            }
        });
    });

    $('.card').on('click', '.delete', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var title = $(this).attr('title');
        
        // Confirm dialog based on action type
        var confirmText = title.includes('Delete') ? 
            'Are you sure you want to delete this data?' : 
            'Are you sure you want to restore this data?';
        
        
        var confirmButtonText = title.includes('Delete') ? 'Yes, delete it!' : 'Yes, restore it!';
        var confirmButtonColor = title.includes('Delete') ? '#dc3545' : '#ffc107';

        console.log(url, title);
        
        
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
                    type: 'DELETE',
                    success: function(response) {
                        console.log('delete', response);
                        
                        if(response.success) {
                            // Show success toast notification
                            toastr.success(
                                title.includes('Delete') ? 
                                'Data has been delete successfully!' : 
                                'Data has been restored successfully!',
                                'Success!'
                            );
                            
                            // Reload only the current page data
                            table.ajax.reload(null, false);
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
    });

    function setStatus(condition, id){
        var confirmText = condition == 'approved' ? 
            'Are you sure you want to Approve this request?' : 
            'Are you sure you want to Cancel this request?';
        
        var confirmButtonText = condition == 'approved' ? 'Yes, approve it!' : 'Yes, cancel it!';
        var confirmButtonColor = condition == 'approved' ? '#52c41a' : '#ff4d4f';
        
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
                    url: "{{ route('api.order.set-status') }}",
                    data: {
                        id: id,
                        status: condition.toUpperCase(),
                    },
                    type: 'POST',
                    success: function(response) {
                        console.log('delete', response);
                        
                        if(response.success) {
                            // Show success toast notification
                            toastr.success(
                                condition == 'approved' ? 
                                'Data has been approved successfully!' : 
                                'Data has been canceled successfully!',
                                'Success!'
                            );
                            
                            $('#modal-lg').modal('hide');
                            // Reload only the current page data
                            table.ajax.reload(null, false);
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
                    }
                });
            }
        });
    }

    function loadData(){
        table = $('#table-data').DataTable({
            destroy: true,
            responsive: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            start: 0,
            ajax: {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('api.order.load-data') }}",
                type: "POST",
                // data: $('#form-filter').serialize(),
                data: function(d){
                    d.start= (d.start != null)? d.start : 0;
                    d.search= d.search;
                    // d.created_at=$('#filter_created_at').val();
                    d.customer_id=$('#filter_customer_id').val();
                    d.order_date=$('#filter_order_date').val();
                    d.order_type=$('#filter_order_type').val();
                    d.status=$('#filter_status').val();
                    // d.search= $('#searchValue').val();
                },
                statusCode: {
                    401:function() {
                        location.reload();
                        let timerInterval
                            Swal.fire({
                            title: 'Silahkan Login Kembali!',
                            html: 'Session telah habis<b></b>.',
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                b.textContent = Swal.getTimerLeft()
                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                            }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                console.log('I was closed by the timer')
                            }
                        })
                    },
                },
                "error": function(xhr, error, thrown) {
                    console.log("Error occurred!");
                },
            },
            columns: [
                {
                    data: null,
                    sortable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {
                    data: "id", 
                    name: "id",
                    width: "200px",
                    render: function(data, type, row, meta) {
                        return `<b class="p-1" style="background-color: #eee;">${row.order_number}</b>`;
                    },
                },
                {
                    data: "id", 
                    name: "id",
                    render: function(data, type, row, meta) {
                        return `<h5 class="mb-0">${row.customer_name}</h5>
                        <span style="font-size: 13px;">${row.customer_email}</span>
                        <span style="font-size: 13px;">${row.customer_phone_number}</span>`;
                    }
                },
                {
                    data: "id", 
                    name: "id",
                    width: "120px",
                    render: function(data, type, row, meta) {
                        return `<span style="font-size: 13.5px;">${row.order_date_format}</span>`;
                    }
                },
                {
                    data: "id", 
                    name: "id",
                    render: function(data, type, row, meta) {
                        return (row.details ? row.details.length : 0)+' Product';
                    }
                },
                {
                    data: "id", 
                    name: "id",
                    render: function(data, type, row, meta) {
                        return `<span class="badge bg-dark rounded-pill">${row.order_type}</span>`;
                    }
                },
                {
                    data: "id", 
                    name: "id",
                    render: function(data, type, row, meta) {
                        return `<span class="badge rounded-pill bg-${(row.status == 'PENDING' ? 'dark' : (row.status == 'APPROVED' ? 'success' : 'danger'))}">${row.status}</span>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        let url_detail = `{{ route('paneladmin.order.show', ':id') }}`;
                            url_detail = url_detail.replace(':id', row.id);

                        var btn = `
                            <div class="btn-group">
                                <a href="${url_detail}" class="btn btn-sm btn-default modal-show detail" title="Detail Order" data-status="${row.status}" data-id="${row.id}"><i class="mdi mdi-magnify"></i></a>
                            </div>`

                        return btn;
                    },
                    // className: "text-center text-nowrap"
                }
            ]
        });
    }
</script>
@endsection