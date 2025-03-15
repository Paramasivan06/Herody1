@extends('layouts.app')
@section('title',config('app.name').' | My Project')
@section('content')
        @include('includes.user-sidebar')
    <div class="page-content p-5" id="content">
	@include('includes.col-btn')
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<h4 class="fz18 mb30">Applied Projects</h4>
						</div>
					</div>
                    @if($jobas->count()==0)
                        <p>No data found</p>
                    @else
					<div class="row applyed_job">
                    @foreach($jobas as $joba)
                        <?php
                            $job = DB::table('projects')->find($joba->jid);
                            $status = "Applied";
                            if(DB::table('shortlisteds')->where(['uid'=>Auth::user()->id,'jid'=>$joba->jid])->exists()){
                                $status = "Shortlisted";
                            }
                            if(DB::table('selects')->where(['uid'=>Auth::user()->id,'jid'=>$joba->jid])->exists()){
                                $status = "Selected";
                            }
                            if(DB::table('rejects')->where(['uid'=>Auth::user()->id,'jid'=>$joba->jid])->exists()){
                                $status = "Rejected";
                            }
                            $emp = DB::table('employers')->find($job->user);
                        ?>
						<div class="col-sm-12 col-lg-12">
							<div class="fj_post">
								<div class="details">
									<h5 class="job_chedule text-thm mt0">{{$job->place}}</h5>
									<div class="thumb fn-smd">
										<img class="img-fluid" src="{{asset('assets/employer/profile_images/'.$emp->profile_photo)}}" width="130px" alt="Company Profile Image">
									</div>
									<a href="{{route('job.details',$job->id)}}"><h4>{{$job->title}}</h4></a>
									<p>Posted {{\Carbon\Carbon::parse($job->created_at)->format('d M Y')}} by <a class="text-thm" href="#company">{{$emp->cname}}</a></p>
									<ul class="featurej_post">
										<li class="list-inline-item"><span class="flaticon-price pl20"></span> <a href="#stipend">{{$job->stipend}}</a></li>
										<li class="list-inline-item"><a href="#applied">Applied at: {{\Carbon\Carbon::parse($joba->created_at)->format('d M Y | H:i:s')}}</a></li>
										<li class="list-inline-item"><a href="#status">Status: <div class="badge @if($status=='Applied') badge-warning @elseif($status=='Shortlisted') badge-info @elseif($status=='Selected') badge-success @elseif($status=='Rejected') badge-danger @endif">{{$status}}</div></a></li>
									</ul>
								</div>
							</div>
                        </div>
                        @endforeach
                    </div>
                    {{$jobas->links()}}
                    @endif
				</div>
			</div>
		</div>
	</section>
@endsection