@extends('layouts.app')
@section('title',config('app.name').' | Selected Resumes')

@section('content')
<div class="theme-layout" id="scrollup">
	<section class="overlape">
		<div class="block no-padding"><script src="https://kit.fontawesome.com/f3e18a60ac.js" crossorigin="anonymous"></script>
			<div data-velocity="-.1" style="background: url(images/resource/mslider1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
			<div class="container fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="inner-header">
							<h3>Welcome {{$employer->cname}}</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="block remove-bottom">
			<div class="container">
				 <div class="row no-gape">
           @include('includes.emp-sidebar')
				 	<div class="col-sm-12 col-lg-8 col-xl-9">
                        <h1 class="text-center">Responses</h1>
					    <div class="row ml-3">
                        @foreach($qus as $q)
                            <?php
                                $answer = \App\QAnswer::where(['qid' => $q->id,'uid' => $uid])->first();
                            ?>
                            <div class="col-lg-12">
                                <h3 class="pf-title">{{$q->question}}</h3>
                                <div class="pf-field ml-4">
                                    <span class="pf-title">{{$answer->answer}}</span>
                                </div>
                            </div>
                        @endforeach
					</div>
				 </div>
			</div>
		</div>
	</section>
</div>
@endsection