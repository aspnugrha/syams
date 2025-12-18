@extends('frontend.layouts.app')

@section('styles')
<style>
.map-embed iframe{
    width: 100%;
}
</style>
@endsection
@section('content')
{{-- <div class="d-flex justify-content-center">
    <img class="py-4 my-4" src="{{ asset($company && $company->logo ? 'assets/image/upload/logo/'.$company->logo : 'assets/image/logo-syams.png') }}" alt="Logo {{ $company->name }}" style="width: 200px;">
</div> --}}
<div class="w-100" style="padding-bottom: 100px;">
    <div class="container mb-4 pt-5">
        <h5 class="mt-5 mb-4">About</h5>
        <article class="mb-4">
            {!! $company->description !!}
            {{-- Lorem ipsum dolor, sit amet consectetur adipisicing elit. Laborum quia odit nisi reiciendis sunt esse, nam accusantium deleniti eius sed! Nulla perspiciatis quidem culpa doloremque eius aut saepe ad! Et culpa provident amet mollitia quaerat? --}}
        </article>

        <table class="w-100">
            <tr>
                <td width="130px">Email</td>
                <td width="10px;">:</td>
                <td class="fw-semibold text-dark">{{ $company->email }}</td>
            </tr>
            <tr>
                <td>Phone Number</td>
                <td>:</td>
                <td class="fw-semibold text-dark">{{ $company->phone_number }}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>:</td>
                <td class="fw-semibold text-dark">{{ $company->alamat }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection