@extends('admin.master')

@section('title', 'Admin | All Employers')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Employers List</h2>
        
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="liveSearch" placeholder="Search...">
        </div>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Employers
                <div class="float-right">
                    <a class="btn btn-primary" href="{{route('admin.employer.create')}}">Create Employer</a>
                </div>
            </div>
            
            <div class="card-body">
                @if(count($employers)==0)
                    <h2 class="text-center">@lang('No Data Available')</h2>
                @else
               {{$employers->links()}}
                    <table class="table  table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Email</th>
                            <th scope="col"></th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($employers as $employer)
                            <tr class="campaignRow">
                                <th scope="row">{{$loop->iteration}}</th>
                                <th scope="row">{{$employer->name}}</th>
                                <th scope="row">{{$employer->cname}}</th>
                                <th scope="row">{{$employer->email}}</th>
                                <th scope="row">
                                    <form action="{{route('admin.employer.login')}}" method="post">
                                    @csrf
                                        <input type="hidden" name="id" value="{{$employer->id}}">
                                        <button type="submit" class="btn btn-danger btn-sm">Login</button>
                                    </form>
                                </th>
                                <th>
                                <form action="{{route("admin.employer.delete")}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$employer->id}}"/>
                                    <button onClick ="return confirm('Are You sure want to delete this?')" type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                                </th>
                                
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @endif
                {{$employers->links()}}
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
    
    
    {{--dropdown active--}}
    <script>
        $('#employers').addClass('active');
    </script>
@endsection