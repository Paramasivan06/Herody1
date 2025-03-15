@extends('layouts.app')
@section('title',config('app.name').' | My Gig Applications')
@section('content')
        @include('includes.user-sidebar')
    <div class="page-content p-5" id="content">
        
	@include('includes.col-btn')
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<h4 class="fz18 mb30">Applied Gigs</h4>
						</div>
					</div>
                    @if($finishedTask->count()==0)
                        <p>No data found</p>
                    @else
					<div class="row applyed_job">
                    @foreach($finishedTask as $finished)
                            <?php
                                $camp = DB::table('gigs')->find($finished->cid); 
                                $emp = App\Employer::find($camp->user_id);
                            ?>
						<div class="col-sm-12 col-lg-12">
							<div class="fj_post">
								<div class="details">
									<div class="thumb fn-smd">
										<img class="img-fluid" src="{{asset('assets/employer/profile_images/'.$emp->profile_photo)}}" width="110px" alt="Company Profile Image">
									</div>
									<a href="{{route('campaign.details',$camp->id)}}"><h4>{{$camp->campaign_title}}</h4></a>
									<p>Posted {{\Carbon\Carbon::parse($camp->created_at)->format('d M Y')}} by <a class="text-thm" href="#company">{{$emp->cname}}</a></p>
									<ul class="featurej_post">
										<li class="list-inline-item"><span class="flaticon-price pl20"></span> <a href="#per_cost">{{$camp->per_cost}}</a></li>
										<li class="list-inline-item"><a href="#applied">Applied at: {{\Carbon\Carbon::parse($finished->created_at)->format('d M Y | H:i:s')}}</a></li>
										<li class="list-inline-item">
                                            <a href="#status">
                                                Status: 
                                                
                                            @if ($finished->status==0)
                                                <span class="badge  badge-pill  badge-info">@lang('Applied')</span>
                                            @elseif($finished->status==1)
                                                <span class="badge  badge-pill  badge-success">@lang('Application Approved')</span>
                                            @elseif($finished->status==2)
                                                <span class="badge  badge-pill  badge-danger">@lang('Application Rejected')</span>
                                            @elseif($finished->status==3)
                                                <span class="badge  badge-pill  badge-info">@lang('Proof Submitted')</span>
                                            @elseif($finished->status==4)
                                                <span class="badge  badge-pill  badge-success">@lang('Proof Accepted, Paid')</span>
                                            @elseif($finished->status==5)
                                                <span class="badge  badge-pill  badge-success">@lang('Proof Rejected')</span>
                                            @endif
                                            </a>
                                        </li>
									</ul>
								</div>
							</div>
                        </div>
                        @endforeach
                    </div>
                    {{$finishedTask->links()}}
                    @endif
				</div>
			</div>
		</div>
	</section>
@endsection