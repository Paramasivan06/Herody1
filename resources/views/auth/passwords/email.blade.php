@extends('layouts.app')
@section('title', config('app.name').' | Reset Password')
@section('content')
<section>
    <div class="block remove-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="account-popup-area signup-popup-box static">
                        <div class="account-popup">
                            <h3>Reset Password</h3>
                            <form action="{{ route('password.email') }}" method="POST">
                                @csrf
                                <div class="cfield">
                                    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autocomplete="email" autofocus>
                                    <i class="la la-user"></i>
                                </div>
                                <button type="submit">{{ __('Send Password Reset Link') }}</button>
                            </form>
                        </div>
                    </div><!-- SIGNUP POPUP -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
