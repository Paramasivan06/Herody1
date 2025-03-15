@extends('admin.master')

@section('title', 'Admin | Applicant Section')

@section('body')

<div class="container mt-5">
    <h2>Job Applicants</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile Number</th>
                <th>Location</th>
                <th>Qualification</th>
                <th>Job Position</th>
                <th>Resume</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $counter = 1; @endphp
            @foreach ($applicants as $applicant)
                <tr>
                    <td>{{ $counter }}</td>
                    <td>{{ $applicant->name }}</td>
                    <td>{{ $applicant->email }}</td>
                    <td>{{ $applicant->mobile_number }}</td>
                    <td>{{ $applicant->location }}</td>
                    <td>{{ $applicant->highest_qualification }}</td>
                    @php
                        // Get the job position manually based on career_id
                        $jobPosition = \App\Career::find($applicant->career_id); // Find the career/job by career_id
                    @endphp
                    <td>{{ $jobPosition ? $jobPosition->position : 'No Job Applied' }}</td>
                    <td>
                        @if ($applicant->resume_path)
                            <a href="{{ asset('storage/resumes/' . $applicant->resume_path) }}" target="_blank">View Resume</a>
                        @else
                            No Resume Uploaded
                        @endif
                    </td>
                    <td>
                        <!-- Form to update is_called status -->
                        <form action="{{ route('admin.applicants.mark-called', $applicant->id) }}" method="POST">
                            @csrf
                            @method('POST') <!-- You can use POST method for updates -->
                            <button type="submit" class="btn {{ $applicant->is_called ? 'btn-success' : 'btn-danger' }}">
                                {{ $applicant->is_called ? 'Called' : 'Mark as Called' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @php $counter++; @endphp
            @endforeach
        </tbody>
    </table>
</div>

@endsection
