@extends('layouts.app')
@section('title',config('app.name').' | Enter OTP')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Enter OTP</h2>
            <form action="{{route('employer.verify.emailr')}}" method="POST">
            @csrf
                <div class="input-group mb-3">
                    <label for="otp">Enter OTP</label>
                    <input type="text" name="otp">
                </div>
                <a href="{{route('employer.verify.email')}}" class="btn btn-link mb-2">Resend Code</a>
                <input type="hidden" name="otpv" value="{{$otp}}">
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection