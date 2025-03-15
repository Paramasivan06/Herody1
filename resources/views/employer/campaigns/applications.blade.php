@extends('layouts.app')

@section('title', 'Employer | Project Application')

@section('content')

    <div class="container-fluid" style="margin-top: 160px">
        <h2 class="mb-4">Project Application</h2>

        <div class="input-group mb-3">
            <input type="text" class="form-control" id="liveSearch" placeholder="Search...">
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <table class="table  table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($campaigns as $campaign)
                    <?php 
                       $user = DB::table('users')->find($campaign->uid);
                    ?>
                    @if($user)
                        <tr class="campaignRow">
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                            @if ($campaign->status==0)
                                <span class="badge  badge-pill  badge-info">@lang('Applied')</span>
                            @elseif($campaign->status==1)
                                <span class="badge  badge-pill  badge-success">@lang('Application Approved')</span>
                            @elseif($campaign->status==2)
                                <span class="badge  badge-pill  badge-danger">@lang('Application Rejected')</span>
                            @elseif($campaign->status==3)
                                <span class="badge  badge-pill  badge-info">@lang('Proof Submitted')</span>
                            @elseif($campaign->status==4)
                                <span class="badge  badge-pill  badge-success">@lang('Proof Accepted, Paid')</span>
                            @elseif($campaign->status==5)
                                <span class="badge  badge-pill  badge-danger">@lang('Proof Rejected')</span>
                            @endif
                            </td>
                            <td>
                            @if ($campaign->status==0)
                                <a href="{{route('employer.mission.accept',$campaign->id)}}" class="btn btn-success btn-sm">Approve</a>
                                <a href="{{route('employer.mission.reject',$campaign->id)}}" class="btn btn-danger btn-sm">Reject</a>
                            @elseif($campaign->status==3)
                                <a href="{{route('employer.mission.response',$campaign->id)}}" class="btn-link">View Response(s)</a>
                            @endif
                            </td>

                        </tr>
                    @endif
                    @endforeach

                    </tbody>
                </table>
                {{-- {{$campaigns->links()}} --}}
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#liveSearch').on('keyup', function () {
                var searchText = $(this).val().toLowerCase();
    
                $('.campaignRow').hide(); // Hide all rows initially
    
                // Iterate over all table rows, including those on different pages
                $('.campaignRow').filter(function () {
                    return $(this).text().toLowerCase().includes(searchText);
                }).show();
            });
        });
    </script>
    
@endsection
