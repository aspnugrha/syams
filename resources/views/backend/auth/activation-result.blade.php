@extends('backend.layouts.auth')

@section('content')
<div class="collection bg-light position-relative">
    <div class="container">
        <div class="collection-item d-flex flex-wrap pb-5 pt-5">
            <div class="column-container bg-white w-100">
                <div class="collection-content p-4 m-0 m-md-5 text-dark">
                    @if ($data['success'])
                        <h4 class="mb-4 mt-1">Your account is now active!</h4>
                        <p class="mb-4">{{ $data['message'] }}</p>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('paneladmin.login') }}" class="btn btn-dark btn-lg text-uppercase w-100" style="width: 200px !important;">Login</a>
                        </div>
                    @else
                        @if ($data['status'] == 'activation-code')
                            <h4 class="mb-4 mt-1">There is something wrong!</h4>
                            <p class="mb-4">{{ $data['message'] }}</p>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('paneladmin.activation') }}" class="btn btn-dark btn-lg text-uppercase w-100" style="width: 280px !important;">Activate Account</a>
                            </div>
                        @elseif ($data['status'] == 'email')
                            <h4 class="mb-4 mt-1">There is something wrong!</h4>
                            <p class="mb-4">{{ $data['message'] }}</p>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('paneladmin.activation') }}" class="btn btn-dark btn-lg text-uppercase w-100" style="width: 280px !important;">Activate Account</a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
</script>
@endsection