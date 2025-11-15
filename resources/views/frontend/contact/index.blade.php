@extends('frontend.layouts.app')

@section('styles')
<style>

</style>
@endsection
@section('content')
<div class="d-flex justify-content-center">
    <img class="py-4 my-4" src="{{ asset($company && $company->logo ? 'assets/image/'.$company->logo : 'assets/image/logo-syams.png') }}" alt="Logo {{ $company->name }}" style="width: 200px;">
</div>
<div class="w-100 border-bottom" style="padding-bottom: 100px;">
    <div class="container mb-4">
        <article>
            {!! $company->description !!}
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Laborum quia odit nisi reiciendis sunt esse, nam accusantium deleniti eius sed! Nulla perspiciatis quidem culpa doloremque eius aut saepe ad! Et culpa provident amet mollitia quaerat?
        </article>
    </div>
</div>

<div class="w-100 border-bottom">
    <div class="row">
        @if ($company->email)
        <div class="col-6 col-md-3 py-4 border-right sm-border-bottom">
            <a href="mailto:{{ $company->email ? $company->email : 'example@email.com' }}">
                <div class="d-flex justify-content-center"><i class="bi bi-envelope-fill fs-1 pt-4"></i></div>
                <p class="text-muted text-center py-4 px-2" style="overflow-wrap: anywhere;">{{ $company->email ? $company->email : 'example@email.com' }}</p>
            </a>
        </div>
        @endif
        @if ($company->phone_number)
        <div class="col-6 col-md-3 py-4 lg-border-right sm-border-bottom">
            <a href="tel:+{{ ($company && $company->phone_number ? $company->phone_number : '628') }}">
                <div class="d-flex justify-content-center"><i class="bi bi-telephone-fill fs-1 pt-4"></i></div>
                <p class="text-muted text-center py-4 px-2" style="overflow-wrap: anywhere;">+{{ ($company && $company->phone_number ? $company->phone_number : '628?') }}</p>
            </a>
        </div>
        @endif
        @if ($company->facebook)
        <div class="col-6 col-md-3 py-4 border-right">
            <a href="https://www.facebook.com/{{ $company->facebook ? $company->facebook : '?' }}">
                <div class="d-flex justify-content-center"><i class="bi bi-facebook fs-1 pt-4"></i></div>
                <p class="text-muted text-center py-4 px-2" style="overflow-wrap: anywhere;">www.facebook.com/{{ $company->facebook ? $company->facebook : '?' }}</p>
            </a>
        </div>
        @endif
        @if ($company->whatsapp)
        <div class="col-6 col-md-3 py-4">
            <a href="https://wa.me/628{{ $company->whatsapp ? $company->whatsapp : '?' }}">
                <div class="d-flex justify-content-center"><i class="bi bi-whatsapp fs-1 pt-4"></i></div>
                <p class="text-muted text-center py-4 px-2" style="overflow-wrap: anywhere;">wa.me/628{{ $company->whatsapp ? $company->whatsapp : '?' }}</p>
            </a>
        </div>
        @endif
    </div>
</div>

<div class="w-100 border-bottom">
    <div class="row">
        @if ($company->telegram)
        <div class="col-6 col-md-3 py-4 border-right sm-border-bottom">
            <a href="https://t.me/{{ $company->telegram ? $company->telegram : '?' }}">
                <div class="d-flex justify-content-center"><i class="bi bi-telegram fs-1 pt-4"></i></div>
                <p class="text-muted text-center py-4 px-2" style="overflow-wrap: anywhere;">t.me/{{ $company->telegram ? $company->telegram : '?' }}</p>
            </a>
        </div>
        @endif
        @if ($company->twitter)
        <div class="col-6 col-md-3 py-4 lg-border-right sm-border-bottom">
            <a href="https://twitter.com/{{ $company->twitter ? $company->twitter : '?' }}">
                <div class="d-flex justify-content-center"><i class="bi bi-twitter-x fs-1 pt-4"></i></div>
                <p class="text-muted text-center py-4 px-2" style="overflow-wrap: anywhere;">twitter.com/{{ $company->twitter ? $company->twitter : '?' }}</p>
            </a>
        </div>
        @endif
        @if ($company->youtube)
        <div class="col-6 col-md-3 py-4 border-right">
            <a href="https://www.youtube.com/{{ $company->youtube ? '@'.$company->youtube : '?' }}">
                <div class="d-flex justify-content-center"><i class="bi bi-youtube fs-1 pt-4"></i></div>
                <p class="text-muted text-center py-4 px-2" style="overflow-wrap: anywhere;">www.youtube.com/{{ $company->youtube ? '@'.$company->youtube : '@?' }}</p>
            </a>
        </div>
        @endif
        @if ($company->tiktok)
        <div class="col-6 col-md-3 py-4">
            <a href="https://www.tiktok.com/{{ $company->tiktok ? '@'.$company->tiktok : '?' }}">
                <div class="d-flex justify-content-center"><i class="bi bi-tiktok fs-1 pt-4"></i></div>
                <p class="text-muted text-center py-4 px-2" style="overflow-wrap: anywhere;">www.tiktok.com/{{ $company->tiktok ? '@'.$company->tiktok : '@?' }}</p>
            </a>
        </div>
        @endif
    </div>
</div>

@if ($company->maps)
<div class="map-embed">
    <iframe
        class="w-100 border-bottom" style="height: 500px;"
        id="gmapsIframe"
        src="{{ $company->maps }}"
        allowfullscreen
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="Google Maps - Monas"></iframe>
</div>
@endif
@endsection