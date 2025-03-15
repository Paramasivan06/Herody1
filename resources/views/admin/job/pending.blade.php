@extends('admin.master')

@section('title', 'Admin | Pending Internships')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Pending List</h2>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Pending Internships
            </div>
            <div class="card-body">
                @if(count($pending)==0)
                    <h2 class="text-center">@lang('No Data Available')</h2>
                @else
                    <table class="table  table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Category</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Stipend</th>
                            <th scope="col">Number of candidates Required</th>
                            <th scope="col">Work Place</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($pending as $pen)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$pen->title}}</td>
                                <td>{{$pen->cat}}</td>
                                <td>{{$pen->end}}</td>
                                <td>{{$pen->stipend}}</td>
                                <td>{{$pen->count}}</td>
                                <td>{{$pen->place}}</td>
                                <td>

                                    <a href="" class="btn btn-danger btn-sm btn-square" data-id="{{$pen->id}}"
                                       data-toggle="modal" data-target="#OrderReject">Reject</a>

                                    <a href="" class="btn btn-info btn-sm btn-square" data-id="{{$pen->id}}"
                                       data-toggle="modal"
                                       data-target="#OrderApprove">Approve</a>
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @endif
                {{$pending->links()}}
            </div>
        </div>
    </div>


    {{--<!-- order Approve Alert Modal -->--}}
    <div class="modal modal-danger fade" id="OrderApprove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-check"></i> Approve !</h4>
                </div>
                <form action="{{route('admin.job.approve')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input class="form-control form-control-lg mb-3" type="hidden" name="id" id="id">
                        <strong>Are you sure you want to Approve ?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--<!-- order reject Alert Modal -->--}}
    <div class="modal modal-danger fade" id="OrderReject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"> Reject !</h4>
                </div>
                <form action="{{route('admin.job.delete')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input class="form-control form-control-lg mb-3" type="hidden" name="id" id="id">
                        <strong>Are you sure you want to Reject ??</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--dropdown active--}}
    <script>
        $('#pending li:nth-child(2)').addClass('active');
        $('#pending').addClass('show');
    </script>
@endsection


@section('scripts')

    {{--Approve script--}}
    <script>
        $('#OrderReject').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        })
    </script>

    {{--Reject script--}}
    <script>
        $('#OrderApprove').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        })
    </script>

@endsection
