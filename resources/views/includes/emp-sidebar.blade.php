 
            <?php $ee = Auth::guard('employer')->id(); $user = DB::table('employers')->find($ee); ?>
                <div class="col-sm-12 col-lg-4 col-xl-3 dn-smd">
					<div class="user_profile">
						<div class="media">
						  	<center><img src="{{asset('assets/employer/profile_images/'.$user->profile_photo)}}" class="align-self-center rounded" style="margin-left:90%">
						  	</center><div class="media-body">
							</div>
						</div>
						
						<h5 class="mt-1" style="margin-left:20%">Hi, {{$user->name}}</h5>
					</div>
					<div class="dashbord_nav_list">
						<ul>
							<li class="{{Request::is('employer/dashboard')? 'active':''}}"><a href="{{route('employer.dashboard')}}"><span class="flaticon-dashboard"></span> Dashboard</a></li>
							<li class="{{Request::is('employer/profile')? 'active':''}}"><a href="{{route('employer.profile')}}"><span class="flaticon-profile"></span> Company Profile</a></li>
							<li class="{{Request::is('employer/projects/post')? 'active':''}}"><a href="{{route('employer.job.post')}}"><span class="flaticon-resume"></span> Post a New Internship</a></li>
							<li class="{{Request::is('employer/projects')? 'active':''}}"><a href="{{route('employer.job.manage')}}"><span class="flaticon-paper-plane"></span> Manage Internships</a></li>
							<li class="{{Request::is('employer/gigs/post')? 'active':''}}"><a href="{{route('employer.campaign.create')}}"><span class="flaticon-favorites"></span> Post a New Gig</a></li>
							<li class="{{Request::is('employer/gigs')? 'active':''}}"><a href="{{route('employer.campaign.manage')}}"><span class="flaticon-chat"></span> Manage Gigs</a></li>
							<li class="{{Request::is('employer/campaigns')? 'active':''}}"><a href="{{route('employer.missions')}}"><span class="flaticon-chat"></span> Manage Campaigns</a></li>
							<li class="{{Request::is('employer/change-pass')? 'active':''}}"><a href="{{route('employer.changepass')}}"><span class="flaticon-locked"></span> Change Password</a></li>
							<li><a href="{{route('projects')}}"><span class="flaticon-paper-plane"></span> All Internships</a></li>
							<li><a href="{{route('gigs')}}"><span class="flaticon-paper-plane"></span> All Gigs</a></li>
							<li><a href="{{route('campaigns')}}"><span class="flaticon-paper-plane"></span> All Projects</a></li>
							<li><a href="{{route('employer.logout')}}"><span class="flaticon-logout"></span> Logout</a></li>
						</ul>
					</div>
				</div>