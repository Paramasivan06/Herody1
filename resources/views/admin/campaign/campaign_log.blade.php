@extends('admin.master')

@section('title', 'Admin | Gigs log')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Gigs Log</h2>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Gigs
            </div>
            <div class="card-body">
                <table class="table  table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Per job cost</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($campaigns as $campaign)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$campaign->campaign_title}}</td>
                            <td>{{$campaign->per_cost}}</td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {{$campaigns->links()}}
            </div>
        </div>
    </div>


    {{--dropdown active--}}
    <script>
        $('#Campaigns li:nth-child(4)').addClass('active');
        $('#Campaigns').addClass('show');
    </script>
@endsection
