@extends('admin.master')

@section('title', 'Admin | Create Employer')
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
        <h4 class="text-center">Create Company</h4>
            <form action="{{route('admin.employer.create')}}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="form-group mb-3">
                    <label for="name">Enter PoC Name</label>
                    <input type="text" class="form-control form-control-lg" name="name" placeholder="Enter PoC Name" >
                </div>
                <div class="form-group mb-3">
                    <label for="cname">Enter brand name</label>
                    <input type="text" class="form-control form-control-lg" name="cname" placeholder="Enter brand name" >
                </div>
                <div class="form-group mb-3">
                     <label class="form-label" for="profile_photo">Thumbnail:</label>
                            <input id="profile_photo" type="file" accept=".png,.jpeg,.jpg" class="form-control" name="profile_photo">
                    
                    </div>
                <div class="form-group mb-3">
                    <label for="description">Enter About Company</label>
                    <textarea name="description"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Enter Password</label>
                    <input type="password" name="password" class="form-control form-control-lg">
                </div>
                
                <div class="form-group mb-3">
                    <label for="phone">Enter Phone</label>
                    <input type="text" name="phone" class="form-control form-control-lg">
                </div>
                <div class="form-group mb-3">
                    <label for="email">Enter Email</label>
                    <input type="text" name="email" class="form-control form-control-lg">
                </div>
                <div class="form-group mb-3">
                    <label for="email_verified"></label>
                    <input name="email_verified" type="text" value="1" class="form-control form-control-lg">
                </div>
                <div class="form-group mb-3">
                    <label for="website">Enter website</label>
                    <input type="text" name="website" class="form-control form-control-lg">
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