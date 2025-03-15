@extends('layouts.app')

@section('title', 'Manager | Create Telecalling Project')
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

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <h4 class="text-center">Create a Telecalling Project</h4>
            <form action="{{route('manager.telecalling.create')}}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="form-group mb-3">
                    <span for="title">Enter project title</span>
                    <input type="text" class="form-control form-control-lg" name="title" placeholder="Enter project title" >
                </div>
                <br/>
                <div class="form-group mb-3">
                    <span for="category">Enter project category</span>
                    <input type="text" class="form-control form-control-lg" name="category" placeholder="Enter project category" >
                </div>
                <br/>
                <div class="form-group mb-3">
                    <span for="company">Enter Company</span>
                    <input type="text" class="form-control form-control-lg" name="company" placeholder="Enter project company" >
                </div>
                <br/>
                <div class="form-group mb-3">
                    <span for="last_date">Enter project last date</span>
                    <input type="date" class="form-control form-control-lg" name="last_date" placeholder="Enter project last date" >
                </div>
                <br/>
                <div class="form-group mb-3">
                    <input type="file" id="logo" name="logo" hidden>
                    <button onclick="document.getElementById('logo').click();" type="button" class="btn btn-success">Upload project logo</button>
                </div>
                <br/>
                <h3 class="mt-3">Call Script</h3>
                <div class="form-group mb-3">
                    <span for="script_des">Call script description</span>
                    <textarea name="script_des"></textarea>
                </div>
                <div class="form-group mb-3">
                    <input type="file" id="script_img" name="script_img" hidden>
                    <button onclick="document.getElementById('script_img').click();" type="button" class="btn btn-success">Upload call script image(optional)</button>
                </div>

                <h3 class="mt-3">Demo Audio</h3>
                <div class="form-group mb-3">
                    <span for="audio_des">Demo audio description</span>
                    <textarea name="audio_des"></textarea>
                </div>
                <div class="form-group mb-3">
                    <input type="file" id="audio_file" name="audio_file" hidden>
                    <button onclick="document.getElementById('audio_file').click();" type="button" class="btn btn-success">Upload demo audio file(optional)</button>
                </div>

                <h3 class="mt-3">Call Objective</h3>
                <div class="form-group mb-3">
                    <span for="obj_des">Call objective description</span>
                    <textarea name="obj_des"></textarea>
                </div>
                <div class="form-group mb-3">
                    <input type="file" id="obj_img" name="obj_img" hidden>
                    <button onclick="document.getElementById('obj_img').click();" type="button" class="btn btn-success">Upload call objective image(optional)</button>
                </div>

                <h3 class="mt-3">Call Outcomes</h3>
                <div id="outcomes">
                    <div>
                        <div class="form-group mb-3">
                            <span for="outcome_title">Call outcome title</span>
                            <input type="text" name="outcome_title[]" placeholder="Enter outcome title" required class="form-control form-control-lg">
                        </div>
                        <div class="form-group mb-3">
                            <span for="outcome_des">Call outcome description</span>
                            <input type="text" name="outcome_des[]" placeholder="Enter outcome description" required class="form-control form-control-lg">
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addOutcome();" class="btn btn-secondary mb-3">Add outcome</button>
                <div class="form-group mb-3">
                    <span for="amount">Enter amount per call</span>
                    <input type="number" name="amount" class="form-control form-control-lg">
                </div>

                <div class="form-group mb-3">
                    <input type="file" id="file" name="file" hidden>
                    <button onclick="document.getElementById('file').click();" type="button" class="btn btn-success btn-lg">Upload excel file with data</button>
                </div>
                
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('script_des');
    CKEDITOR.replace('audio_des');
    CKEDITOR.replace('obj_des');
</script>
<script>
    function addOutcome(){
        $("#outcomes").append(`
            <div>
                <div class="form-group mb-3">
                    <span for="outcome_title">Call outcome title</span>
                    <input type="text" name="outcome_title[]" placeholder="Enter outcome title" required class="form-control form-control-lg">
                </div>
                <div class="form-group mb-3">
                    <span for="outcome_des">Call outcome description</span>
                    <input type="text" name="outcome_des[]" placeholder="Enter outcome description" required class="form-control form-control-lg">
                </div>
                <button class="btn btn-danger mb-4" type="button" onclick="deleteOutcome(this)">Delete this</button>
            </div>
        `)
    }
    function deleteOutcome(obj){
        $($(obj).parent()).remove();
    }
</script>
@endsection