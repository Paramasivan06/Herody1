@extends('layouts.app')

@section('title', 'Manager | All Campaigns')

@section('content')
<!-- Our Dashbord -->
	<section class="cnddte_fvrt our-dashbord dashbord">
		<div class="container">
			<div class="row">
          @include('includes.manager-sidebar')
				<div class="col-sm-12 col-lg-8 col-xl-8">
					<div class="row">
						<div class="col-lg-12">
							<h4 class="mb30">All Gigs</h4>
						</div>
            <div>
                <a href="{{route('manager.gigs.pending')}}" class="btn btn-warning">Pending Gigs</a>
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
                                                <th scope="col">Per job cost</th>
                                                <th scope="col">User</th>
									    		<th scope="col"></th>
									    	</tr>
										</thead>
										<tbody>
                      @foreach($campaigns as $campaign)
                            <?php
                                if($campaign->user_id=="Admin"){
                                    $user = "Admin";
                                }
                                else{
                                    $user = DB::table('employers')->find($campaign->user_id);
                                    $user = $user->name;
                                }
                            ?>
									    	<tr>
									    		<th scope="row">
									    			<a href="{{route('campaign.details',$campaign->id)}}"><h4>{{$campaign->campaign_title}}</h4></a>
									    			<p><span class="flaticon-location-pin"></span>{{$campaign->brand}}</p>
									    			<ul>
									    				<li class="list-inline-item"><a href="#created"><span class="flaticon-event"> Created: </span></a></li>
									    				<li class="list-inline-item"><a class="color-black22" href="#createdat">{{\Carbon\Carbon::parse($campaign->created_at)->format('M d,Y')}}</a></li>
                                                    </ul>
									    		</th>
                                                <td>{{$campaign->per_cost}}</td>
                                                <td>{{$user}}</td>
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
