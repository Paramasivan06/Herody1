@extends('layouts.app')

@section('title', 'Manager | Telecalling Feedback')

@section('content')

    <div class="container-fluid">
        <h2 class="mb-4">Telecalling Feedback</h2>

        <div class="card mb-4">
            <div class="card-body">
                <table class="table  table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Caller Name</th>
                        <th scope="col">Caller Phone</th>
                        <th scope="col">Call Status</th>
                        <th scope="col">Minutes Spoken</th>
                        <th scope="col">Session Time</th>
                        <th scope="col">Feedback</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($feedbacks as $feedback)
                    <?php 
                       $user = \App\User::find($application->uid);
                    ?>
                    @if($user)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$user->user_name}}</td>
                            <td>{{$feedback->caller_name}}</td>
                            <td>{{$feedback->caller_phone}}</td>
                            <td>{{$feedback->call_status}}</td>
                            <td>{{$feedback->minutes ?? "NA"}}</td>
                            <td>{{$feedback->session_time ?? "NA"}}</td>
                            <td>{{$feedback->feedback ?? "NA"}}</td>
                        </tr>
                    @endif
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
