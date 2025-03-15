@extends('admin.master')

@section('title', 'Admin | Edit Job')

@section('body')
<div class="container mt-4">
    <h2 class="text-center">Edit Job</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="position">Position</label>
            <input type="text" class="form-control" name="position" value="{{ $job->position }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="location">Location</label>
            <input type="text" class="form-control" name="location" value="{{ $job->location }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="pay">Pay</label>
            <input type="number" class="form-control" name="pay" value="{{ $job->pay }}" step="0.01" required>
        </div>

        <div class="form-group mb-3">
            <label for="job_type">Job Type</label>
            <input type="text" class="form-control" name="job_type" value="{{ $job->job_type }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="shift">Shift</label>
            <input type="text" class="form-control" name="shift" value="{{ $job->shift }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="responsibilities">Responsibilities</label>
            <textarea class="form-control" name="responsibilities" rows="5" required>{{ $job->responsibilities }}</textarea>
        </div>

        <!--<div class="form-group mb-3">-->
        <!--    <label for="requirements">Requirements</label>-->
        <!--    <textarea class="form-control" name="requirements" rows="5" required>{{ $job->requirements }}</textarea>-->
        <!--</div>-->

        <button type="submit" class="btn btn-primary">Update Job</button>
    </form>
</div>
@endsection
