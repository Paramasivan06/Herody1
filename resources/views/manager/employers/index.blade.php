@extends('layouts.app')

@section('title', 'Manager | All Employers')

@section('content')
<section class="cnddte_fvrt our-dashbord dashbord">
    <div class="container">
        <div class="row">
        @include('includes.manager-sidebar')
            <div class="col-sm-12 col-lg-8 col-xl-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                        <div class="card-body">
                            @if(count($employers)==0)
                                <h2 class="text-center">@lang('No Data Available')</h2>
                            @else
                                <table class="table  table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Company name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($employers as $employer)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$employer->name}}</td>
                                            <td>{{$employer->cname}}</td>
                                            <td>{{$employer->email}}</td>
                                            
                                            <th scope="row">
                                                <form action="{{route('manager.employer.login')}}" method="post">
                                                @csrf
                                                    <input type="hidden" name="id" value="{{$employer->id}}">
                                                    <button type="submit" class="btn btn-danger btn-sm">Login</button>
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
                    </div>
                </div>
@endsection