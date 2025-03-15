@extends('admin.master')

@section('title', 'Admin | Gig Application')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Gig Application</h2>

        <div class="card mb-4">
            <div class="card-body">
                <table class="table  table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">User Name</th>
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
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$user->user_name}}</td>
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
                                <a href="{{route('admin.campaign.approve',[$campaign->cid,$campaign->uid])}}" class="btn btn-success btn-sm">Approve</a>
                                <a href="{{route('admin.campaign.reject',[$campaign->cid,$campaign->uid])}}" class="btn btn-danger btn-sm">Reject</a>
                            @elseif($campaign->status==3)
                                <a href="{{route('admin.campaign.viewproof',[$campaign->cid,$campaign->uid])}}" class="btn-link">View Proof(s)</a>
                            @endif
                            </td>

                        </tr>
                    @endif
                    @endforeach

                    </tbody>
                </table>
                <?php if(count($campaigns) > 0){ ?>
                <a href="{{route('admin.gig.apps.export',$campaigns[0]->id)}}" class="btn btn-primary">Export All applications</a>
                <?php } ?>
                {{$campaigns->links()}}
            </div>
        </div>
    </div>


    {{--dropdown active--}}
    <script>
        $('#Campaigns li:nth-child(3)').addClass('active');
        $('#Campaigns').addClass('show');
    </script>
@endsection
