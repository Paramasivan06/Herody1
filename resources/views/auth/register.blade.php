<?php
// echo "<script>location.href='".env('APP_PLAYSTORE')."'</script>";
if(isset($_GET['code']))
    $ref_by = $_GET['code'];
?>
@extends('layouts.app')
@section('title', config('app.name').' | Register')
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
                            <h3>Sign Up</h3>
                            <form action="{{route('register')}}" method="POST">
                                @csrf
                                <div class="cfield">
                                    <input name="name" type="text" placeholder="Full Name" />
                                    <i class="la la-user"></i>
                                </div>
                                <div class="cfield">
                                    <input name="ref_by" value="{{$ref_by??''}}" type="text" placeholder="Referal Code(if any)" />
                                    <i class="la la-user"></i>
                                </div>
                                <div class="cfield">
                                    <input name="password" type="password" placeholder="Password" />
                                    <i class="la la-key"></i>
                                </div>
                                <div class="cfield">
                                    <input name="password_confirmation" type="password" placeholder="Confirm Password" />
                                    <i class="la la-key"></i>
                                </div>
                                <div class="cfield">
                                    <input name="email" type="text" placeholder="Email" />
                                    <i class="la la-envelope-o"></i>
                                </div>
                                <div class="cfield">
                                    <input name="phone" type="text" placeholder="Phone Number" />
                                    <i class="la la-phone"></i>
                                </div>
                                <button type="submit">Signup</button>
                            </form>
                            <div class="extra-login">
                                <span>Or</span>
                                <div class="sign-info">
                                    <span class="dark-color d-inline-block line-height-2">Already Have Account ? <a href="{{ route('login') }}">Log In</a></span>
                                    
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
        window.location = "truecallersdk://truesdk/web_verify?requestNonce=14523678&partnerKey=SRobj958d9bc3136c4a1b9397728bd5074932&partnerName=Herody&lang=en&title=Login";

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