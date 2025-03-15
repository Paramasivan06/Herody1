@extends('layouts.app')

@section('title', 'Manager | All Projects')

@section('content')
<section class="cnddte_fvrt our-dashbord dashbord">
    <div class="container">
        <div class="row">
        @include('includes.manager-sidebar')
            <div class="col-sm-12 col-lg-8 col-xl-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                        <div class="card-header bg-white font-weight-bold">
                            All Projects
                            <a href="{{route('manager.pendingjobs')}}" class="btn btn-warning float-right">View Pending Projects</a>
                        </div>
                        <div class="card-body">
                            @if(count($jobs)==0)
                                <h2 class="text-center">@lang('No Data Available')</h2>
                            @else
                                <table class="table  table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Deadline</th>
                                        <th scope="col">Stipned</th>
                                        <th scope="col">Number of candidates Required</th>
                                        <th scope="col">Work Place</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($jobs as $job)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$job->title}}</td>
                                            <td>{{$job->cat}}</td>
                                            <td>{{$job->end}}</td>
                                            <td>{{$job->stipend}}</td>
                                            <td>{{$job->count}}</td>
                                            <td>{{$job->place}}</td>
                                            

                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            @endif
                            {{$jobs->links()}}
                        </div>
                    </div>
                </div>
                    </div>
                </div>
@endsection