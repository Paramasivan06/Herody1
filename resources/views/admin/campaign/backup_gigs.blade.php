@extends('admin.master')

@section('title', 'Admin | All Backup Gigs')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Backup Gigs List</h2>
        
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="liveSearch" placeholder="Search...">
        </div>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Gigs
            </div>
            <div class="card-body">
                <table class="table  table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Gig Id</th>
                        <th scope="col">Campaign Title</th>
                        <th scope="col">Per job cost</th>
                        <th scope="col">User</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Deleted Date</th>
                        <th scope="col">Proofs</th>
                        <th scope="col">Status</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($backups as $backup)
                    <?php
                        if($backup->user_id=="Admin"){
                            $user = "Admin";
                        }
                        else{
                            $user = DB::table('employers')->find($backup->user_id);
                            $user = $user->name;
                        }
                    ?>
                        <tr class="backupRow">
                            <th scope="row">{{$backup->id}}</th>
                            <td>{{$backup->campaign_title}}</td>
                            <td>{{$backup->per_cost}}</td>
                            <td>{{$user}}</td>
                            <td>{{$backup->brand}}</td>
                            <td>{{ \Carbon\Carbon::parse($backup->created_at)->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{route('admin.campaign.backup_accepted_proof',$backup->id)}}" class="btn btn-primary btn-sm mb-2">Download Accepted Proofs</a>
								<a href="{{route('admin.campaign.backup_rejected_proof',$backup->id)}}" class="btn btn-danger btn-sm mb-2">Download Rejected Proofs</a>
                            </td>
                            <td>
                                <form action="{{route("admin.campaign.backupdelete")}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$backup->id}}"/>
                                    <button onClick ="return confirm('Are You sure want to delete the gigs ?')" type="submit" class="btn btn-sm btn-danger" style="float:left;margin:0px 5px"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$backups->links()}}
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#liveSearch').on('keyup', function () {
                var searchText = $(this).val().toLowerCase();
    
                $('.backupRow').hide(); // Hide all rows initially
    
                // Iterate over all table rows, including those on different pages
                $('.backupRow').filter(function () {
                    return $(this).text().toLowerCase().includes(searchText);
                }).show();
            });
        });
    </script>

    {{--dropdown active--}}
    <script>
        $('#backups li:nth-child(3)').addClass('active');
        $('#backups').addClass('show');
    </script>
@endsection
