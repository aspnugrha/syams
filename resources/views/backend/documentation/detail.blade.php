@extends('backend.layouts.app')
@section('content')
<div class="card card-body">
    <iframe src="{{ asset('assets/image/upload/documentation/'.$filename) }}" width="100%" height="600px"></iframe>
</div>
@endsection