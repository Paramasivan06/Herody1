@extends('layouts.app')
@section('title', config('app.name').' | Login')
@section('content')
<!-- Mirrored from Viti2 -->
<section>
    <div class="block no-padding  gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner2">
                        <div class="inner-title2">
                            <h3>For Businesses</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="block remove-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="account-popup-area signup-popup-box static">
                        <div class="account-popup">
                            <h3>Sign In</h3>
                            <form action="{{route('employer.login')}}" method="POST">
                                @csrf
                                <div class="cfield">
                                    <input name="email" type="text" placeholder="Email" />
                                    <i class="la la-envelope-o"></i>
                                </div>
                                <div class="cfield">
                                    <input name="password" type="password" placeholder="Password" />
                                    <i class="la la-key"></i>
                                </div>
                                <button type="submit">Sign In</button>
                            </form>
                            <div class="extra-login">
                                <span>Or</span>
                                <div class="sign-info">
                                    <span class="dark-color d-inline-block line-height-2">Do not Have Account ? <a href="{{ route('employer.for-businesses') }}">Sign Up</a></span>
                                    
                                </div>
                            </div>
                        </div>
                    </div><!-- SIGNUP POPUP -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection