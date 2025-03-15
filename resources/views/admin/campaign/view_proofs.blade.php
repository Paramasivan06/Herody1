@extends('admin.master')

@section('title', 'Admin | Gig Proof')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Gig Proof</h2>

        <div class="card mb-4">
            <div class="card-body">
            @if($campaigns->count()==0)
            <p>No proof.</p>
            @else
                <table class="table  table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Proof Text</th>
                        <th scope="col">Proof File</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($campaigns as $campaign)
                    <?php 
                       $user = DB::table('users')->find($campaign->user_id);
                    ?>
                    @if($user)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$user->user_name}}</td>
                            <td>
                            {{$campaign->proof_text}}
                            </td>
                            <td>
                            @if($campaign->proof_file==NULL)
                            <p>No proof file</p>
                            @else
                            <a href="{{asset('assets/user/images/proof_file/'.$campaign->proof_file)}}">{{$campaign->proof_file}}</a>
                            @endif
                            </td>
                        </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td colspan="3">
                            <a class="btn btn-success btn-lg" href="{{route('admin.campaign.acceptproof',[$campaign->job_id,$campaign->user_id])}}">Accept</a>
                        </td>
                        <td colspan="3">
                            <a class="btn btn-danger btn-lg" href="{{route('admin.campaign.rejectproof',[$campaign->job_id,$campaign->user_id])}}">Reject</a>
                        </td>
                    </tr>
                    
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>


    {{--dropdown active--}}
    <script>
        $('#Campaigns li:nth-child(3)').addClass('active');
        $('#Campaigns').addClass('show');
    </script>
@endsection
