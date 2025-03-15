<?php
    $cities = DB::table('cities')->where('country_id','101')->orderBy('name','asc')->get();
?>
@extends('admin.master')

@section('title', 'Admin | Create Project')
@section('heads')
<style>
.cdiv{
    width:100%;
    height:10rem;
    background-color: white;
    overflow:auto;
}
.select-wrapper {
  margin: auto;
  max-width: 600px;
  width: calc(100% - 40px);
}

.select-pure__select {
  align-items: center;
  background: #f9f9f8;
  border-radius: 4px;
  border: 1px solid rgba(0, 0, 0, 0.15);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
  box-sizing: border-box;
  color: #363b3e;
  cursor: pointer;
  display: flex;
  font-size: 16px;
  font-weight: 500;
  justify-content: left;
  min-height: 44px;
  padding: 5px 10px;
  position: relative;
  transition: 0.2s;
  width: 100%;
}

.select-pure__options {
  border-radius: 4px;
  border: 1px solid rgba(0, 0, 0, 0.15);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
  box-sizing: border-box;
  color: #363b3e;
  display: none;
  left: 0;
  max-height: 221px;
  overflow-y: scroll;
  position: absolute;
  top: 50px;
  width: 100%;
  z-index: 5;
}

.select-pure__select--opened .select-pure__options {
  display: block;
}

.select-pure__option {
  background: #fff;
  border-bottom: 1px solid #e4e4e4;
  box-sizing: border-box;
  height: 44px;
  line-height: 25px;
  padding: 10px;
}

.select-pure__option--selected {
  color: #e4e4e4;
  cursor: initial;
  pointer-events: none;
}

.select-pure__option--hidden {
  display: none;
}

.select-pure__selected-label {
  background: #5e6264;
  border-radius: 4px;
  color: #fff;
  cursor: initial;
  display: inline-block;
  margin: 5px 10px 5px 0;
  padding: 3px 7px;
}

.select-pure__selected-label:last-of-type {
  margin-right: 0;
}

.select-pure__selected-label i {
  cursor: pointer;
  display: inline-block;
  margin-left: 7px;
}

.select-pure__selected-label i:hover {
  color: #e4e4e4;
}

.select-pure__autocomplete {
  background: #f9f9f8;
  border-bottom: 1px solid #e4e4e4;
  border-left: none;
  border-right: none;
  border-top: none;
  box-sizing: border-box;
  font-size: 16px;
  outline: none;
  padding: 10px;
  width: 100%;
}
</style>
@endsection
@section('body')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <h4 class="text-center">Create a Project</h4>
            <form action="{{route('admin.mission.create')}}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="form-group mb-3">
                    <label for="title">Enter campaign title</label>
                    <input type="text" class="form-control form-control-lg" name="title" placeholder="Enter campaign title" >
                </div>
                <div class="form-group mb-3">
                    <label for="des">Enter campaign description</label>
                    <textarea name="des" id="des" style="display:none"></textarea>
                    <div contenteditable="true" onkeyup="document.getElementById('des').value=this.innerHTML" class="cdiv border rounded"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="brand">Enter brand name</label>
                    <input type="text" class="form-control form-control-lg" name="brand" placeholder="Enter brand name" >
                </div>
                <div class="form-group mb-3">
                    <label for="brand">Upload brand logo</label>
                        <input type="file"  name="logo"  accept=".png,.jpg,.bmp,.gif" class="form-control">
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
                    <label for="city">Cities</label>
                    <span class="cities"></span>
                    <input type="text" name="city" id="cities" hidden>
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
@section('scripts')
<script src="{{asset('assets/mselect/dist/bundle.min.js')}}"></script>
<script>
    const myOptions = [
        @foreach($cities as $city)
        {
            label: "{{$city->name}}",
            value: "{{$city->name}}",
        },
        @endforeach
        {
            label: "All India",
            value: "All India",
        }
    ];
    var instance = new SelectPure(".cities", {
        options: myOptions,
        autocomplete: true,
        multiple: true,
        onChange: value => { $('#cities').val(value); },
        icon: "fa fa-times",
        placeholder: "Click here to add cities",
        inlineIcon: false,
        classNames: {
            select: "select-pure__select",
            dropdownShown: "select-pure__select--opened",
            multiselect: "select-pure__select--multiple",
            label: "select-pure__label",
            placeholder: "select-pure__placeholder",
            dropdown: "select-pure__options",
            option: "select-pure__option",
            autocompleteInput: "select-pure__autocomplete",
            selectedLabel: "select-pure__selected-label",
            selectedOption: "select-pure__option--selected",
            placeholderHidden: "select-pure__placeholder--hidden",
            optionHidden: "select-pure__option--hidden",
        }
    });
</script>
@endsection