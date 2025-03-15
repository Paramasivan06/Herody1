@extends('layouts.app')

@section('title', 'Manager | Telecalling Application')

@section('content')

    <div class="container-fluid">
        <h2 class="mb-4">Telecalling Application</h2>

        <div class="card mb-4">
            <div class="card-body">
                <table class="table  table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($applications as $application)
                    <?php 
                       $user = \App\User::find($application->uid);
                    ?>
                    @if($user)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$user->user_name}}</td>
                            <td>
                            @if ($application->status==0)
                                <span class="badge  badge-pill  badge-info">@lang('Applied')</span>
                            @elseif($application->status==1)
                                <span class="badge  badge-pill  badge-success">@lang('Application Approved')</span>
                            @elseif($application->status==2)
                                <span class="badge  badge-pill  badge-danger">@lang('Application Rejected')</span>
                            @elseif($application->status==3)
                                <span class="badge  badge-pill  badge-info">@lang('Data Distributed')</span>
                            @elseif($application->status==4)
                            <span class="badge  badge-pill  badge-success">@lang('Feedback Submitted')</span>
                            @elseif($application->status==5)
                                <span class="badge  badge-pill  badge-danger">@lang('Proof Rejected')</span>
                            @endif
                            </td>
                            <td>
                                @if($application->status===4)
                                <a href="{{route("manager.telecalling.feedback",$application->id)}}">View Feedback</a>
                                @endif
                            </td>
                            <td>
                            @if ($application->status==0)
                                <form action="{{route("manager.telecalling.select")}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="uid" value="{{$application->uid}}">
                                    <input type="hidden" name="tid" value="{{$application->tid}}">
                                    <button class="btn btn-success btn-sm" style="float:left">Select</button>
                                </form>
                                <form action="{{route("manager.telecalling.reject")}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="uid" value="{{$application->uid}}">
                                    <input type="hidden" name="tid" value="{{$application->tid}}">
                                    <button class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            @elseif($application->status==3 or $application->status==4)
                                <a href="{{route('manager.telecalling.viewdata',[$application->tid,$application->uid])}}" class="btn-link">View Distributed Data</a>
                            @endif
                            </td>

                        </tr>
                    @endif
                    @endforeach

                    </tbody>
                </table>
                {{$applications->links()}}
            </div>
        </div>
    </div>
@endsection
