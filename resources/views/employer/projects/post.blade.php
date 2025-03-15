@extends('layouts.app')
@section('title',config('app.name').' | Post an Project')

@section('content')
<div class="theme-layout">
	

	<section class="overlape">
		<div class="block no-padding">
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
		<div class="block no-padding">
			<div class="container">
				 <div class="row no-gape">
          @include('includes.emp-sidebar')
				 	<div class="col-sm-12 col-lg-8 col-xl-9">
				 		<div class="padding-left">
					 		<div class="profile-title">
					 			<h3>Post a New Project</h3>
					 			<div class="steps-sec">
					 				<div class="step active">
					 					<p><i class="fa fa-info"></i></p>
					 					<span>Information</span>
					 				</div>
					 				<div class="step">
					 					<p><i class="fab fa-cc-mastercard"></i></p>
					 					<span>Benefits & Workplace</span>
					 				</div>
					 				<div class="step">
					 					<p><i class="fa  fa-check-circle"></i></p>
					 					<span>Done</span>
					 				</div>
					 			</div>
					 		</div>
					 		<div class="profile-form-edit">
					 			<form action="{{route('employer.job.post')}}" method="POST">
                   @csrf
					 				<div class="row">
					 					<div class="col-lg-12">
					 						<span class="pf-title">Project Title</span>
					 						<div class="pf-field">
                        <input type="text" value="{{old('title')}}" name="title" placeholder="Enter Title">
					 						</div>
					 					</div>
					 					<div class="col-lg-12">
					 						<span class="pf-title">Description</span>
					 						<div class="pf-field">
                        <textarea name="des">{{old('des')}}</textarea>
                      </div>
					 					</div>
                    <div class="col-lg-6">
					 						<span class="pf-title">Project Start Date</span>
					 						<div class="pf-field">
                        <input type="date" name="start" value="{{old('start')}}" class="form-control">
					 						</div>
					 					</div>
                    <div class="col-lg-6">
					 						<span class="pf-title">Apply Before Date</span>
					 						<div class="pf-field">
                        <input type="date" name="end" value="{{old('end')}}"  class="form-control">
					 						</div>
					 					</div>
					 					<div class="col-lg-6">
					 						<span class="pf-title">Project Duration</span>
					 						<div class="pf-field">
                        <input type="text" name="duration" value="{{old('duration')}}" placeholder="Project Duration">
					 						</div>
					 					</div>

					 					<div class="col-lg-6">
					 						<span class="pf-title">Category</span>
					 						<div class="pf-field">
                        <select name="cat" class="custom-select">
                            <option value="">Select a category</option>
                            @foreach($cats as $cat)
                                <option value="{{$cat}}" <?php if(old('cat')==$cat){ echo 'selected'; } ?>>{{$cat}}</option>
                            @endforeach
                        </select>
					 						</div>
                     </div>
                     
					 					<div class="col-lg-12">
					 						<button type="submit">Next</button>
					 					</div>
                    <br><br>
					 				</div>
					 			</form>
					 		</div>

					 	</div>
					</div>
				 </div>
			</div>
		</div>
  </section>
  
</div>

@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('des');
</script>
@endsection