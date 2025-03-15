@extends('layouts.app')

@section('title', 'Employer | All Projects')

@section('content')

    <div class="container-fluid" style="margin-top: 150px ">
        <h2 class="mb-4">Projects List</h2>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Projects
            </div>
            <div class="card-body">
                @if(count($missions)==0)
                    <h2 class="text-center">@lang('No Data Available')</h2>
                @else
                    <table class="table  table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Reward</th>
                            <th scope="col">City</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($missions as $mission)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <th scope="row">{{$mission->title}}</th>
                                <th scope="row">{{$mission->brand}}</th>
                                <th scope="row">{{$mission->reward}}</th>
                                <th scope="row">{{$mission->city}}</th>
                                <th scope="row">
                                    <form action="{{route('employer.mission.delete')}}" method="post">
                                    @csrf
                                        <input type="hidden" name="id" value="{{$mission->id}}">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </th>
                                <th scope="row"><a href="{{route('employer.mission.applications',$mission->id)}}" class="btn btn-primary btn-sm">View Applications</a></th>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @endif
                {{$missions->links()}}
            </div>
        </div>
    </div>
@endsection