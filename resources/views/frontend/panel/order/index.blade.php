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
            <div class="column-container bg-white w-100">
                <div class="collection-content p-4 m-0 m-md-5 text-dark">
                    <h4 class="mb-4 mt-1">My Request Order</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered text-dark" id="table-data">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i=0;$i<50;$i++)
                                <tr>
                                    <td>1</td>
                                    <td>SAMPLE-123</td>
                                    <td>06 Oktober 2025 12:00</td>
                                    <td>Pending</td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#table-data').DataTable()
</script>
@endsection