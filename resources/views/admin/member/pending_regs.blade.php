@extends('admin.master')

@section('title', 'Admin | Pending Registration')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Pending Registration</h2>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                members
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">User_name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($users as $user)
                        <tr>
                            <th scope="row">{{$user->id}}</th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->user_name}}</td>
                            <td>
                                <span class="badge  badge-pill  badge-danger">Pending</span>
                            </td>
                            <td>
                                <a href="{{route('admin.member.approve',$user->id)}}" class="btn btn-success btn-sm">Approve</a>
                                <a href="{{route('admin.member.reject',$user->id)}}" class="btn btn-danger btn-sm">Reject</a>
                            </td>
                        </tr>
                    @endforeach


                    </tbody>
                </table>
                {{$users->links()}}

            </div>
        </div>
    </div>

    {{--dropdown active--}}
    <script>
        $('#memberSetting li:nth-child(1)').addClass('active');
        $('#memberSetting').addClass('show');
    </script>
@endsection

