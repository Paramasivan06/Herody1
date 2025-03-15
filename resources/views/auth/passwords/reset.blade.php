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
                            <form action="{{ route('password.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="cfield">
                                    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autocomplete="email" autofocus>
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="cfield">
                                    <input id="password" placeholder="Enter new password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    <i class="fa fa-lock"></i>
                                </div>
                                <div class="cfield">
                                <input id="password-confirm" placeholder="Confirm new password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    <i class="fa fa-lock"></i>
                                </div>
                                <button type="submit">{{ __('Reset Password') }}</button>
                            </form>
                        </div>
                    </div><!-- SIGNUP POPUP -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
