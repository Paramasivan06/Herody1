@extends('layouts.app')
@section('title',config('app.name').' | Dashboard')
@section('content')
        @include('includes.user-sidebar')
    <div class="page-content p-5" id="content">
	@include('includes.col-btn')

		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-12">
							<h4 class="mb30">Dashboard</h4>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="ff_one">
								<div class="icon"><span class="flaticon-paper-plane"></span></div>
								<div class="detais">
									<div class="timer">{{$user->jobs->count()}}</div>
									<p>Projects Applied</p>
									<p><a href="{{route('user.projects.show')}}">View</a></p>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="ff_one">
								<div class="icon"><span class="flaticon-paper-plane"></span></div>
								<div class="detais">
									<div class="timer">{{$user->gigs->count()}}</div>
									<p>Gigs Applied</p>
									<p><a href="{{route('user.gigs.show')}}">View</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	</div>
@endsection