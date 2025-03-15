@extends('layouts.app')
@section('title',config('app.name').' | Student Benefits and Requirements')

@section('content')
<div class="theme-layout" id="scrollup">
	

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
					 				<div class="step">
					 					<p><i class="fa fa-info"></i></p>
					 					<span>Information</span>
					 				</div>
					 				<div class="step active">
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
					 			<form action="{{route('employer.job.benefits')}}" method="POST">
                   @csrf
					 				<div class="row">
					 					<div class="col-lg-12">
					 						<span class="pf-title">No. of Positions</span>
					 						<div class="pf-field">
                        <input type="text" name="count" value="{{old('count')}}" placeholder="Number of users Required">
					 						</div>
					 					</div>
                    <input type="hidden" name="pending" value="{{$pending}}">
					 		
                    <div class="col-lg-6">
					 						<span class="pf-title">Select Workplace</span>
					 						<div class="pf-field">
					 						<select class="custom-select" name="place">
                          <option value="" selected>Select Work Place</option>
                          <option value="Work From Home">Work From Home</option>
                          <option value="In-Office">In-Office</option>
												</select>
					 						</div>
                     </div>
                     
                                        
                    <div class="col-lg-12">
					 						<span class="pf-title">Additional benefits</span>
					 						<div class="pf-field">
                        <textarea name="benefits">{{old('benefits')}}</textarea>
											</div>
                     </div>     
                    <div class="col-lg-12">
					 						<span class="pf-title">Skills Required</span>
					 						<div class="pf-field">
                        <textarea name="skills">{{old('skills')}}</textarea>
											</div>
                     </div>
                     
                    <div class="col-lg-12">
					 						<span class="pf-title">Stipend <small>Eg.1000</small></span>
					 						<div class="pf-field">
                        <input type="text" name="stipend" value="{{old('stipend')}}" placeholder="Enter Stipend">
					 						</div>     
                     </div>
                    <div class="col-lg-12">
					 						<span class="pf-title">Proofs</span>
					 						<div class="pf-field">
                         <div class="custom-control custom-checkbox mb-3">
                          <input type="checkbox" id="file" name="proofs[]" value="File" > <label for="file">File</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-3">
                          <input type="checkbox" id="image" name="proofs[]" value="Image" > <label  for="image">Image</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-3">
                          <input type="checkbox" id="link" name="proofs[]" value="Link" > <label  for="link">Link</label>
                        </div>
					 						</div>     
                     </div>
                    <div class="col-lg-12">
						<span class="pf-title">Add Questions</span>
						<div id="qus">
                        	<input type="text" name="question[]" placeholder="Enter Question">
						</div>
					 	<button type="button" onclick="addq()">Add more questions</button>
                     </div>
                     
					<div class="col-lg-12">
						<button type="submit">Next</button>
					</div>
                    <br>

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
    CKEDITOR.replace('benefits');
    CKEDITOR.replace('skills');
</script>
<script id="qsc">
	<input type="text" name="question[]" placeholder="Enter Question">
</script>
<script>
function addq(){
	$("#qus").append($("#qsc").html());
}
</script>
@endsection