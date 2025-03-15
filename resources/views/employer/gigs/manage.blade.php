@extends('layouts.app')
@section('title',config('app.name').' | Manage Gigs')
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
							<h4 class="mb30">Manage Gigs</h4>
						</div>
						<div class="col-lg-12"> 
          @if($campaigns->count()==0)
          <div><h1>No data found</h1></div>
          @else
							<div class="cnddte_fvrt_job candidate_job_reivew style2">
								<div class="table-responsive job_review_table">
									<table class="table">
										<thead class="thead-light">
									    	<tr>
									    		<th scope="col">Gig Title</th>
									    		<th scope="col">Applications</th>
									    		<th scope="col">Timing</th> <!-- Add this -->
									    		<th scope="col">Earners</th> <!-- Earners column -->
									    		<th scope="col"></th>
									    	</tr>
										</thead>
										<tbody>
                      @foreach($campaigns as $campaign)
                      <?php
                          $e = DB::table('employers')->find($campaign->user_id);
                          $user = $e->cname;
                      ?>
									    	<tr>
									    		<th scope="row">
									    			<a href="{{route('campaign.details',$campaign->id)}}"><h4>{{$campaign->campaign_title}}</h4></a>
									    			<p><span class="flaticon-location-pin"></span>{{$user}}</p>
									    			<ul>
									    				<li class="list-inline-item"><a href="#created"><span class="flaticon-event"> Created: </span></a></li>
									    				<li class="list-inline-item"><a class="color-black22" href="#createdat">{{\Carbon\Carbon::parse($campaign->created_at)->format('M d,Y')}}</a></li>
                                                    </ul>
                                                    @if($campaign->gigstatus==0)
									    				 <p><span class="flaticon fa-solid fa-eye"></span>  Status : - Inactive</p>
									    			@else
									    				 <p><span class="flaticon fa-solid fa-eye"></span>  Status : - Active</p>
									    			@endif
													<a href="{{route('employer.campaign.eproof',$campaign->id)}}" class="btn btn-primary btn-sm mb-2">Download Accepted Proofs</a>
												<a href="{{route('employer.campaign.rejectedproof',$campaign->id)}}" class="btn btn-primary btn-sm mb-2">Download Rejected Proofs</a>
									    		</th>
									    	        <td><span class="color-black22">{{ $campaign->total_applicants }}</span> Application(s)</td>							
                                                    <td>{{ $campaign->timing ?? 'N/A' }}</td> <!-- Show timing -->
                                                    <td>{{ $campaign->approved_applicants }} Earners</td>
									    		<td>
									    			<ul class="view_edit_delete_list">
									    				<li class="list-inline-item"><a href="{{route('employer.gig.applications',$campaign->id)}}" data-toggle="tooltip" data-placement="bottom" title="View Applications" class="btn btn-sm"><span class="flaticon-eye"></span></a></li>
									    				<li class="list-inline-item"><a href="{{route('employer.gig.edit',$campaign->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit Gig" class="btn btn-sm"><span class="flaticon-edit"></span></a></li>
									    				<li>
														<form action="{{route('employer.gig.delete')}}" method="post">
															@csrf
															<input type="hidden" name="id" value="{{$campaign->id}}">
														<button data-toggle="tooltip" data-placement="bottom" class="btn btn-danger btn-sm" title="Delete" type="submit" onclick="return confirm('Are you sure want to delete this');"><span class="flaticon-rubbish-bin"></span></button>
														</form>
                              							</li>
									    			</ul>
									    		</td>
                        </tr>
                        @endforeach
										</tbody>
                  </table>
								</div>
							</div>
                  {{$campaigns->links()}}
                  @endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection