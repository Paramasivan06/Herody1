<?php
    $cities = DB::table('cities')->where('country_id','101')->orderBy('name','asc')->get();
?>
@extends('layouts.app')

@section('title', 'Manager | Create Project')
@section('heads')
<style>
.cdiv{
    width:100%;
    height:10rem;
    background-color: white;
    overflow:auto;
}
</style>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <h4 class="text-center">Create a Project</h4>
            <form action="{{route('manager.mission.create')}}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="form-group mb-3">
                    <label for="title">Enter project title</label>
                    <input type="text" class="form-control form-control-lg" name="title" placeholder="Enter project title" >
                </div>
                <div class="form-group mb-3">
                    <label for="des">Enter project description</label>
                    <textarea name="des" id="des" style="display:none"></textarea>
                    <div contenteditable="true" onkeyup="document.getElementById('des').value=this.innerHTML" class="cdiv border rounded"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="brand">Enter brand name</label>
                    <input type="text" class="form-control form-control-lg" name="brand" placeholder="Enter brand name" >
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon01">Upload Brand Logo</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="logo" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" accept=".png,.jpg,.bmp,.gif">
                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="start">Start Date</label>
                    <input type="date" class="form-control form-control-lg" name="start">
                </div>
                <div class="form-group mb-3">
                    <label for="before">Apply Before</label>
                    <input type="date" class="form-control form-control-lg" name="before">
                </div>
                <div class="form-group mb-3">
                    <label for="end">End Date</label>
                    <input type="date" class="form-control form-control-lg" name="end">
                </div>
                <div class="form-group mb-3">
                    <label for="ucount">Number of users allowed</label>
                    <input type="number" class="form-control form-control-lg" name="ucount">
                </div>
                <div class="form-group mb-3">
                    <label for="city">City</label>
                    <select name="city[]" class="custom-select" multiple>
                        <option value="">Select a city</option>
                        @foreach($cities as $city)
                        <option value="{{$city->name}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="reward">Rewards</label>
                    <input type="text" class="form-control form-control-lg" name="reward" placeholder="Rewards" >
                </div>
                <div class="form-group mb-3">
                    <label for="benefits">Benefits</label>
                    <textarea name="benefits" id="benefits" style="display:none"></textarea>
                    <div contenteditable="true" onkeyup="document.getElementById('benefits').value=this.innerHTML" class="cdiv border rounded"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="requirements">Requirements</label>
                    <textarea name="requirements" id="requirements" style="display:none"></textarea>
                    <div contenteditable="true" onkeyup="document.getElementById('requirements').value=this.innerHTML" class="cdiv border rounded"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="imp_terms">Important Terms</label>
                    <textarea name="imp_terms" id="imp_terms" style="display:none"></textarea>
                    <div contenteditable="true" onkeyup="document.getElementById('imp_terms').value=this.innerHTML" class="cdiv border rounded"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="terms">All Terms</label>
                    <textarea name="terms" id="terms" style="display:none"></textarea>
                    <div contenteditable="true" onkeyup="document.getElementById('terms').value=this.innerHTML" class="cdiv border rounded"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="dondont">Do's & Don'ts</label>
                    <textarea name="dondont" id="dondont" style="display:none"></textarea>
                    <div contenteditable="true" onkeyup="document.getElementById('dondont').value=this.innerHTML" class="cdiv border rounded"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="instructions">Instructions</label>
                    <textarea name="instructions" id="instructions" style="display:none"></textarea>
                    <div contenteditable="true" onkeyup="document.getElementById('instructions').value=this.innerHTML" class="cdiv border rounded"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="methods">Task Submission Methods</label>
                    <textarea name="methods" id="methods" style="display:none"></textarea>
                    <div contenteditable="true" onkeyup="document.getElementById('methods').value=this.innerHTML" class="cdiv border rounded"></div>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>
@endsection