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
        <article>
            {!! $company->description !!}
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Laborum quia odit nisi reiciendis sunt esse, nam accusantium deleniti eius sed! Nulla perspiciatis quidem culpa doloremque eius aut saepe ad! Et culpa provident amet mollitia quaerat?
        </article>
    </div>
</div>
@endsection