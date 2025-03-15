
    <?php 
        if($campaign->user_id=="Admin"){
            $user = "Admin";
        }
        else{
            $usere = DB::table('employers')->find($campaign->user_id);
            $user = $usere->name;
        }
        $cats = explode(", ",$campaign->cats);
        $count = 0;
        foreach($cats as $cat){
            $count++;
        }
        $statuses = [1,3,5];
        $tasks = App\Task::where('cid',$campaign->id)->get();
        $i=0;
    ?>
@extends('layouts.app')
@section('title', config('app.name').' | Gig Details')
@section('content')
<div class="theme-layout" id="scrollup">

	<section class="overlape">
		<div class="block no-padding">
			
			<div class="container fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="inner-header">
							<h3>{{$campaign->campaign_title}}</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="block">
			<div class="container">
				<div class="row">
				 	<div class="col-lg-12 column">
				 		<div class="job-single-sec style3">
				 			<div class="job-head-wide">
				 				<div class="row">
				 					<div class="col-lg-8">
				 						<div class="job-single-head3">
							 				<div class="job-thumb"> <img src="@if($user=='Admin') {{asset('assets/admin/img/gig-brand-logo/'.$campaign->logo)}} @else {{asset('assets/employer/profile_images/'.$usere->profile_photo)}} @endif" alt="Company Logo" /> </div>
                                            
							 				<div class="job-single-info3">
							 					<h3>{{$campaign->brand}}</h3>
							 					
							 					<ul class="tags-jobs">
								 					<li><i class="fas fa-coins"></i> Reward: ₹{{$campaign->per_cost}}</li>
								 					<li><i class="fas fa-calendar"></i>Created At:{{\Carbon\Carbon::parse($campaign->created_at)->format('d M Y | H:i:s')}}</li>
								 					<li><i class="fas fa-tasks"></i> Tasks:{{$count-1}} </li>
								 				</ul>
							 				</div>
							 			</div><!-- Job Head -->
				 					</div>
				 					<div class="col-lg-4">
                   @if(Auth::check())
                      @if(DB::table('gig_apps')->where(['uid' => Auth::user()->id,'cid' => $campaign->id])->exists())
				 						    <a class="apply-thisjob" href="{{route('user.gigs.show')}}"><i class="la la-paper-plane"></i>Already Applied</a>
                      @else
                      <form action="{{route('campaign.apply')}}" method="POST">
                      @csrf
                        <input type="hidden" name="id" value="{{$campaign->id}}">
                        <button class="apply-thisjob" type="submit"><i class="la la-paper-plane"></i>Apply for Gig</button>
                      </form>
                      @endif
                  @else
                  <a class="apply-thisjob" href="{{route('employer.login')}}"><i class="fa fa-paper-plane"></i>Please login as a user</a>
                  @endif
				 						
								 		
				 					</div>
				 				</div>
				 			</div>
                            
                  <div class="job-wide-devider">
                    <div class="row">
                    @foreach($cats as $cat)
                      @if($cat!="")
                      <?php $cate = DB::table('gig_categories')->find($cat); ?>
                      <!--<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">-->
                        <!--<div class="job-grid border">-->
                          <!--<div class="job-title-sec">-->
                          <!--  <div class="c-logo"> <img src="{{asset('assets/admin/img/cate_img/'.$cate->c_photo)}}" alt="Task Icon" /> </div>-->
                          <!--  <h3><a href="#">{{$cate->name}}</a></h3>-->
                          <!--</div>-->
                          <?php
                            if($cate->id==1){
                              $type = "Type: Facebook";
                            }
                            if($cate->id==2){
                              $type = "Type: Whatsapp";
                            }
                            if($cate->id==3){
                              $type = "Type: Instagram Story";
                            }
                            if($cate->id==4){
                              $type = "Type: Youtube";
                            }
                            if($cate->id==5){
                              $type = "Type: Instagram Post";
                            }
                            if($cate->id==6){
                              $type = "Type: Online Survey";
                            }
                            if($cate->id==7){
                              $type = "Type: Download App";
                            }
                            if($cate->id==8){
                              $type = "Type: Social Media";
                            }
                          ?>
                          @if(Auth::check())
                          @if(DB::table('gig_apps')->where(['uid'=>Auth::user()->id,'cid'=>$campaign->id])->wherein('status',$statuses)->exists() and DB::table('completed_gigs')->where(['user_id'=>Auth::user()->id,'job_id'=>$campaign->id])->where('proof_text','LIKE','%'.$type.'%')->doesntExist())
                          <button type="button" onclick="openm('{{$cate->id}}')"><i class="fas fa-tasks"></i>Start Task</button>
                          <?php $i=$i+1; ?>
                          @endif
                          @endif
                          
                        <!--</div>-->
                    <!--</div>-->
                    @endif
                    @endforeach
                  </div>
                </div>
                            
				 			<!--<div class="job-wide-devider">-->
							 <!--	<div class="row">-->
							 <!--		<div class="col-lg-8 column">		-->
							 <!--			<div class="job-details">-->
							 <!--				<h3>About Gig</h3>-->
							 <!--				<p>{!!$campaign->description!!}</p>     -->
        <!--              <h3>Tasks:</h3>-->
        <!--              <ul>-->
        <!--              @foreach($tasks as $task)-->
        <!--                @if($task->task!="")-->
        <!--                <li>{!!$task->task!!}</li>-->
        <!--                @endif-->
        <!--              @endforeach-->
        <!--              </ul>-->
        <!--              @if($user!="Admin")-->
        <!--              <div class="row mt-2">-->
        <!--                  @if($usere->facebook!=NULL)-->
        <!--                  <div class="col-md-12 col-lg-5 mr-2 mt-1 shadow border rounded p-2">-->
        <!--                    <a href="{{$usere->facebook}}"><i class="fab fa-facebook fa-lg"></i> {{$usere->facebook}}</a>-->
        <!--                  </div>-->
        <!--                  @endif-->
        <!--                  @if($usere->twitter!=NULL)-->
        <!--                  <div class="col-md-12 col-lg-5 mr-2 mt-1 shadow border rounded p-2">-->
        <!--                    <a href="{{$usere->twitter}}"><i class="fab fa-twitter fa-lg"></i> {{$usere->twitter}}</a>-->
        <!--                  </div>-->
        <!--                  @endif-->
        <!--                  @if($usere->gplus!=NULL)-->
        <!--                  <div class="col-md-12 col-lg-5 mr-2 mt-1 shadow border rounded p-2">-->
        <!--                    <a href="{{$usere->gplus}}"><i class="fab fa-google-plus fa-lg"></i> {{$usere->gplus}}</a>-->
        <!--                  </div>-->
        <!--                  @endif-->
        <!--                  @if($usere->youtube!=NULL)-->
        <!--                  <div class="col-md-12 col-lg-5 mr-2 mt-1 shadow border rounded p-2">-->
        <!--                    <a href="{{$usere->youtube}}"><i class="fab fa-youtube fa-lg"></i> {{$usere->youtube}}</a>-->
        <!--                  </div>-->
        <!--                  @endif-->
        <!--                  @if($usere->vimeo!=NULL)-->
        <!--                  <div class="col-md-12 col-lg-5 mr-2 mt-1 shadow border rounded p-2">-->
        <!--                    <a href="{{$usere->vimeo}}"><i class="fab fa-vimeo fa-lg"></i> {{$usere->vimeo}}</a>-->
        <!--                  </div>-->
        <!--                  @endif-->
        <!--                  @if($usere->linkedin!=NULL)-->
        <!--                  <div class="col-md-12 col-lg-5 mr-2 mt-1 shadow border rounded p-2">-->
        <!--                    <a href="{{$usere->linkedin}}"><i class="fab fa-linkedin fa-lg"></i> {{$usere->linkedin}}</a>-->
        <!--                  </div>-->
        <!--                  @endif-->
        <!--              </div>-->
        <!--              @endif-->

							 <!--			</div>-->
							 <!--		</div>-->
							 <!--	</div>-->
							 <!--</div>-->
					 	</div>
				 	</div>
				</div>
			</div>
		</div>
	</section>

</div>

<!-- Modals -->

<!-- FB proof -->
<div class="modal fade" id="1" tabindex="-1" role="dialog" aria-labelledby="FBModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Share a post on facebook</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.prooffb')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="username">FB Username</span>
              <input type="text" name="username" class="form-control">
          </div>
          <div class="form-group">
              <span for="username">Link to the post</span>
              <input type="text" name="link" class="form-control">
          </div>
          <div class="form-group">
              <span for="ss">Screenshot</span><br>
              <input type="file" name="ss" id="ss" accept=".jpg,.jpeg,.png,.bmp,.gif" onchange="getn(this.value,'fb')" style="display:none">
              <button type="button" class="btn btn-warning btn-lg float-left" onclick="document.getElementById('ss').click();">Upload Screenshot</button>
          </div>
          <div id="getnfb"></div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
</div>

<!-- WA proof -->
<div class="modal fade" id="2" tabindex="-1" role="dialog" aria-labelledby="WAModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Share a message on whatsapp</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.proofwa')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="phone">Mobile Number</span>
              <input type="text" name="phone" class="form-control">
          </div>
          <div class="form-group">
              <span for="ss">Screenshot</span><br>
              <input type="file" name="ss" id="wass" onchange="getn(this.value,'wa')" accept=".jpg,.jpeg,.png,.bmp,.gif" style="display:none">
              <button type="button" class="btn btn-warning btn-lg float-left" onclick="document.getElementById('wass').click();">Upload Screenshot</button>
          </div>
          <div id="getnwa"></div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
    </div>

<!-- Insta proof -->
<div class="modal fade" id="3" tabindex="-1" role="dialog" aria-labelledby="InstaModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Post an instagram story</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.proofinsta')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="username">Instagram Username</span>
              <input type="text" name="username" class="form-control">
          </div>
          <div class="form-group">
              <span for="link">Link to the post</span>
              <input type="text" name="link" class="form-control">
          </div>
          <div class="form-group">
              <span for="ss">Screenshot</span><br>
              <input type="file" name="ss" id="instass" onchange="getn(this.value,'insta')" accept=".jpg,.jpeg,.png,.bmp,.gif" style="display:none">
              <button type="button" class="btn btn-warning btn-lg float-left" onclick="document.getElementById('instass').click();">Upload Screenshot</button>
          </div>
          <div id="getninsta"></div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
    </div>

<!-- Youtube proof -->
<div class="modal fade" id="4" tabindex="-1" role="dialog" aria-labelledby="YtModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Youtube Like, Comment, Subscribe</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.proofyt')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="username">Youtube Username/Name</span>
              <input type="text" name="username" class="form-control">
          </div>
          <div class="form-group">
              <span for="ss">Screenshot</span><br>
              <input type="file" name="ss" id="ytss" onchange="getn(this.value,'yt')" accept=".jpg,.jpeg,.png,.bmp,.gif" style="display:none">
              <button type="button" class="btn btn-warning btn-lg float-left" onclick="document.getElementById('ytss').click();">Upload Screenshot</button>
          </div>
          <div id="getnyt"></div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
    </div>

<!-- Instagram Post proof -->
<div class="modal fade" id="5" tabindex="-1" role="dialog" aria-labelledby="DtModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Make an instagram post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.proofinstap')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="username">Instagram Username</span>
              <input type="text" name="username" class="form-control">
          </div>
          <div class="form-group">
              <span for="link">Link to the post</span>
              <input type="text" name="link" class="form-control">
          </div>
          <div class="form-group">
              <span for="ss">Screenshot</span><br>
              <input type="file" name="ss" id="instapss" onchange="getn(this.value,'instap')" accept=".jpg,.jpeg,.png,.bmp,.gif" style="display:none">
              <button type="button" class="btn btn-warning btn-lg float-left" onclick="document.getElementById('instapss').click();">Upload Screenshot</button>
          </div>
          <div id="getninstap"></div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
    </div>

<!-- Online Survey proof -->
<div class="modal fade" id="6" tabindex="-1" role="dialog" aria-labelledby="OSModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Online Survey</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.proofos')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="email">Email</span>
              <input type="email" name="email" class="form-control">
          </div>
          <div class="form-group">
              <span for="ss">Screenshot</span><br>
              <input type="file" name="ss" id="osss" onchange="getn(this.value,'os')" accept=".jpg,.jpeg,.png,.bmp,.gif" style="display:none">
              <button type="button" class="btn btn-warning btn-lg float-left" onclick="document.getElementById('osss').click();">Upload Screenshot</button>
          </div>
          <div id="getnos"></div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
    </div>

<!-- App proof -->
<div class="modal fade" id="7" tabindex="-1" role="dialog" aria-labelledby="ARModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Download an app and register</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.proofar')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="cred">Your credentials</span>
              <input type="text" name="cred" class="form-control">
          </div>
          <div class="form-group">
              <span for="ss">Screenshot</span><br>
              <input type="file" name="ss" id="appss" onchange="getn(this.value,'os')" accept=".jpg,.jpeg,.png,.bmp,.gif" style="display:none" multiple>
              <button type="button" class="btn btn-warning btn-lg float-left" onclick="document.getElementById('appss').click();">Upload Screenshot</button>
          </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
    </div>

<!-- Social media proof -->
<div class="modal fade" id="8" tabindex="-1" role="dialog" aria-labelledby="LSModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Like/Follow Social media page</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.proofls')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="cred">Your credentials</span>
              <input type="text" name="cred" class="form-control">
          </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
    </div>
@endsection
@section('scripts')
<script>
    function openm(id){
        $('#'+id).modal('show');
    }
</script>
<script>
function getn(str,d){
    str = str.split(/(\\|\/)/g).pop();
    $('#getn'+d).html(str);
}
</script>  
@endsection