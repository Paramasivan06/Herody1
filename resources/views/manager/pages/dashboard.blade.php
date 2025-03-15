@extends('layouts.app')
@section('title',config('app.name').' | Manager Dashboard')
@section('content')
<!-- Our Dashbord -->
<section class="our-dashbord dashbord">
		<div class="container">
			<div class="row">
        @include('includes.manager-sidebar')
				<div class="col-sm-12 col-lg-8 col-xl-8">
					<div class="row">
						<div class="col-lg-12">
							<h4 class="mb30">Dashboard</h4>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="ff_one">
								<div class="icon"><span class="flaticon-paper-plane"></span></div>
								<div class="detais">
									<div class="timer">{{\App\Pending::get()->count()}}</div>
									<p>Pending Projects</p>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="ff_one style2">
								<div class="icon"><span class="flaticon-favorites"></span></div>
								<div class="detais">
									<div class="timer">{{\App\PendingGig::get()->count()}}</div>
									<p>Pending Gigs</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection