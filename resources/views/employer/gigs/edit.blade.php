@extends('layouts.app')

@section('title', config('app.name').' | Create Gigs')

@section('content')
<div class="theme-layout">
	<section class="overlape">
		<div class="block no-padding">
			<div data-velocity="-.1" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
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
<?php 
$cats = explode(',', $gig->cats); ?>
	<section>
		<div class="block no-padding">
			<div class="container">
				 <div class="row no-gape">
                        @include('includes.emp-sidebar')
				 	<div class="col-sm-12 col-lg-8 col-xl-9">
				 		<div class="padding-left">
					 		<div class="profile-title">
					 			<h3>Edit {{$gig->campaign_title}}</h3>

					 		</div>
					 		<div class="profile-form-edit">
					 			<form action="{{route('employer.gig.editp',$gig->id)}}" method="post">
                                     @csrf
					 				<div class="row">
					 					<div class="col-lg-12">
					 						<span class="pf-title">Gig Title</span>
					 						<div class="pf-field">
                                                <input type="text" name="campaign_title" placeholder="Enter gig name" value="{{$gig->campaign_title}}" >
					 						</div>
					 					</div>
					 					<div class="col-lg-12">
					 						<span class="pf-title">Gig Description</span>
					 						<div class="pf-field">
                                                <textarea name="description">{{$gig->description}}</textarea>
                                            </div>
					 					</div>
                                        <div class="col-lg-12">
					 						<span class="pf-title">Amount per person</span>
					 						<div class="pf-field">
                                                <input type="number" name="per_cost" value="{{$gig->per_cost}}" placeholder="Enter amount per person">
					 						</div>
					 					</div>
                                        <div class="col-lg-12">
					 						<span class="pf-title">Choose Task</span>
					 						<div class="pf-field">
                                                 @foreach($campaignCategory as $cat)
												<div id="{{$cat->id}}">
													<div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" @if(in_array($cat->id,$cats)) checked @endif id="customCheck{{$cat->id}}" name="cat[]" value="{{$cat->id}}" class="custom-control-input" onchange="newtask(this)"> <label class="custom-control-label" for="customCheck{{$cat->id}}">{{$cat->name}}</label>
                                                        @if(in_array($cat->id,$cats)) 
                                                            <span>
                                                            <input type="text" name="tasks[]" value="" value="" placeholder="Enter task description" style="height:1em;" required/>
                                                            <input type="text" name="filess[]" value="" placeholder="Enter link of the file to be shared" style="height:1em;" required/>
                                                            </span>
                                                        @endif
													</div>
												</div><br>
												<br>
												<br>
												<br>
                                                @endforeach
					 						</div>
                                         </div> 
                                         
                                        <div class="col-lg-12">
					 						<button type="submit">Submit</button>
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
{{-- @section('scripts')
<script id="taskhtml">
	<span>
	<input type="text" name="tasks[]" placeholder="Enter task description" style="height:1em;" required/>
	<input type="text" name="filess[]" placeholder="Enter link of the file to be shared" style="height:1em;" required/>
	</span>
</script>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>
<script>
    function newtask(obj){
		var a = $("#taskhtml").html();
		if($(obj).is(":checked")){
			$("#"+$(obj).attr('id').split('customCheck')[1]).append(a);
		}
		else{
			$('#'+$(obj).attr('id').split('customCheck')[1]+' span').remove()
		}
    }
</script>
@endsection --}}