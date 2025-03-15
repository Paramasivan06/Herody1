@extends('layouts.app')
@section('title', config('app.name').' | Internships')
@section('content')
<div class="theme-layout" id="scrollup">
	<section class="overlape">
		<div class="block no-padding">
			<div data-velocity="-.1" style="background: url(images/resource/mslider1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
			<div class="container fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="inner-header">
							<h3>Internships</h3>
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
         @if($jobs->count()==0)
          <div class="col-md-12 col-xs-12"><h3>No data found</h3></div>
         @else
				 	<div class="col-lg-12">
				 		<div class="job-grid-sec">
							<div class="row">
              @foreach($jobs as $job)
                <?php
                    $e = DB::table('employers')->find($job->user);
                    $user = $e->cname;
                ?>
								<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
									<div class="job-grid border">
										<div class="job-title-sec">
											<div class="c-logo"> <img src="{{asset('assets/employer/profile_images/'.$e->profile_photo)}}" alt="Company Logo" /> </div>
											<h3><a href="{{route('job.details',$job->id)}}" title="">{{$job->title}}</a></h3>
											<span>{{$user}}</span>
										</div>
										<span class="fas fa-hourglass-half"> {{$job->duration}}</span><hr>
                    <span class="fas fa-users"> {{$job->count}} Positions</span>
										<a href="{{route('job.details',$job->id)}}"><i class="fas fa-coins"></i> Rs.{{$job->stipend}}</a>
									</div><!-- JOB Grid -->
                </div>
                @endforeach
							</div>
            </div>
              {{$jobs->links()}}
            @endif
				 	</div>
				 </div>
			</div>
		</div>
	</section>

</div>
@endsection