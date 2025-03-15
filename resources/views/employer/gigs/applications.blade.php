@extends('layouts.app')

@section('title', config('app.name').' | Gig Application')

@section('content')
    
    @foreach($campaigns as $campaign)
        <?php 
            $user = DB::table('users')->find($campaign->uid);
        ?>
        @endforeach
        <div class="col-md-12">
        	<form action="{{route('employer.campaign.approveall')}}" method="post" class="mr-2 approve-all-form">
        	@csrf
        	    <input type="hidden" name="id" value="{{$campaign->cid,$campaign->uid}}">
        		<button type="submit" class="btn btn-success">Approve all</button>
        	</form>
        	
        	<form action="{{route('employer.campaign.rejectall')}}" method="post" class="mr-2 unapprove-all-form">
        	@csrf
        	    <input type="hidden" name="id" value="{{$campaign->cid,$campaign->uid}}">
        		<button type="submit" class="btn btn-danger">Reject All</button>
        	</form>
        	
        	<form action="{{route('employer.campaign.approveallforrejected')}}" method="post" class="mr-2 approve-all-form">
        	@csrf
        	    <input type="hidden" name="id" value="{{$campaign->cid,$campaign->uid}}">
        		<button type="submit" class="btn btn-success">Approve all For Rejecetd Application</button>
        	</form>
        	
        	<form action="{{route('employer.campaign.rejectallforapproved')}}" method="post" class="mr-2 approve-all-form">
        	@csrf
        	    <input type="hidden" name="id" value="{{$campaign->cid,$campaign->uid}}">
        		<button type="submit" class="btn btn-danger">Reject all for Approved Application</button>
        	</form>
        		<form action="{{route('employer.campaign.approveallpro')}}" method="post" class="mr-2 approve-all-form">
        	@csrf
        	    <input type="hidden" name="id" value="{{$campaign->cid,$campaign->uid}}">
        		<button type="submit" class="btn btn-primary">Approve allproofs</button>
        	</form>
        </div>

    <div class="container-fluid" style="margin-top: 150px">
        
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="liveSearch" placeholder="Search...">
        </div>
        <?php $gig = $campaign->gig; ?>
        <h2 class="mb-4">{{$gig->campaign_title}}</h2>
        
        <div class="card mb-4">
            @if($campaigns->total() > 0)
                    <div class="pagination">
                        <div class="float-left">
                            <a href="{{ $campaigns->previousPageUrl() }}" style="background-color:lightblue;" class="btn btn-sm btn-secondary" @if(!$campaigns->onFirstPage()) @else disabled @endif >
                                &#9664;
                            </a>
                        </div>
                        
                        <p class="float-left ml-3 mr-3">Page {{ $campaigns->currentPage() }} of {{ $campaigns->lastPage() }}</p>
                        
                        <div class="float-left">
                            <a href="{{ $campaigns->nextPageUrl() }}" style="background-color:lightblue;" class="btn btn-sm btn-secondary" @if(!$campaigns->hasMorePages()) @else disabled @endif>
                                &#9654;
                            </a>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>
                @endif
            <div class="card-body">
                <table class="table  table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Applied Date</th>
                        <th scope="col">User Name</th>
                        <th scope="col">User Phone</th>
                        <th scope="col">User Email</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="campaignTableBody">

                    @foreach($campaigns as $campaign)
                    <?php 
                       $user = DB::table('users')->find($campaign->uid);
                    ?>
                    @if($user)
                        <tr class="campaignRow">
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{ \Carbon\Carbon::parse($campaign->created_at)->format('Y-m-d') }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->phone ?? '' }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                            @if ($campaign->status==0)
                                <span class="badge  badge-pill  badge-info">@lang('Applied')</span>
                            @elseif($campaign->status==1)
                                <span class="badge  badge-pill  badge-success">@lang('Application Approved')</span>
                            @elseif($campaign->status==2)
                                <span class="badge  badge-pill  badge-danger">@lang('Application Rejected')</span>
                            @elseif($campaign->status==3)
                                <span class="badge  badge-pill  badge-info">@lang('Proof Submitted')</span>
                            @elseif($campaign->status==4)
                                <span class="badge  badge-pill  badge-success">@lang('Proof Accepted, Paid')</span>
                            @elseif($campaign->status==5)
                                <span class="badge  badge-pill  badge-danger">@lang('Proof Rejected')</span>
                            @endif
                            </td>
                           
                            <td>
                            @if ($campaign->status==0)
                                <a href="{{route('employer.campaign.approve',[$campaign->cid,$campaign->uid])}}" class="btn btn-success btn-sm">Approve</a>
                                <a href="{{route('employer.campaign.reject',[$campaign->cid,$campaign->uid])}}" class="btn btn-danger btn-sm">Reject</a>
                            @elseif($campaign->status==3)
                                <a href="{{route('employer.campaign.viewproof',[$campaign->cid,$campaign->uid])}}" class="btn-link">View Proof(s)</a>
                            @elseif($campaign->status==1)
                                <a href="{{route('employer.campaign.reject',[$campaign->cid,$campaign->uid])}}" class="btn btn-danger btn-sm">Reject</a>
                            @elseif($campaign->status==2)
                                <a href="{{route('employer.campaign.approve',[$campaign->cid,$campaign->uid])}}" class="btn btn-success btn-sm">Approve</a>
                            @elseif($campaign->status==4)
                                <a href="{{route('employer.campaign.viewedproof',[$campaign->cid,$campaign->uid])}}" class="btn-link">View Accepted Proof(s)</a>
                            @elseif($campaign->status==5)
                                <a href="{{route('employer.campaign.viewedproof',[$campaign->cid,$campaign->uid])}}" class="btn-link">View Rejected Proof(s)</a>
                            @endif
                            </td>

                        </tr>
                        @endif
                    @endforeach

                    </tbody>
                </table>
                @if($campaigns->total() > 0)
                    <div class="pagination">
                        <div class="float-left">
                            <a href="{{ $campaigns->previousPageUrl() }}" style="background-color:lightblue;" class="btn btn-sm btn-secondary" @if(!$campaigns->onFirstPage()) @else disabled @endif >
                                &#9664;
                            </a>
                        </div>
                        
                        <p class="float-left ml-3 mr-3">Page {{ $campaigns->currentPage() }} of {{ $campaigns->lastPage() }}</p>
                        
                        <div class="float-left">
                            <a href="{{ $campaigns->nextPageUrl() }}" style="background-color:lightblue;" class="btn btn-sm btn-secondary" @if(!$campaigns->hasMorePages()) @else disabled @endif>
                                &#9654;
                            </a>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>
                @endif


                <!--{{$campaigns->links()}}-->
                @if(count($campaigns)>0)
                <a href="{{route('employer.gig.exportapps',$campaigns[0]->cid)}}" class="btn btn-primary btn-sm mt-4 mb-2">Export Applications</a>
                @endif
            </div>
        </div>
    </div>
    
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Check if there is a saved search query in local storage
            var savedSearchQuery = localStorage.getItem('searchQuery');
            if (savedSearchQuery) {
                $('#liveSearch').val(savedSearchQuery);
                applySearch(savedSearchQuery);
            }
    
            $('#liveSearch').on('keyup', function () {
                var searchText = $(this).val().toLowerCase();
                localStorage.setItem('searchQuery', searchText); // Save the search query to local storage
                applySearch(searchText);
            });
    
            function applySearch(searchText) {
                $('.campaignRow').hide(); // Hide all rows initially
                // Iterate over all table rows, including those on different pages
                $('.campaignRow').filter(function () {
                    return $(this).text().toLowerCase().includes(searchText);
                }).show();
            }
        });
    </script>
    <!--<script>-->
    <!--    $(document).ready(function () {-->
    <!--        $('#liveSearch').on('keyup', function () {-->
    <!--            var searchText = $(this).val().toLowerCase();-->
    
    <!--            $('.campaignRow').hide(); // Hide all rows initially-->
    
    <!--            // Iterate over all table rows, including those on different pages-->
    <!--            $('.campaignRow').filter(function () {-->
    <!--                return $(this).text().toLowerCase().includes(searchText);-->
    <!--            }).show();-->
    <!--        });-->
    <!--    });-->
    <!--</script>-->

    
    {{--dropdown active--}}
    <script>
        $('#Campaigns li:nth-child(3)').addClass('active');
        $('#Campaigns').addClass('show');
    </script>
@endsection
