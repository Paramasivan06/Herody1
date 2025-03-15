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
							<h3>Welcome Manager</h3>
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
                        @include('includes.manager-sidebar')
				 	<div class="col-sm-12 col-lg-8 col-xl-8">
				 		<div class="padding-left">
					 		<div class="profile-title">
					 			<h3>Post a New Gig</h3>

					 		</div>
					 		<div class="profile-form-edit">
					 			<form action="{{route('manager.gig.create')}}" method="post" enctype="multipart/form-data">
                                     @csrf
					 				<div class="row">
					 					<div class="col-lg-12">
					 						<span class="pf-title">Gig Title</span>
					 						<div class="pf-field">
                                                <input type="text" name="campaign_title" placeholder="Enter gig name" >
					 						</div>
					 					</div>
					 					<div class="col-lg-12">
					 						<span class="pf-title">Brand Name</span>
					 						<div class="pf-field">
                                                <input type="text" name="brand" placeholder="Enter brand name" >
					 						</div>
					 					</div>
					 					<div class="col-lg-12">
					 						<span class="pf-title">Brand Logo</span>
					 						<div class="pf-field">
                                                <input type="file" id="logo" name="logo" accept=".png,.jpg,.bmp,.gif,.jpeg" onchange="getn(this.value)" hidden>
                                                <button onclick="document.getElementById('logo').click();" type="button" class="float-left btn btn-success btn-lg">Upload brand logo</button>
                                                <span id="getn"></span>
                                            </div>
					 					</div>
					 					<div class="col-lg-12">
					 						<span class="pf-title">Gig Description</span>
					 						<div class="pf-field">
                                                <textarea name="description"></textarea>
                                            </div>
					 					</div>
                                        <div class="col-lg-12">
					 						<span class="pf-title">Amount per person</span>
					 						<div class="pf-field">
                                                <input type="number" name="per_cost" placeholder="Enter amount per person">
					 						</div>
					 					</div>
                                        <div class="col-lg-12">
					 						<span class="pf-title">Choose Task</span>
					 						<div class="pf-field">
                                                 @foreach($campaignCategory as $cat)
												<div id="{{$cat->id}}">
													<div class="custom-control custom-checkbox mb-3">
														<input type="checkbox" id="customCheck{{$cat->id}}" name="cat[]" value="{{$cat->id}}" class="custom-control-input" onchange="newtask(this)"> <label class="custom-control-label" for="customCheck{{$cat->id}}">{{$cat->name}}</label>
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
@section('scripts')
<script id="taskhtml">
	<span>
	<input type="text" name="tasks[]" placeholder="Enter task description"/>
	<input type="text" name="filess[]" placeholder="Enter link of the file to be shared"/>
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

    function getn(ob){
        ob = ob.split(/(\\|\/)/g).pop();
        $('#getn').html(ob);
    }
</script>
@endsection