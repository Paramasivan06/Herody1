@extends('layouts.app')
@section('title',config('app.name').' | Confirmation')

@section('content')
<!-- Our Dashbord -->
	<section class="cnddte_fvrt our-dashbord dashbord">
		<div class="container">
			<div class="row">
          @include('includes.emp-sidebar')
				<div class="col-sm-12 col-lg-8 col-xl-9">
					<div class="row">
						<div class="col-lg-12">
							<h4 class="mb30">Confirmation</h4>
						</div>
						<div class="col-lg-12">
            <div class="col-lg-12">
                        <center>
                            <img src="{{asset('assets/employer/images/employer-confirmation-icon.png')}}" alt="Confirmation">
                            <h2 class="mt-4">Thank you for submitting</h2>
                            <p>Thank you for submitting, admin will approve your project in 24-48 hrs.</p>
                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <a href="{{route('employer.dashboard')}}" class="btn btn-primary mb-2">Dashboard</a>
                            </div>
                            <div class="col-lg-6">
                                <a href="{{route('employer.job.manage')}}" class="btn btn-primary mb-2">Manage Projects</a>
                            </div>
                        </div>
                        </center>
                    </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection