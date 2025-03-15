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
        <h4 class="text-left">Edit Project</h4>
            <form action="{{route('admin.mission.update',$campaign->id)}}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="form-group mb-3">
                    <label for="title">Enter Campaign title</label>
                    <input type="text" class="form-control form-control-lg" name="title" placeholder="Enter Project name" value="{{$campaign->title}}" >
                </div>
                <div class="form-group mb-3">
                    <label for="ucount">No of Users Allowed </label>
                    <input type="number" class="form-control form-control-lg" name="ucount" placeholder="Enter no of users allowed" value="{{$campaign->ucount}}"  >
                </div>
                <div class="form-group mb-3">
                    <label for="des">Enter Campaign Description</label>
                    <textarea name="des">{{$campaign->des}}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="reward">Enter Rewards</label>
                    <input type="number" name="reward"  value="{{$campaign->reward}}" class="form-control form-control-lg">
                </div>
                
                
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('des');
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