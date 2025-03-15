@extends('admin.master')

@section('title', 'Admin | Upload Job')
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
<div class="container mt-4">
    <h2 class="text-center">Upload Job</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.jobs.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="position">Position</label>
            <input type="text" class="form-control form-control-lg" name="position"  required>
        </div>

        <div class="form-group mb-3">
            <label for="location">Location</label>
            <input type="text" class="form-control form-control-lg" name="location" value="HSR Layout, Bengaluru, Karnataka" required>
        </div>

        <div class="form-group mb-3">
            <label for="pay">Pay</label>
            <input type="number" class="form-control form-control-lg" name="pay"  step="0.01" required>
        </div>

        <div class="form-group mb-3">
            <label for="job_type">Job Type</label>
            <input type="text" class="form-control form-control-lg" name="job_type" value="Full-time, Fresher, Permanent" required>
        </div>

        <div class="form-group mb-3">
            <label for="shift">Shift</label>
            <input type="text" class="form-control form-control-lg" name="shift" value="Day shift" required>
        </div>

        <div class="form-group mb-3">
            <label for="responsibilities">Responsibilities</label>
            <textarea class="form-control form-control-lg" name="responsibilities" rows="5" required>

            </textarea>
        </div>

        <!--<div class="form-group mb-3">-->
        <!--    <label for="requirements">Requirements</label>-->
        <!--    <textarea class="form-control form-control-lg" name="requirements" rows="5" required>-->
        <!--    </textarea>-->
        <!--</div>-->

        <button type="submit" class="btn btn-primary">Upload Job</button>
    </form>
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
    CKEDITOR.replace('responsibilities');
    CKEDITOR.replace('requirements');
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
