@extends('layouts.app')
@section('title',config('app.name').' | Manage Projects')
@section('heads')
<style>
.btn-postinter{
    display:block;
    padding: 0.3em;
    background: #E28C12;
    cursor: pointer;
    border: 2px solid #E28C12;
    border-radius: 3px;
    color: white;
    font-weight: bold;
    font-size: 1.1em;
    transition: all ease-out 0.5s;
}
.btn-postinter:hover{
    background: #C27910;
    border: 2px solid #C27910;
    color: #ffffff;
}
</style>
@endsection
@section('content')
<!-- Our Dashbord -->
	<section class="cnddte_fvrt our-dashbord dashbord">
		<div class="container">
			<div class="row">
          @include('includes.emp-sidebar')
				<div class="col-sm-12 col-lg-8 col-xl-9">
					<div class="row">
						<div class="col-lg-12">
							<h4 class="mb30">Manage Projects</h4>
						</div>
						<div class="col-lg-12"> 
          @if($jobs->count()==0)
          <div><h1>No data found</h1></div>
          @else
							<div class="cnddte_fvrt_job candidate_job_reivew style2">
								<div class="table-responsive job_review_table">
									<table class="table">
										<thead class="thead-light">
									    	<tr>
									    		<th scope="col">Project Title</th>
									    		<th scope="col">Applications</th>
									    		<th scope="col"></th>
									    	</tr>
										</thead>
										<tbody>
                      @foreach($jobs as $job)
                      <?php
                          $e = DB::table('employers')->find($job->user);
                          $user = $e->cname;
                      ?>
									    	<tr>
									    		<th scope="row">
									    			<a href="{{route('job.details',$job->id)}}"><h4>{{$job->title}}</h4></a>
									    			<p><span class="fa fa-building"></span> {{$user}}</p>
									    			<ul>
									    				<li class="list-inline-item"><a href="#created"><span class="flaticon-event"> Created: </span></a></li>
									    				<li class="list-inline-item"><a class="color-black22" href="#createdat">{{\Carbon\Carbon::parse($job->created_at)->format('M d,Y')}}</a></li>
									    				<li class="list-inline-item"><a href="#last"><span class="flaticon-event"> Last Date: </span></a></li>
									    				<li class="list-inline-item"><a class="color-black22" href="#end">{{\Carbon\Carbon::parse($job->end)->format('M d,Y')}}</a></li>
                            </ul>
                            
													<a href="{{route('employer.job.shortlisteds',$job->id)}}" class="btn btn-primary btn-sm mb-2">Shortlisted Users</a>
													<a href="{{route('employer.job.selecteds',$job->id)}}" class="btn btn-primary btn-sm mb-2">Selected Users</a>
													<a href="{{route('employer.job.eproof',$job->id)}}" class="btn btn-primary btn-sm mb-2">Download All Proofs</a>
									    		</th>
									    		<td><span class="color-black22">{{$job->applications->count()}}</span> Application(s)</td>
									    		<td>
									    			<ul class="view_edit_delete_list">
									    				<li class="list-inline-item"><a href="{{route('employer.job.applications',$job->id)}}" data-toggle="tooltip" data-placement="bottom" title="View Applications"><span class="flaticon-eye"></span></a></li>
									    				<li class="list-inline-item"><a href="{{route('employer.job.edit',$job->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit"><span class="flaticon-edit"></span></a></li>
									    				<li class="list-inline-item"><a href="#del" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="dele('{{$job->id}}')"><span class="flaticon-rubbish-bin"></span></a></li>
									    			</ul>
									    		</td>
                        </tr>
                        @endforeach
										</tbody>
                  </table>
								</div>
							</div>
                  {{$jobs->links()}}
                  @endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
@section('scripts')
<script>
    function dele(id){
        var a = confirm("Are you sure you want to delete this job permanently?");
        if(a){
            location.href = "{{url('/')}}"+"/employer/project/delete/"+id;
        }
    }
    function delep(id){
        var a = confirm("Are you sure you want to delete this pending job permanently?");
        if(a){
            location.href = "/file/employer/project/deletep/"+id;
        }
    }
</script>
@endsection