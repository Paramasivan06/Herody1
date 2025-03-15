<?php
    $cities = explode(',',$campaign->city);
    $c = "";
    foreach ($cities as $city) {
        $c = $city." ".$c;
    }
?>
@extends('layouts.app')
@section('title', config('app.name').' | Project Details')
@section('content')
<div class="theme-layout" id="scrollup">

	<section class="overlape">
		<div class="block no-padding">
			
			<div class="container fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="inner-header">
							<h3>{{$campaign->title}}</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="block">
			<div class="container">
				<div class="row">
				 	<div class="col-lg-12 column">
				 		<div class="job-single-sec style3">
				 			<div class="job-head-wide">
				 				<div class="row">
				 					<div class="col-lg-8">
				 						<div class="job-single-head3">
							 				<div class="job-thumb"> <img src="{{asset('assets/admin/img/camp-brand-logo/'.$campaign->logo)}}" alt="Company Logo" /> </div>
                                            
							 				<div class="job-single-info3">
							 					<h3>{{$campaign->brand}}</h3>
							 					
							 					<ul class="tags-jobs">
								 					<li><i class="fas fa-coins"></i> Reward: ₹{{$campaign->reward}}</li>
								 					<li><i class="fas fa-calendar"></i>Last Date: {{\Carbon\Carbon::parse($campaign->before)->format('d M Y')}}</li>
								 					<li><i class="fa fa-users"></i> Number of Positions: {{$campaign->ucount}} </li><br><br>
								 					<li><i class="fa fa-map-marker-alt"></i> City: {{$c}} </li>
								 					<li><i class="fa fa-coins"></i> {{$campaign->reward}} </li>
								 				</ul>
							 				</div>
							 			</div><!-- Job Head -->
				 					</div>
				 					<div class="col-lg-4">
                                        @if(Auth::check())
                                            @if(DB::table('campaign_apps')->where(['uid' => Auth::user()->id,'cid' => $campaign->id,'status'=>0])->exists())
                                                <a class="apply-thisjob" href="{{route('user.campaigns.show')}}"><i class="la la-paper-plane"></i>Already Applied</a>
                                            @elseif(DB::table('campaign_apps')->where(['uid' => Auth::user()->id,'cid' => $campaign->id,'status'=>1])->exists())
                                                <form action="{{route('campaign.responser')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$campaign->id}}">
                                                    <button type="submit" class="apply-thisjob"><i class="la la-paper-plane"></i>Submit Responses</button>
                                                </form>
                                            @elseif(DB::table('campaign_apps')->where(['uid' => Auth::user()->id,'cid' => $campaign->id,'status'=>3])->exists())
                                                <a class="apply-thisjob" href="{{route('user.campaigns.show')}}"><i class="la la-paper-plane"></i>Responses Submitted</a>
                                            @elseif(DB::table('campaign_apps')->where(['uid' => Auth::user()->id,'cid' => $campaign->id,'status'=>4])->exists())
                                                <a class="apply-thisjob" href="{{route('user.campaigns.show')}}"><i class="la la-paper-plane"></i>Selected</a>
                                            @else
                                                <button type="button" class="apply-thisjob" data-toggle="modal" data-target="#apply">Apply</button>
                                            @endif
                                        @else
                                            <a class="apply-thisjob" href="{{route('login')}}"><i class="fa fa-paper-plane"></i>Please login as a user</a>
                                        @endif
                                    </div>
				 				</div>
				 			</div>
                            
                            <div class="job-wide-devider">
                                <div class="row">
                                    <div class="col-lg-8 column">		
                                        <div class="job-details">
                                            <h3>About Project</h3>
                                            <p>{!!$campaign->des!!}</p>
                                        </div>		
                                        <div class="job-details">
                                            <h3>Benefits</h3>
                                            <p>{!!$campaign->benefits!!}</p>
                                        </div>
                                        <div class="job-details">
                                            <h3>Requirements</h3>
                                            <p>{!!$campaign->requirements!!}</p>
                                        </div>
                                        <div class="job-details">
                                            <h3>Do's & Don'ts</h3>
                                            <p>{!!$campaign->dondont!!}</p>
                                        </div>
                                        <div class="job-details">
                                            <h3>Instructions</h3>
                                            <p>{!!$campaign->instructions!!}</p>
                                        </div>
                                        <div class="job-details">
                                            <h3>Methods</h3>
                                            <p>{!!$campaign->methods!!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
				 	</div>
				</div>
			</div>
		</div>
	</section>
</div>

<!-- Modals -->

<!-- FB proof -->
<div class="modal fade" id="apply" tabindex="-1" role="dialog" aria-labelledby="Apply" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Apply for the project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <h3>Important Terms</h3>
          <p>{!!$campaign->imp_terms!!}</p>
          <h3 class="mt-2">Terms</h3>
          <p>{!!$campaign->terms!!}</p>
      <form method="post" action="{{route('mission.apply')}}">
          @csrf
          <input type="hidden" name="id" value="{{$campaign->id}}">
            <div class="pf-field mt-3">
                <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" id="terms" name="terms" value="Agree" class="custom-control-input"> <label class="custom-control-label" for="terms">I agree all the terms.</label>
                </div>
            </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Apply</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
@endsection