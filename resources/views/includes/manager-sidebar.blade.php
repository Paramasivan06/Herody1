 
            <?php $ee = Auth::guard('manager')->id(); $user = DB::table('managers')->find($ee); ?>
                <div class="col-sm-12 col-lg-4 col-xl-4 dn-smd">
					<div class="user_profile">
						<div class="media">
						  	<center><img src="@if($user->photo==NULL) {{asset('assets/user/images/frontend/demo.png')}} @else {{asset('assets/manager/profile_images/'.$user->photo)}} @endif" class="align-self-center rounded-circle" style="margin-left:90%">
						  	</center><div class="media-body">
							</div>
						</div>
						
						<h5 class="mt-1" style="margin-left:20%">Hi, {{$user->name}}</h5>
					</div>
					<div class="dashbord_nav_list">
						<ul>
							<li class="{{Request::is('manager/dashboard')? 'active':''}}"><a href="{{route('manager.dashboard')}}"><span class="flaticon-dashboard"></span> Dashboard</a></li>
							<li class="{{Request::is('manager/pending-projects')? 'active':''}}"><a href="{{route('manager.pendingjobs')}}"><span class="flaticon-paper-plane"></span> Pending Internships</a></li>
							<li class="{{Request::is('manager/all-projects')? 'active':''}}"><a href="{{route('manager.jobs.all')}}"><span class="flaticon-paper-plane"></span> All Internships</a></li>
							<li class="{{Request::is('manager/pending-gigs')? 'active':''}}"><a href="{{route('manager.gigs.pending')}}"><span class="flaticon-favorites"></span> Pending Gigs</a></li>
							<li class="{{Request::is('manager/all-gigs')? 'active':''}}"><a href="{{route('manager.gigs.all')}}"><span class="flaticon-chat"></span> All Gigs</a></li>
							<li class="{{Request::is('manager/create-gigs')? 'active':''}}"><a href="{{route('manager.gigs.create')}}"><span class="flaticon-chat"></span> Create Gigs</a></li>
							<li class="{{Request::is('manager/campaigns')? 'active':''}}"><a href="{{route('manager.missions')}}"><span class="flaticon-chat"></span> All Projects</a></li>
							<li class="{{Request::is('manager/create-campaigns')? 'active':''}}"><a href="{{route('manager.mission.create')}}"><span class="flaticon-chat"></span> Create Projects</a></li>
							<li class="{{Request::route('manager.telecallings')? 'active':''}}"><a href="{{route('manager.telecallings')}}"><span class="flaticon-chat"></span> All Telecalling Projects</a></li>
							<li class="{{Request::route('manager.telecalling.create')? 'active':''}}"><a href="{{route('manager.telecalling.create')}}"><span class="flaticon-chat"></span> Create Telecalling Project</a></li>
							<li class="{{Request::is('manager/employers')? 'active':''}}"><a href="{{route('manager.employers')}}"><span class="fa fa-user"></span> Employers</a></li>
							<li><a href="{{route('manager.member.export')}}"><span class="fa fa-user"></span> Export all users</a></li>
							<li><a href="{{route('manager.member.export.referrals')}}"><span class="fa fa-user"></span> Export all referrals</a></li>
							<li><a href="{{route('manager.logout')}}"><span class="flaticon-logout"></span> Logout</a></li>
						</ul>
					</div>
				</div>