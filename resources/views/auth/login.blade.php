@extends('layouts.app')
@section('title', config('app.name').' | Login')
@section('heads')
    <style type="text/css">
  .mobileShow {display: none;}

  /* Smartphone Portrait and Landscape */
  @media only screen and (min-device-width : 320px) and (max-device-width : 480px){ 
      .mobileShow {display: inline;}
  }
</style>
@endsection
@section('content')
<!-- Mirrored from Viti2 -->

<section>
    <div class="block no-padding  gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner2">
                        <div class="inner-title2">
                            <h3>Candidate</h3>
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
                            <form action="{{route('login')}}" method="POST">
                                @csrf
                                <div class="cfield">
                                    <input name="user_name" type="text" placeholder="Email" />
                                    <i class="la la-user"></i>
                                </div>
                                <div class="cfield">
                                    <input name="password" type="password" placeholder="Password" />
                                    <i class="la la-key"></i>
                                </div>
                                <span class="float-right"><a href="{{ route('password.request') }}" class="btn-link">Forgot Password?</a></span>
                                <button type="submit">Signin</button>
                            </form>
                            <div class="extra-login">
                                <span>Or</span>
                                <div class="sign-info">
                                    <span class="dark-color d-inline-block line-height-2">Do Not Have Account ? <a href="{{ route('register') }}">Sign Up</a></span>
                                
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

@section('scripts')

<script>
    function logint(){
        window.location = "truecallersdk://truesdk/web_verify?requestNonce=14523678&partnerKey=SELIu8fd241fbfbd34429a4ed17e79d6bea4f&partnerName=Herody&lang=en&title=Login";

        setTimeout(function() {

        if( document.hasFocus() ){
            alert('You do not have truecaller app installed on your device');
        }
        else{
            
            }
        }, 600);
    }
</script>
@endsection