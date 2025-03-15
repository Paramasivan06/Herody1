<div class="sidebar sidebar-dark bg-dark">
    <ul class="list-unstyled">
        <li class="active"><a href="{{route('admin.dashboard')}}"><i class="fa fa-home"></i> Dashboard</a></li>

        <li id="activeCampaignCat"><a href="{{route('admin.campaign_category.index')}}"> <i class="fa fa-fw fa-list"> </i> Gig Category</a></li>
        
        <li id="activeCampaignCat"><a href="{{route('admin.banner.index')}}"> <i class="fa fa-building"> </i> Banner</a></li>
        <li>
            <a href="#Campaigns" data-toggle="collapse">
                <i class="fas fa-eye"></i> Gigs
            </a>
            <ul id="Campaigns" class="list-unstyled collapse">

                <li><a href="{{route('admin.campaign.all')}}"><i class="far fa-circle"></i> In-progress Gigs</a></li>
                <li><a href="{{route('admin.campaign.backup')}}"><i class="far fa-circle"></i> Backup Gigs</a></li>
                <li><a href="{{route('admin.campaign.create')}}"><i class="far fa-circle"></i> Create Gigs</a></li>
                <li><a href="{{route('admin.campaign.pendings')}}"><i class="far fa-circle"></i> Pending Gigs</a></li>
                <li><a href="{{route('admin.gig.export')}}"><i class="far fa-circle"></i> Export all to excel</a></li>

            </ul>
        </li>

        <li>
            <a href="#Jobs" data-toggle="collapse">
                <i class="fas fa-briefcase"></i> Internships
            </a>
            <ul id="Jobs" class="list-unstyled collapse">

                <li><a href="{{route('admin.job.pending')}}"><i class="far fa-circle"></i> Pending Internships</a></li>
                <li><a href="{{route('admin.job.all')}}"><i class="far fa-circle"></i> All Internships</a></li>
                <li><a href="{{route('admin.project.export')}}"><i class="far fa-circle"></i> Export all to excel</a></li>

            </ul>
        </li>
          <li>
            <a href="#Bforms" data-toggle="collapse">
                <i class="fas fa-briefcase"></i> Responses
            </a>
            <ul id="Bforms" class="list-unstyled collapse">

                <li><a href="{{route('admin.bforms')}}"><i class="far fa-circle"></i> Business Forms</a></li>
                
            </ul>
        </li>

        <li>
            <a href="#missions" data-toggle="collapse">
                <i class="fas fa-briefcase"></i> Projects
            </a>
            <ul id="missions" class="list-unstyled collapse">

                <li><a href="{{route('admin.missions')}}"><i class="far fa-circle"></i> All Projects</a></li>
                <li><a href="{{route('admin.mission.create')}}"><i class="far fa-circle"></i> Create Project</a></li>
                <li><a href="{{route('admin.campaign.export')}}"><i class="far fa-circle"></i> Export all to excel</a></li>

            </ul>
        </li>

        <li>
            <a href="#telecalling" data-toggle="collapse">
                <i class="fas fa-briefcase"></i> Telecalling Projects
            </a>
            <ul id="telecalling" class="list-unstyled collapse">

                <li><a href="{{route('admin.telecallings')}}"><i class="far fa-circle"></i> All Telecalling Projects</a></li>
                <li><a href="{{route('admin.telecalling.create')}}"><i class="far fa-circle"></i> Create Telecalling Project</a></li>

            </ul>
        </li>
        <li>
            <a href="#jobs" data-toggle="collapse" aria-expanded="false" aria-controls="jobs">
                <i class="fas fa-briefcase"></i> Jobs
            </a>
            <ul id="jobs" class="list-unstyled collapse">
                <li><a href="{{ route('admin.jobs.create') }}"><i class="far fa-circle"></i> Upload Job</a></li>
                <li><a href="{{ route('admin.jobs.index') }}"><i class="far fa-circle"></i> Job Listings</a></li>
                <li><a href="{{ route('admin.applicants.index') }}"><i class="far fa-circle"></i> View Applicants</a></li>
            </ul>
        </li>
        
        <li id="managers"><a href="{{route('admin.managers')}}"><i class="far fa-user"></i> Managers</a></li>
        <li id="employers"><a href="{{route('admin.employers')}}"><i class="fa fa-building"></i> Employers</a></li>

        <li>
            <a href="#Withdraw" data-toggle="collapse">
                <i class="fa fa-fw fa-arrow-down"></i> Withdraw System
            </a>
            <ul id="Withdraw" class="list-unstyled collapse">

                <li><a href="{{route('admin.withdraw.index')}}"><i class="far fa-circle"></i> Withdraw Methods</a></li>
                <li><a href="{{route('admin.show.withdraw.request')}}"><i class="far fa-circle"></i> Withdraw Requests</a></li>
                <li><a href="{{route('admin.show.withdraw.log')}}"><i class="far fa-circle"></i> Withdraw Logs</a></li>
                <li><a href="{{route('admin.withdraw.export')}}"><i class="far fa-circle"></i> Export all to excel</a></li>

            </ul>
        </li>

        <li>
            <a href="#memberSetting" data-toggle="collapse">
                <i class="fa fa-fw fa-users"></i> Member Settings
            </a>
            <ul id="memberSetting" class="list-unstyled collapse">

                <li><a href="{{route('admin.member.all')}}"><i class="far fa-circle"></i> All Member</a></li>

            </ul>
        </li>

    </ul>

</div>

