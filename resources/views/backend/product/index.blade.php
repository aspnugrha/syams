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
                        <a href="{{ route('product.create') }}" class="btn btn-dark btn-sm" title="Tambah Product"><i class="mdi mdi-playlist-plus"></i> Tambah</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="table-data">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Cover</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Active</th>
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
        <form action="{{ route('api.product.export') }}" method="POST" id="form-filter">
            @csrf
            <div class="form-group">
                <label>Category</label>
                <select name="filter_category_id" id="filter_category_id" class="form-control">
                    <option value="">Pilih Category</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Dibuat tanggal</label>
                <input type="text" class="form-control" name="filter_created_at" id="filter_created_at">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="filter_active" id="filter_active" class="form-control">
                    <option value="">Pilih Status</option>
                    <option value="1">Active</option>
                    <option value="0">Not Active</option>
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

        $('#filter_created_at').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
  
        $('#filter_created_at').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });
  
        $('#filter_created_at').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    })

    $('.card').on('click','.modal-show',function(event){
        event.preventDefault();

        var me = $(this),
            url = me.attr('href'),
            title = me.attr('title');

        $('#modal-default-title').text(title);
        $('#modal-default-btn-save').removeClass('hidden').removeClass('d-none')
        .html('<i class="mdi mdi-content-save-check-outline"></i> '+(me.hasClass('edit') ? 'Update' : 'Create'));
        if(me.hasClass('detail') || me.hasClass('delete')) $('#modal-default-btn-save').addClass('d-none');

        $.ajax({
            url: url,
            dataType: 'html',
            success: function(response){
                $('#modal-default-body').html(response);
            }
        });

        $('#modal-default').modal('show');
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

    $('.card').on('click', '.main-product', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var title = $(this).attr('title');
        
        // Confirm dialog based on action type
        var confirmText = title.includes('Main Product') ? 
            'Are you sure you want to make this data main product?' : 
            'Are you sure you want to restore this data?';
        
        
        var confirmButtonText = title.includes('Main Product') ? 'Yes, make it!' : 'Yes, restore it!';
        var confirmButtonColor = title.includes('Main Product') ? '#13c2c2' : '#ffc107';

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
                    type: 'GET',
                    success: function(response) {
                        console.log('delete', response);
                        
                        if(response.success) {
                            // Show success toast notification
                            toastr.success(
                                title.includes('Main Product') ? 
                                'Data has been main program successfully!' : 
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
                url: "{{ route('api.product.load-data') }}",
                type: "POST",
                // data: $('#form-filter').serialize(),
                data: function(d){
                    d.start= (d.start != null)? d.start : 0;
                    d.search= d.search;
                    d.created_at=$('#filter_created_at').val();
                    d.active=$('#filter_active').val();
                    d.category_id=$('#filter_category_id').val();
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
                    render: function(data, type, row, meta) {
                        var cover = ``
                        if(row.cover){
                            cover += `<img src="{{ asset('assets/image/upload/product') }}/${row.cover}" style="width: 100px;height: 100px;object-fit: cover;">`
                        }
                        if(row.image){
                            cover += `<div class="row g-1" style="margin-top: 1px;">`
                            const images = row.image.split(',');
                            images.forEach((image, index) => {
                                if(index <= 3){
                                    cover += `<div class="col-3">`
                                    
                                    if(index == 3 && images.length > (index + 1)) cover += `<div class="" style="position: absolute;margin: auto;z-index:3;"><p class="fw-bold custom-outline-white-black text-center p-0 m-0">+${(images.length - (index + 1))}</p></div>`

                                    cover += `<img src="{{ asset('assets/image/upload/product') }}/${image}" style="width: 100%;height: 25px;object-fit: cover;filter: blur(.7px);border: .5px solid #555;">
                                            </div>`
                                }
                            });
                            cover += `</div>`
                        }
						return cover;
                    }
                },
                // {data: "name", name: "name"},
                {
                    data: "id", 
                    name: "id",
                    render: function(data, type, row, meta) {
                        let name = `<span class="badge bg-dark rounded-pill">${row.category_name}</span><br>`
                        name += row.name

                        return name;
                    }
                },
                {
                    data: "id", 
                    name: "id",
                    render: function(data, type, row, meta) {
                        let desc = ''
                        if(row.description){
                            desc = row.description.replace(/<[^>]+>/g, '')
                            if(desc.length > 80) desc = desc.substring(0,80)+' ...'
                        }

                        return desc;
                    }
                },
                {
                    data: "id", 
                    name: "id",
                    render: function(data, type, row, meta) {
                        let active = ``
                        if (row.active == 1){
                            btn = `<span class="badge bg-success rounded-pill">Active</span>`;
                        }else{
                            btn = `<span class="badge bg-danger rounded-pill">Not Active</span>`;
                        }

                        if(parseInt(row.main_product) == 1){
                            btn += `<span class="badge bg-info rounded-pill">Main</span>`
                        }
						return btn;
                    },
                    className: 'text-center',
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        let url_detail = `{{ route('product.show', ':id') }}`;
                            url_detail = url_detail.replace(':id', row.id_encode);
                        let url_main_product = `{{ route('api.product.main-product', [':id', ':sts']) }}`;
                            url_main_product = url_main_product.replace(':id', row.id_encode);
                            url_main_product = url_main_product.replace(':sts', row.main_product);
                        let url_edit = `{{ route('product.edit', ':id') }}`;
                            url_edit = url_edit.replace(':id', row.id_encode);
                        let url_delete = `{{ route('product.destroy', ':id') }}`;
                            url_delete = url_delete.replace(':id', row.id);
                    

                        var btn = `
                            <div class="btn-group">
                                <a href="${url_detail}" class="btn btn-sm btn-default detail" title="Detail Product"><i class="mdi mdi-magnify"></i></a>
                                <a href="${url_main_product}" class="btn btn-sm btn-default main-product" title="${parseInt(row.main_product) ? `Restore Main Product` : `Main Product`}"><i class="mdi mdi-${(row.main_product ? `sync` : `star-outline`)}"></i></a>
                                <a href="${url_edit}" class="btn btn-sm btn-default edit" title="Edit Product"><i class="mdi mdi-pencil-outline"></i></a>
                                <a href="${url_delete}" class="btn btn-sm btn-default delete" title="Delete Product"><i class="mdi mdi-trash-can-outline"></i></a>
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