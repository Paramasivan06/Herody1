@extends('layouts.app')
@section('title',config('app.name').' | My Campaigns')
@section('content')
        @include('includes.user-sidebar')
    <div class="page-content p-5" id="content">
	@include('includes.col-btn')
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<h4 class="fz18 mb30">Applied Campaigns</h4>
						</div>
					</div>
                    @if($campaigns->count()==0)
                        <p>No data found</p>
                    @else
					<div class="row applyed_job">
                    @foreach($campaigns as $campaign)
                        <?php
                            $c = DB::table('campaigns')->find($campaign->cid);
                            if($campaign->status==0):
                                $status = "Applied";
                            elseif($campaign->status==1):
                                $status = "Selected, submit Response";
                            elseif($campaign->status==2):
                                $status = "Application rejected, apply again";
                            elseif($campaign->status==3):
                                $status = "Response Submitted";
                            elseif($campaign->status==4):
                                $status = "Selected, paid";
                            elseif($campaign->status==5):
                                $status = "Response rejected, submit again";
                            endif;
                        ?>
						<div class="col-sm-12 col-lg-12">
							<div class="fj_post">
								<div class="details">
									<h5 class="job_chedule text-thm mt0">{{$c->city}}</h5>
									<div class="thumb fn-smd">
										<img class="img-fluid" src="{{asset('assets/admin/img/camp-brand-logo/'.$c->logo)}}" width="130px" alt="Company Profile Image">
									</div>
									<a href="{{route('mission.details',$c->id)}}"><h4>{{$c->title}}</h4></a>
									<p>End Date {{\Carbon\Carbon::parse($c->end)->format('d M Y')}} by <a class="text-thm" href="#company">{{$c->brand}}</a></p>
									<ul class="featurej_post">
										<li class="list-inline-item"><span class="flaticon-price pl20"></span> <a href="#stipend">{{$c->reward}}</a></li>
										<li class="list-inline-item"><a href="#applied">Applied at: {{\Carbon\Carbon::parse($campaign->created_at)->format('d M Y')}}</a></li>
										<li class="list-inline-item"><a href="#status">Status: <div class="badge badge-dark">{{$status}}</div></a></li>
									</ul>
								</div>
							</div>
                        </div>
                        @endforeach
                    </div>
                    {{$campaigns->links()}}
                    @endif
				</div>
			</div>
		</div>
	</section>
@endsection