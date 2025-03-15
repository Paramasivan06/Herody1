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
          @include('includes.manager-sidebar')
				<div class="col-sm-12 col-lg-8 col-xl-8">
					<div class="row">
						<div class="col-lg-12">
							<h4 class="mb30">Pending Gigs</h4>
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
									    		<th scope="col"></th>
									    	</tr>
										</thead>
										<tbody>
                      @foreach($campaigns as $campaign)
									    	<tr>
									    		<th scope="row">
									    			<a href="{{route('campaign.details',$campaign->id)}}"><h4>{{$campaign->campaign_title}}</h4></a>
									    			<p><span class="flaticon-location-pin"></span>{{$campaign->brand}}</p>
									    			<ul>
									    				<li class="list-inline-item"><a href="#created"><span class="flaticon-event"> Created: </span></a></li>
									    				<li class="list-inline-item"><a class="color-black22" href="#createdat">{{\Carbon\Carbon::parse($campaign->created_at)->format('M d,Y')}}</a></li>
                            </ul>
									    		</th>
									    		<td>
                                                    
                                <a href="{{route('manager.campaign.approve',$campaign->id)}}" class="btn btn-success btn-sm">Approve</a>
                                <a href="{{route('manager.campaign.reject',$campaign->id)}}" class="btn btn-danger btn-sm">Reject</a>
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