@extends('admin.master')

@section('title', 'Admin | Create Gig')
@section('heads')
<style>
    .cats{
        background: #ffff;
        color: black;
        box-shadow: 0 0 2px 2px gray;
        border-radius: 5px;
    }
</style>
@endsection

@section('body')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <h4 class="text-center">Create a Gig</h4>
            <form action="{{route('admin.store.campaign')}}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="form-group mb-3">
                    <label for="campaign_title">Enter gig name</label>
                    <input type="text" class="form-control form-control-lg" name="campaign_title" placeholder="Enter gig name" >
                </div>
                <div class="form-group mb-3">
                    <label for="brand">Enter brand name</label>
                    <input type="text" class="form-control form-control-lg" name="brand" placeholder="Enter brand name" >
                </div>
                <div class="form-group mb-3">
                    <input type="file" id="logo" name="logo" hidden>
                    <button onclick="document.getElementById('logo').click();" type="button" class="btn btn-success btn-lg">Upload brand logo</button>
                </div>
                <div class="form-group mb-3">
                    <label for="description">Enter about gig</label>
                    <textarea name="description"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="per_cost">Enter amount per user</label>
                    <input type="number" name="per_cost" class="form-control form-control-lg">
                </div>
                <div class="form-group mb-3">
                    <label for="cat">Choose categories for the gig</label><br>
                    @foreach($campaignCategory as $cat)
                    <div id="{{$cat->id}}">
                        <input type="checkbox" id="customCheck{{$cat->id}}" name="cat[]" value="{{$cat->id}}" class="custom-control-input" onchange="newtask(this)"> <label class="custom-control-label" for="customCheck{{$cat->id}}">{{$cat->name}}</label>
                    </div>
                    @endforeach
                </div>
                
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script id="taskhtml">
	<span>
	<input type="text" class="form-control mb-2" name="tasks[]" placeholder="Enter task description">
	<input type="text" class="form-control mb-2" name="filess[]" placeholder="Enter link of the file to be shared">
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
@endsection