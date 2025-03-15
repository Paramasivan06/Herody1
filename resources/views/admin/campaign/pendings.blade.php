@extends('admin.master')

@section('title', 'Admin | Pending Gigs')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Pending Gigs List</h2>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Pending Gigs
            </div>
            <div class="card-body">
                <table class="table  table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Per job cost</th>
                        <th scope="col">User</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($campaigns as $campaign)
                    <?php
                        $user = DB::table('employers')->find($campaign->user_id)
                    ?>
                    @if($user)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$campaign->campaign_title}}</td>
                            <td>{{$campaign->per_cost}}</td>
                            <td>{{$user->name}}</td>
                            <td>
                                <a href="{{route('admin.campaignp.approve',$campaign->id)}}" class="btn btn-success btn-sm">Approve</a>
                                <a href="{{route('admin.campaignp.reject',$campaign->id)}}" class="btn btn-danger btn-sm">Reject</a>
                            </td>
                        </tr>
                    @endif
                    @endforeach

                    </tbody>
                </table>
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
