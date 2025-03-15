<?php
  $proofs = explode(',',$job->proofs);
?>
@extends('layouts.app')
@section('title', config('app.name').' | Internship Details')
@section('content')
<div class="theme-layout" id="scrollup">

	<section class="overlape">
		<div class="block no-padding">
			
			<div class="container fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="inner-header">
							<h3>{{$job->title}}</h3>
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
							 				<div class="job-thumb"> <img src="{{asset('assets/employer/profile_images/'.$emp['profile_photo'])}}" alt="Company Logo" /></div>
							 				<div class="job-single-info3">
							 					<h3>{{$emp['cname']}}</h3>
							 					<span><i class="fa fa-map-marker"></i>[{{$emp['city']}}, {{$emp['country']}}]</span><span class="job-is ft">{{$job->cat}}</span>
							 					<ul class="tags-jobs">
								 					<li><i class="fa fa-users"></i> Positions: {{$job->count}}</li>
								 					<li><i class="fa fa-calendar-o"></i> Apply Before Date: {{\Carbon\Carbon::parse($job->end)->format('d M Y')}}</li>
								 					<li><i class="fa fa-eye"></i> Duration: {{$job->duration}}</li>
								 				</ul>
							 				</div>
							 			</div><!-- Job Head -->
				 					</div>
				 					<div class="col-lg-4">
                   @if(Auth::check())
                      @if(DB::table('selects')->where(['uid' => Auth::user()->id,'jid' => $job->id])->exists())
                      <button class="apply-thisjob" data-toggle="modal" data-target="#proofs"><i class="fa fa-paper-plane"></i>Submit proofs</button>
                      @elseif(DB::table('project_apps')->where(['uid' => Auth::user()->id,'jid' => $job->id])->exists())
                      <a class="apply-thisjob" href="{{route('user.projects.show')}}"><i class="fa fa-paper-plane"></i>Already Applied</a>
                      @else
                      <button class="apply-thisjob" data-toggle="modal" data-target="#apply"><i class="fa fa-paper-plane"></i>Apply for internship</button>
                      @endif
                  @else
                      <button class="apply-thisjob" data-toggle="modal" data-target="#apply"><i class="fa fa-paper-plane"></i>Apply for internship</button>
                  @endif
				 						
								 		
				 					</div>
				 				</div>
				 			</div>
				 			<div class="job-wide-devider">
							 	<div class="row">
							 		<div class="col-lg-8 column">		
							 			<div class="job-details">
							 				<h3>About Internship</h3>
                       {!!$job->des!!}
                      <h3>About Company</h3>
                      {!!$emp['description']!!}
                      <h3>Internship Start Date:</h3>
							 				<p>{{\Carbon\Carbon::parse($job->start)->format('d M Y')}}</p>
							 				<h3>Internship Benefits</h3>
                        <ul>
                          <li>Certificate</li>
                          <li>Stipend: {{$job->stipend}}</li>
                        </ul>
                          {!!$job->benefits!!}
                      <h3>Skills Required</h3>
                      {!!$job->skills!!}
                      <h3>Proofs Required:</h3>
                        <ul>
                        @foreach($proofs as $proof)
                          @if($proof!="")
                            <li>{{$proof}}</li>
                          @endif
                        @endforeach
                        </ul>
							 			</div>
							 			
								
							 		</div>
							 		<div class="col-lg-4 column">
							 			<div class="job-overview">
								 			<h3>Internship Overview</h3>
								 			<ul>
								 				<li><i class="fa fa-money"></i><h3>Offerd Stipend</h3><span>{{$job->stipend}}</span></li>
                         <li><i class="fa fa-puzzle-piece"></i><h3>Industry</h3><span>{{$job->cat}}</span></li>
                         <li><i class="fa fa-map-marker"></i><h3>Work Place</h3><span>{{$job->place}}</span></li>
								 			</ul>
								 		</div>
							 		</div>

                   
                   <div class="row mt-2">
                          @if($emp['facebook']!=NULL)
                          <div class="col-md-12 col-lg-5 mr-2 mt-1 shadow border rounded p-2">
                            <a href="{{$emp['facebook']}}"><i class="fab fa-facebook fa-lg"></i> {{$emp['facebook']}}</a>
                          </div>
                          @endif
                          @if($emp['twitter']!=NULL)
                          <div class="col-md-12 col-lg-5 mr-2 mt-1 shadow border rounded p-2">
                            <a href="{{$emp['twitter']}}"><i class="fab fa-twitter fa-lg"></i> {{$emp['twitter']}}</a>
                          </div>
                          @endif
                          @if($emp['gplus']!=NULL)
                          <div class="col-md-12 col-lg-5 mr-2 mt-1 shadow border rounded p-2">
                            <a href="{{$emp['gplus']}}"><i class="fab fa-google-plus fa-lg"></i> {{$emp['gplus']}}</a>
                          </div>
                          @endif
                          @if($emp['youtube']!=NULL)
                          <div class="col-md-12 col-lg-5 mr-2 mt-1 shadow border rounded p-2">
                            <a href="{{$emp['youtube']}}"><i class="fab fa-youtube fa-lg"></i> {{$emp['youtube']}}</a>
                          </div>
                          @endif
                          @if($emp['vimeo']!=NULL)
                          <div class="col-md-12 col-lg-5 mr-2 mt-1 shadow border rounded p-2">
                            <a href="{{$emp['vimeo']}}"><i class="fab fa-vimeo fa-lg"></i> {{$emp['vimeo']}}</a>
                          </div>
                          @endif
                          @if($emp['linkedin']!=NULL)
                          <div class="col-md-12 col-lg-5 mr-2 mt-1 shadow border rounded p-2">
                            <a href="{{$emp['linkedin']}}"><i class="fab fa-linkedin fa-lg"></i> {{$emp['linkedin']}}</a>
                          </div>
                          @endif
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

<!-- Proof Modal -->
<div class="modal fade" id="proofs" tabindex="-1" role="dialog" aria-labelledby="proofs" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Submit Proof</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('job.proof')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
        <input type="hidden" name="id" value="{{$job->id}}">
      @if(in_array('Link',$proofs))
          <div class="form-group">
              <label for="link">Link</label>
              <input type="text" name="link" class="form-control">
          </div>
        @endif
        @if(in_array('File',$proofs))
          <div class="form-group">
              <label for="file">File</label><br>
              <input type="file" name="file" id="file" style="display:none">
              <button type="button" class="btn btn-warning btn-lg" onclick="document.getElementById('file').click();">Upload File</button>
          </div>
        @endif
        @if(in_array('Image',$proofs))
          <div class="form-group">
              <label for="image">Image</label><br>
              <input type="file" name="image" id="image" style="display:none">
              <button type="button" class="btn btn-warning btn-lg" onclick="document.getElementById('image').click();">Upload Image</button>
          </div>
        @endif
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
    </div>

<!-- Apply Modal -->
<div class="modal fade" id="apply" tabindex="-1" role="dialog" aria-labelledby="apply" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Apply for the internship</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('job.apply')}}">
          @csrf
          <input type="hidden" name="id" value="{{$job->id}}">
      <div class="modal-body">
        <div class="row">
        @foreach($questions as $qus)
          <div class="col-lg-12">
            <span class="pf-title">{{$qus->question}}</span>
            <div class="pf-field">
              <input type="text" name="answer[]" placeholder="Answer" required>
            </div>
          </div>
        @endforeach
        </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
    </div>
@endsection