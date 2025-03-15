@extends('layouts.app')
@section('title', config('app.name').' | Gigs')
@section('content')
<div class="theme-layout" id="scrollup">
	
<section class="overlape">
		<div class="block no-padding">
			<div data-velocity="-.1" style="background: url(images/resource/mslider1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
			<div class="container fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="inner-header">
							<h3>Gigs</h3>
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
				 	<div class="col-lg-12">
           @if($campaigns->count()==0)
            <div class="col-md-12 col-xs-12"><h3>No data found</h3></div>
           @else
				 		<div class="job-grid-sec">
							<div class="row">
                                @foreach($campaigns as $campaign)
                                <?php 
                                    if($campaign->user_id=="Admin"){
                                        $user = "Admin";
                                    }
                                    else{
                                        $usere = DB::table('employers')->find($campaign->user_id);
                                        $user = $usere->name;
                                    }
                                    
                                    $cats = explode(", ",$campaign->cats);
                                    $count = 0;
                                    foreach($cats as $cat){
                                        $count++;
                                    }
                                ?>
								<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
									<div class="job-grid border">
										<div class="job-title-sec">
											<div class="c-logo"> <img src="@if($user=='Admin') {{asset('assets/admin/img/gig-brand-logo/'.$campaign->logo)}} @else {{asset('assets/employer/profile_images/'.$usere->profile_photo)}} @endif" alt="Company Logo" /> </div>
											<h3><a href="{{route('campaign.details',$campaign->id)}}">{{$campaign->campaign_title}}</a></h3>
											<span>{{$campaign->brand}}</span>
											
										</div>
										<span class="">Number of tasks: {{$count-1}}</span><hr>
										<a href="{{route('campaign.details',$campaign->id)}}"><i class="fas fa-coins"></i>{{$campaign->per_cost}}</a>
									</div><!-- JOB Grid -->
                </div>
                @endforeach
							</div>
            </div>
            {{$campaigns->links()}}
            @endif
				 	</div>
				 </div>
			</div>
		</div>
	</section>

</div>
@endsection