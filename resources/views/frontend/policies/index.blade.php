@extends('frontend.layouts.app')

@section('styles')
<style>

</style>
@endsection
@section('content')
<div class="w-100" style="padding-bottom: 100px;">
    <div class="container mb-4 pt-5">
        <h5 class="mt-5 mb-4">{{ ucfirst($code).' Policy'  }}</h5>
        <article class="">
            @if ($code == 'privacy')
            {!! $company->privacy !!}
            @elseif($code == 'refund')
            {!! $company->refund !!}
            @else
            {!! $company->shipping !!}
            @endif
        </article>
    </div>
</div>

@endsection