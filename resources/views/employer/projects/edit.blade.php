@extends('layouts.app')
@section('title',config('app.name').' | Edit Project')

@section('content')
<div class="header pb-6 d-flex align-items-center" style="min-height: 200px; background-size: cover; background-position: center top;">
      <span class="mask bg-gradient-default opacity-8"></span>
</div>
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-12 order-xl-1">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Edit Project</h3>
                </div>
                
              </div>
            </div>
            <div class="card-body">
              <form action="{{route('employer.job.edit',$job->id)}}" method="POST">
                  @csrf
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="title">@lang('Project Title')</label>
                        <input type="text" name="title" class="form-control" value="{{$job->title}}" placeholder="Enter Title">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="des">Description</label>
                        <textarea name="des">{{$job->des}}</textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="start">Start Date</label>
                        <input type="date" name="start" value="{{\Carbon\Carbon::parse($job->start)->format('Y-m-d')}}" class="form-control">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="end">Last date to apply</label>
                        <input type="date" name="end" value="{{\Carbon\Carbon::parse($job->end)->format('Y-m-d')}}" class="form-control">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="duration">Project Duration</label>
                        <input type="text" name="duration" value="{{$job->duration}}" placeholder="Project Duration" class="form-control">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="cat">Category</label>
                        <select name="cat" class="custom-select">
                            <option value="">Select a category</option>
                            @foreach($cats as $cat)
                                <option value="{{$cat}}" @if($job->cat==$cat) selected @endif>{{$cat}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <h2>Student Benefits and Other Requirements</h2>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="stipend">Stipend <small>Eg.1000</small></label>
                        <input type="text" value="{{$job->stipend}}" name="stipend" placeholder="Stipend" class="form-control">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="benefits">Additional Benefits</label>
                        <textarea name="benefits">{{$job->benefits}}</textarea>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="skills">Skills Required and other requirements</label>
                        <textarea name="skills">{{$job->skills}}</textarea>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="place">Work Place</label>
                        <select name="place" class="custom-select">
                            <option value="Work From Home" @if($job->place=="Work From Home") selected @endif>Work From Home</option>
                            <option value="In-Office" @if($job->place=="In-Office") selected @endif>In-Office</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="count">Number of users required</label>
                        <input type="text" class="form-control" name="count" value="{{$job->count}}" placeholder="Number of Interns Required">
                      </div>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">Continue</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
     
    </div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('des');
    CKEDITOR.replace('benefits');
    CKEDITOR.replace('skills');
</script>
@endsection