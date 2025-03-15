<?php
    $refs = \App\User::where('ref_by',$user->id)->get();
    $text = rawurlencode("Hey, have you checked out ".config('app.name')." yet? It's Student reward app that has Gigs & Projects provide you exciting rewards. User this code ".$user->ref_code." while registering, to get 5% earnings on ".config('app.name')." Cash.\n ".url('/register?code='.$user->ref_code));
    // For referrals
    $radds = \App\Transition::where('uid',$user->id)->where('reason','LIKE','%Referral Bonus%')->get();
    if($radds->count()==0){
        $ra = 0;
    }
    else{
        $ra = 0;
        foreach($radds as $radd){
            $ra = $ra + $radd->addm;
        }
    }
    // For gigs
    $gadds = \App\Transition::where('uid',$user->id)->where('reason','LIKE','%Gig%')->get();
    if($gadds->count()==0){
        $ga = 0;
    }
    else{
        $ga = 0;
        foreach($gadds as $gadd){
            $ga = $ga + $gadd->addm;
        }
    }
    // For projects
    $padds = \App\Transition::where('uid',$user->id)->where('reason','LIKE','%Project%')->get();
    if($padds->count()==0){
        $pa = 0;
    }
    else{
        $pa = 0;
        foreach($padds as $padd){
            $pa = $pa + $padd->addm;
        }
    }
    // For campaigns
    $cadds = \App\Transition::where('uid',$user->id)->where('reason','LIKE','%Campaign%')->get();
    if($cadds->count()==0){
        $ca = 0;
    }
    else{
        $ca = 0;
        foreach($cadds as $cadd){
            $ca = $ca + $cadd->addm;
        }
    }
?>
@extends('layouts.app')
@section('title',config('app.name').' | All withdrawal method')
@section('heads')
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
@endsection
@section('content')
        @include('includes.user-sidebar')
    <div class="page-content p-5" id="content">
    
	@include('includes.col-btn')
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<h4 class="mb30">Wallet</h4>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="ff_one">
								<div class="icon"><span class="flaticon-wallet"></span></div>
								<div class="detais">
									<div class="timer">{{$user->balance}}</div>
								<p>Wallet Balance</p>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="ff_one style2">
								<div class="icon"><img src="{{asset('assets/viti_new/images/referral.svg')}}" height="58" width="40"></div>
								<div class="detais">
									<div class="timer">{{$refs->count()}}</div>
									<p>Referred</p>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="ff_one style2">
								<div class="icon"><span class="flaticon-wallet"></span></div>
								<div class="detais">
									<div class="timer">{{$ra}}</div>
									<p>Earned through referral</p>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="ff_one style2">
								<div class="icon"><span class="flaticon-wallet"></span></div>
								<div class="detais">
									<div class="timer">{{$ga}}</div>
									<p>Earned by completing gigs</p>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="ff_one style2">
								<div class="icon"><span class="flaticon-wallet"></span></div>
								<div class="detais">
									<div class="timer">{{$pa}}</div>
									<p>Earned by completing projects</p>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="ff_one style2">
								<div class="icon"><span class="flaticon-wallet"></span></div>
								<div class="detais">
									<div class="timer">{{$ca}}</div>
									<p>Earned by completing campaigns</p>
								</div>
							</div>
						</div>
                    </div>
                            
						<div class="col-xl-8">
							<div class="application_statics">
                                <h4>Transactions</h4>
                                @if($trs->count()==0)
                                <p>No transactions found.</p>
                                @else
								<table>
                                    <tr>
                                        <th>ID</th>
                                        <th>Earnings</th>
                                        <th>Source</th>
                                    </tr>
                                    @foreach($trs as $tr)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td style="color:@if($tr->transition[0]=="+") #34A853 @else red @endif">{{$tr->transition}}</td>
                                        <td>{{$tr->reason}}</td>
                                    </tr>
                                    @endforeach
                                </table>
                                @endif
							</div>
						</div>
							<div class="recent_job_apply">
								<h4 class="title">Share Code for Referral Rewards</h4>
								<div class="">
									<h4 class="sub_title">Share code to Earn {{config('app.name')}} Cash</h4>
									<p>Share {{config('app.name')}} Referral Code with your Friends & earn 5% rewards on your friends earnings for the lifetime.</p>
									<h4 class="sub_title float-center">Refer Options</h4>
							<br>
                                </div>
                                <div class="row">
								<div class="col-xl-4">
                                   <a target="_blank" href="https://wa.me/?text={{$text}}" type="share" class="btn btn-block color-white bg-green"><i class="fab fa-whatsapp float-left mt5"></i> Whatsapp</a><br>
                                </div>
                                <div class="col-xl-4">
                                    <button type="share" class="btn btn-block color-black bgc-white"><i class="fa fa-share-alt float-right mt5"></i> Other Options</button>
                                </div>
                                </div>
							</div>
                        </div>
                        </div></div>

                        
                        
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="row">
                                @foreach($withdrawMethods as $withdrawMethod)
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow flipInX text-center"
                                         data-wow-delay="0.6s"
                                         style="visibility: visible; animation-delay: 0.6s; animation-name: flipInX;">
                                        <div class="single-sidebar-block essential-sidebar pranto-plan"
                                             style="box-shadow: 0px 5px 24.25px 0.75px rgba(0, 0, 0, 0.1);">
                                            <h3>{{__($withdrawMethod->name)}}</h3>
                                            <img class="mb-4 mt-4"
                                                 src="{{asset('assets/user/images/withdraw/'.$withdrawMethod->image)}}"/>
                                            

                                            <a href="#" class="btn my-btn-bg btn-block text-dark"
                                               data-id="{{$withdrawMethod->id}}"
                                               data-userBalance="{{$user->balance}}"
                                               data-toggle="modal" data-target="#withdrawR">@lang('Withdraw Now')</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
						 
					</div>
				</div>
			</div>
		</div>
	</section>


    <div class="modal fade" id="withdrawR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Withdraw your balance') </h4>
                </div>
                <form action="{{route('user.withdraw_preview')}}" method="post">
                    @csrf
                    <div class="modal-body">

                        <input type="hidden" name="methodId" id="id">

                        <h5 class=" font-weight-bold text-info mb-4">@lang('Your Current Balance :')  {{"Rs. "}} {{Auth::user()->balance}}</h5>

                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="withdrawAmount" class="form-control" placeholder="@lang('Amount you want to withdraw')" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">{{"Rs. "}}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn btn-success">@lang('Preview')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



@section('scripts')
    {{--remove script--}}
    <script>
        $('#withdrawR').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget);
            var id = button.data('id');

            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        })
    </script>

@endsection