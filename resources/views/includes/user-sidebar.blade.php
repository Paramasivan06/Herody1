<div class="vertical-nav" id="sidebar" style="margin-top:6em;">
<div class="dashbord_nav_list">
	<ul>
		<li class="{{Request::is('user/dashboard')? 'active':''}}"><a href="{{route('user.dashboard')}}"><span class="flaticon-dashboard"></span> Dashboard</a></li>
		<li class="{{Request::is('user/profile')? 'active':''}}"><a href="{{route('user.profile')}}"><span class="flaticon-profile"></span> Profile</a></li>
		<li class="{{Request::is('user/resume')? 'active':''}}"><a href="{{route('user.resume')}}"><span class="flaticon-resume"></span> Resume</a></li>
		<li class="{{Request::is('user/projects')? 'active':''}}"><a href="{{route('user.projects.show')}}"><span class="flaticon-paper-plane"></span> Applied Internships</a></li>
		<li class="{{Request::is('user/gigs')? 'active':''}}"><a href="{{route('user.gigs.show')}}"><span class="flaticon-paper-plane"></span> Applied Gig</a></li>
		<li class="{{Request::is('user/campaigns')? 'active':''}}"><a href="{{route('user.campaigns.show')}}"><span class="flaticon-paper-plane"></span> Applied Projects</a></li>
		<li class="{{Request::is('user/change-pass')? 'active':''}}"><a href="{{route('user.changePassword')}}"><span class="flaticon-locked"></span> Change Password</a></li>
		<li><a href="{{route('projects')}}"><span class="flaticon-paper-plane"></span> All Internships</a></li>
		<li><a href="{{route('gigs')}}"><span class="flaticon-paper-plane"></span> All Gigs</a></li>
		<li><a href="{{route('campaigns')}}"><span class="flaticon-paper-plane"></span> All Projects</a></li>
		<li><a href="{{route('user.logout')}}"><span class="flaticon-logout"></span> Logout</a></li>
	</ul>
</div>
</div>