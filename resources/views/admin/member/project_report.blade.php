@extends('admin.master')

@section('title', 'Admin | Projects log')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Projects Log</h2>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Projects
            </div>
            <div class="card-body">
                @if(count($aprojects)==0)
                    <h2 class="text-center">@lang('No Data Available')</h2>
                @else
                    <table class="table  table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Stipend</th>
                            <th scope="col">Applied at</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($aprojects as $aproject)
                        <?php $project = \App\Project::find($aproject->jid); 
                              $user = \App\Employer::find($project->user);
                        ?>
                            <tr>
                                <td>{{$project->title}}</td>
                                <td>{{$user->cname}}</td>
                                <td>{{$project->stipend}}</td>
                                <td>{{ \Carbon\Carbon::parse($aproject->created_at)->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @endif
                {{$aprojects->links()}}
            </div>
        </div>
    </div>


    {{--dropdown active--}}
    <script>
        $('#memberSetting li:nth-child(1)').addClass('active');
        $('#memberSetting').addClass('show');
    </script>
@endsection
