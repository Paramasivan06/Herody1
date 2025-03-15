@extends('layouts.app')
@section('title',config('app.name').' | Selected Resumes')

@section('content')
<div class="theme-layout" id="scrollup">
	<section class="overlape">
		<div class="block no-padding"><script src="https://kit.fontawesome.com/f3e18a60ac.js" crossorigin="anonymous"></script>
			<div data-velocity="-.1" style="background: url(images/resource/mslider1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
			<div class="container fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="inner-header">
							<h3>Welcome {{$employer->cname}}</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="block remove-bottom">
			<div class="container">
				 <div class="row no-gape">
           @include('includes.emp-sidebar')
				 	<div class="col-sm-12 col-lg-8 col-xl-9">
           @if($jas->count()==0)
            <div><h1>No data found</h1></div>
            @else
            @foreach($jas as $ja)
            <?php
                $user = DB::table('users')->find($ja->uid);
            ?>
                    @if($user)
				 		<div class="emply-resume-sec">
				 			<div class="emply-resume-list square">
				 				<div class="emply-resume-thumb">
				 					<img src="@if($user->profile_photo!=NULL){{asset('assets/user/images/user_profile/'.$user->profile_photo)}} @else {{asset('assets/user/images/frontEnd/demo.png')}} @endif" alt="" />
				 				</div>
				 				<div class="emply-resume-info">
				 					<h3><a href="{{route('applicant.view',$ja->uid)}}" title="">{{$user->name}}</a></h3>
                  <p><i class="la la-map-marker"></i>{{$user->state}}</p>
				 				</div>
				 				<div class="shortlists">
									@if($ja->status==5)
									<a href="#certificate" class="mr-2 mt-2" title="">Cerificate Issued <i class="fa fa-certificate"></i></a>
									 @else
									 <a href="{{route('employer.job.issue_certificate',[$ja->jid,$ja->uid])}}" class="mr-2 mt-2" title="">Cerificate <i class="fa fa-certificate"></i></a>
									 @endif
									 @if($ja->status==6)
				 					<a href="!#pay" class="mr-2 mt-2" title="">Paid <i class="fa fa-money-bill"></i></a>
									 @else
				 					<a href="#pay" onclick="pay('{{$ja->uid}}')" class="mr-2 mt-2" title="">Pay <i class="fa fa-money-bill"></i></a>
									 @endif
				 					<a href="{{route('applicant.view',$ja->uid)}}" target="_blank" class="mr-2 mt-2" title="">View Profile <i class="fa fa-eye"></i></a>
				 					<a href="{{route('employer.job.proofs',[$ja->jid,$ja->uid])}}" target="_blank" class="mr-2 mt-2" title="">View Proof <i class="fa fa-eye"></i></a>
				 				</div>
				 			</div>
			 </div>
			 @endif
             @endforeach
             {{$jas->links()}}
			 @endif
			 @if($id)
			 <a href="{{route('job.details',$id)}}" class="btn btn-primary btn-sm mb-2">View Internship details</a>
			 <a href="{{route('employer.job.applications',$id)}}" class="btn btn-primary btn-sm mb-2">Go back to applications</a>
			 <a href="{{route('employer.job.exportsl',$id)}}" class="btn btn-primary btn-sm mb-2">Export Selecteds</a>
			 @endif
					</div>
				 </div>
			</div>
		</div>
	</section>
</div>
@if($id)
{{-- Modal --}}
<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Enter Amount</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <form action="{{route('employer.job.payout',[$id])}}" method="post">
			@csrf
			<input type="hidden" name="uid" id="paymuid">
			<div class="form-group">
				<span class="form-control-label" for="title">@lang('Enter amount to pay')</span>
				<input type="number" name="stipend" class="form-control" placeholder="Enter amount to pay">
			</div>
			<button type="submit">Pay</button>
		  </form>
		</div>
	  </div>
	</div>
  </div>
  @endif
@endsection
@section('scripts')
<script>
	function pay(uid){
		$('#paymuid').val(uid);
		$("#payModal").modal("show");
	}
</script>
@endsection