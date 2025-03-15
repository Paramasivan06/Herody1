@extends('admin.master')

@section('title', 'Admin | All Projects')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Projects List</h2>
            <a href="{{route('admin.mission.create')}}" class="btn btn-primary mb-2">Create Project</a>

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
                            <th scope="col">Status</th>
                            <th scope="col">Title</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Reward</th>
                            <th scope="col">Publish Date</th>
                            <th scope="col">Edit Form</th>
                            <th scope="col">Applications</th>
                            <th scope="col">Specification</th>
                            <th scope="col">Edit/Delete Project</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($missions as $mission)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td><a href="{{route('admin.mission.projecct_status',$mission->id)}}" class="btn btn-{{$mission->campaignstatus ? 'success' : 'danger'}} btn-sm">
                                    {{$mission->campaignstatus ? 'Active' : 'Inactive'}}
                                </a></td>
                                <th scope="row">{{$mission->title}}</th>
                                <th scope="row">{{$mission->brand}}</th>
                                <th scope="row">{{$mission->reward}}</th>
                                <td>{{ \Carbon\Carbon::parse($mission->created_at)->format('Y-m-d') }}</td>
                                <th scope="row">
                                <?php if($mission->form){ ?>
                                    <form action="{{route('admin.mission.editform')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$mission->form}}">
                                    <button type="submit" class="btn btn-danger btn-sm">Edit form</button>
                                </form>
                                <?php }else{ ?>
                                    <a href="{{route('admin.mission.addform',$mission->id)}}" ><button type="button" class="btn btn-success btn-sm">Edit form</button></a>
                               <?php } ?>
                                    
                                </th>
                                <th scope="row"><a href="{{route('admin.mission.applications',$mission->id)}}" class="btn btn-primary btn-sm">View Applications</a></th>
                                <td>
                                    @if($mission->mobile==0)
                                    <form action="{{route('admin.mission.make-mobile')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$mission->id}}">
                                        <button type="submit" class="btn btn-success btn-sm">Make mobile specific</button>
                                    </form>
                                    @else
                                    <form action="{{route('admin.mission.undo-mobile')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$mission->id}}">
                                        <button type="submit" class="btn btn-danger btn-sm">Undo mobile specific</button>
                                    </form>
                                    @endif
                                </td>
                                <td>
                                <a href="{{route('admin.mission.edit_project',$mission->id)}}" class="btn btn-primary btn-sm customs-btn-bd text-white" style="float:left;margin:0px 5px"> <i class="fa fa-edit"></i></a>
                                </br>
                                    <form action="{{route('admin.mission.delete')}}" method="post">
                                    @csrf
                                        <input type="hidden" name="id" value="{{$mission->id}}">
                                        <button onClick ="return confirm('Are You sure want to delete this?')" type="submit" class="btn btn-danger btn-sm" style="float:left;margin:0px 5px"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @endif
                {{$missions->links()}}
            </div>
        </div>
    </div>

    {{--dropdown active--}}
    <script>
        $('#pending li:nth-child(2)').addClass('active');
        $('#pending').addClass('show');
    </script>
@endsection