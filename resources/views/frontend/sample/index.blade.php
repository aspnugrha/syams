@extends('frontend.layouts.app')

@section('content')
<section class="newsletter bg-light border-bottom" style="background: url(images/pattern-bg.png) no-repeat;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 py-5 my-5">
          <div class="subscribe-header text-center pb-3">
            <h3 class="section-title text-uppercase">Request Sample Form</h3>
            <span class="text-muted">Fill out the form to get a sample</span>
          </div>
          <form action="{{ route('login.process') }}" method="POST" id="form" class="d-flex flex-wrap gap-2">
            <input type="email" name="email" placeholder="Your Email Addresss" class="form-control form-control-lg" required value="{{ request()->email }}">
            <input type="password" name="password" placeholder="********" class="form-control form-control-lg" required>
            <span class="text-muted my-2">Don't have an account? <a href="{{ route('register').(request()->email? '?email='.request()->email : '') }}">Register</a></span>
            <button type="submit" class="btn btn-dark btn-lg text-uppercase w-100">Send Request</button>
          </form>
        </div>
      </div>
    </div>
</section>
@endsection