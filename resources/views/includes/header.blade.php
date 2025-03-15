@if(\Request::is('/') or \Request::route()->getName() == "projects" or \Request::route()->getName() == "gigs" or \Request::route()->getName() == "job.details" or \Request::route()->getName() == "campaign.details" or \Request::route()->getName() == "campaigns" or \Request::route()->getName() == "mission.details")
<div class="responsive-header">
    <div class="responsive-menubar">
        <div class="res-logo"></div>
        <div class="menu-resaction float-left">
            <div class="res-openmenu">
                <img src="{{asset('assets/viti2/images/icon.png')}}" alt="" /> Menu
            </div>
            <div class="res-closemenu">
                <img src="{{asset('assets/viti2/images/icon2.png')}}" alt="" /> Close
            </div>
        </div>
    </div>
    <div class="responsive-opensec">
        <div class="responsivemenu">
            <ul>
                <li class="menu-item">
                    @if(Auth::guard('employer')->check())
                        <a href="{{route('employer.dashboard')}}">
                            Home
                        </a>
                    @elseif(Auth::guard('admin')->check())
                        <a href="{{route('admin.dashboard')}}">
                            Admin Dashboard
                        </a>
                    @else
                        <a href="{{url('/')}}">
                            Home
                        </a>
                    @endif
                </li>
                <li class="menu-item">
                    <a href="{{route('projects')}}" title="">Internships</a>
                </li>
                <li class="menu-item">
                    <a href="{{route('gigs')}}" title="">Gigs</a>
                </li>
                <li class="menu-item">
                    <a href="{{route('campaigns')}}" title="">Projects</a>
                </li>
                @if(Auth::guard('employer')->check())
                    <li class="menu-item">
                        <a href="{{route('employer.logout')}}">
                            Logout
                        </a>
                    </li>
                @elseif(Auth::guard('admin')->check())
                    <li class="menu-item">
                        <a href="{{route('admin.logout')}}">
                            Logout
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endif

<header class="stick-top forsticky new-header">
    <div class="menu-sec">
        <div class="container">
            <div class="logo">
                <a href="{{url('/')}}" title="">
                    <img class="hidesticky" src="{{asset('assets/main/images/Viti.png')}}" width="60px" alt="" />
                    <img class="showsticky" src="{{asset('assets/main/images/Viti.png')}}" width="60px" alt="" />
                </a>
            </div><!-- Logo -->
            <div class="btn-extars">
                @if(!Auth::guard('employer')->check() && !Auth::guard('admin')->check())
                    <a href="{{route('employer.login')}}" class="post-job-btn"><i class="fa fa-plus"></i> For Business</a>
                @endif
            </div><!-- Btn Extras -->
            <nav>
                <ul>
                    <li class="menu-item">
                        @if(Auth::guard('employer')->check())
                            <a href="{{route('employer.dashboard')}}">
                                Employer Dashboard
                            </a>
                        @elseif(Auth::guard('admin')->check())
                            <a href="{{route('admin.dashboard')}}">
                                Admin Dashboard
                            </a>
                        @else
                            <a href="{{url('/')}}">
                                Home
                            </a>
                        @endif
                    </li>
                    <li class="menu-item">
                        <a href="{{route('admin.job.all')}}" title="">Internships</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('employer.campaign.manage')}}" title="">Employer Gigs Dashboard</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('admin.missions')}}" title="">Projects</a>
                    </li>
                    @if(Auth::guard('employer')->check())
                        <li class="menu-item">
                            <a href="{{route('employer.logout')}}">
                                Logout
                            </a>
                        </li>
                    @elseif(Auth::guard('admin')->check())
                        <li class="menu-item">
                            <a href="{{route('admin.logout')}}">
                                Logout
                            </a>
                        </li>
                    @endif
                </ul>
            </nav><!-- Menus -->
        </div>
    </div>
</header>
