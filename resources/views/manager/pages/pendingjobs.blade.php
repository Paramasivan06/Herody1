@extends('layouts.app')

@section('title', 'Manager | Pending Internships')

@section('content')
<!-- Our Dashbord -->
	<section class="cnddte_fvrt our-dashbord dashbord">
		<div class="container">
			<div class="row">
          @include('includes.manager-sidebar')
				<div class="col-sm-12 col-lg-8 col-xl-8">
					<div class="row">
						<div class="col-lg-12">
							<h4 class="mb30">Pending Internships</h4>
						</div>
						<div class="col-lg-12"> 
          @if($pending->count()==0)
          <div><h1>No data found</h1></div>
          @else
							<div class="cnddte_fvrt_job candidate_job_reivew style2">
								<div class="table-responsive job_review_table">
									<table class="table">
										<thead class="thead-light">
									    	<tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Category</th>
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
								</div>
							</div>
                  {{$pending->links()}}
                  @endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


    {{--<!-- order Approve Alert Modal -->--}}
    <div class="modal modal-danger fade" id="OrderApprove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash"></i> Approve !</h4>
                </div>
                <form action="{{route('manager.job.approve')}}" method="post">
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
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash"></i> Reject !</h4>
                </div>
                <form action="{{route('manager.job.delete')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input class="form-control form-control-lg mb-3" type="hidden" name="id" id="id">
                        <strong>Are you sure you want to Delete ?</strong>
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
