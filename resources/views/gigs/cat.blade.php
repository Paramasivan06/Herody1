@extends('user.master')
@section('title', $gs->websiteTitle.' | Gigs')
@section('heads')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
@endsection
@section('content')

<div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
           
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
          <div class="col-lg-3">
              <div class="card-wrapper">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                      <h3 class="mb-0">Filters</h3>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                         <h3>Categories</h3>
                          <select class="form-control" id="cat" data-toggle="select" onchange="movecat();">
                              <option value="">Select a category</option>
                              @foreach($cats as $cat)
                              <option value="{{$cat->id}}">{{$cat->name}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
              </div>
          </div>
        <div class="col-lg-9">
          <div class="card">
            <div class="card-header bg-transparent">
              <h3 class="mb-0">Gigs</h3>
            </div>
            
          </div>

          <div class="card">
              <div class="card-header">
</div>
<div class="row">
    @if($campaigns->count()==0)
    <div class="col-md-4 col-xs-12"><h1>No data found</h1></div>
    @else
    @foreach($campaigns as $campaign)
    <?php $cate = DB::table('campaign_categories')->find($campaign->campaign_category); ?>
    <?php 
        if($campaign->user_id=="Admin"){
            $user = "Admin";
        }
        else{
            $user = DB::table('employers')->find($campaign->user_id);
            $user = $user->name;
        }
    ?>
                      <div class="col-md-4 col-xs-12">
                        <div class="card">
                            <!-- Card body -->
                            <div class="card-body">
                              <a href="{{route('campaign.details',$campaign->id)}}">
                                <img src="{{asset('assets/user/images/cate_img/'.$cate->c_photo)}}" class="rounded-circle img-center img-fluid shadow shadow-md--hover" style="width: 140px;">
                              </a>
                            
                            
                              <div class="pt-4 text-center">
                                <h5 class="h3 title"><a href="{{route('campaign.details',$campaign->id)}}">{{$campaign->campaign_title}}</a>
                                  <span class="d-block mb-1">{{$user}}</span>
                                  
                                </h5>
                                </div>
                           <hr>
                                      <div class="d-flex align-items-center">
                                        <div>
                                          <div class="icon icon-xs icon-shape bg-green shadow rounded-circle">
                                            <i class="fas fa-rupee-sign"></i>
                                          </div>
                                        </div>
                                        <div>
                                          <span class="pl-2 text-sm text-black">Rs. {{$campaign->per_cost}}</span>
                                        
                                        </div>
                                      </div>
                                   
                                     
                                
                            </div>
                            </div>
              @endforeach
              {{$campaigns->links}}
              @endif
                          </div>
              </div>
          </div>
        </div>
        </div>
        </div>
        
      </div>
      <!-- Footer -->
     
    </div>
@endsection
@section('scripts')
<script>
    function movecat(){
        location.href="{{url('/')}}"+"/mission/cat/"+$('#cat').val();
    }
</script>
@endsection