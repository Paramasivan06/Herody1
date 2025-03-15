@extends('layouts.app')
@section('title',config('app.name').' | withdraw preview')
@section('content')


    <!-- inner-page-banner-section start -->
    <section class="inner-page-banner-section"
             style="background: url({{asset('assets/user/images/frontEnd/inner-page-bg.jpg')}})">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-page-banner-content text-center">
                        <h2 class="title">@lang('withdraw preview')</h2>
                    </div>
                    <nav aria-label="breadcrumb" class="page-header-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('Home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('withdraw preview')</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- inner-page-banner-section end -->

    <!-- popular-job-section start -->
    <section class="popular-job-section padd-top-120 padd-bottom-120 ">
        <div class="container">

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form class="contact-form" action="{{route('user.withdraw_confirm')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <ul>
                                        <li class="list-group-item">@lang('Request for Withdraw Amount:') Rs. <strong>{{$request_withdrawAmount}}</strong>
                                        </li>

                                    </ul>
                                </div>
                                <input type="hidden" name="requested_amount" value="{{$request_withdrawAmount}}">
                                <input type="hidden" name="withdraw_method_id" value="{{$withdraw_method_id}}">
                                <p>{{\App\Withdraw::find($withdraw_method_id)->detail}}</p>
                                
                                <div class="col-xl-12 col-lg-12">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" name="details"
                                                  placeholder="@lang('Type Your Payment Detail')" required=""></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row d-flex">
                                        <div class="col-xl-12 col-lg-12">
                                            <button type="submit"
                                                    class="btn btn-primary btn-lg btn-block  my-btn-bg "> @lang('Confirm
                                                Withdraw')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

        </div>
    </section>
    <!-- popular-job-section end -->



@endsection

