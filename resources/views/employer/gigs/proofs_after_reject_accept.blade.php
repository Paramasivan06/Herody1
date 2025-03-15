@extends('layouts.app')

@section('title', config('app.name').' | Gig Proof')
@section('heads')
<style>
.btn-postinter{
    display:block;
    padding: 0.3em;
    background: #E28C12;
    cursor: pointer;
    border: 2px solid #E28C12;
    border-radius: 3px;
    color: white;
    font-weight: bold;
    font-size: 1.1em;
    transition: all ease-out 0.5s;
}
.btn-postinter:hover{
    background: #C27910;
    border: 2px solid #C27910;
    color: #ffffff;
}
</style>
@endsection
@section('content')
<section class="cnddte_fvrt our-dashbord dashbord">
		<div class="container">
			<div class="row">
          @include('includes.emp-sidebar')
				<div class="col-sm-12 col-lg-8 col-xl-9">
					<div class="row">
						<div class="col-lg-12">
    <div class="container-fluid">
        <h2 class="mb-4">Gig Proof</h2>

        <div class="mb-4">
            <div class="card-body">
            @if($campaigns->count()==0)
            <p>No proof.</p>
            @else
                <table class="table  table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Proof Submitted Date</th>
                        <th scope="col">Proof File</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($campaigns as $campaign)
                    <?php 
                       $user = DB::table('users')->find($campaign->user_id);
                    ?>
                    @if($user)
                        <tr>
                            <td>{{$campaign->created_at->format('Y-m-d')}}</td>
                            <td>
                                @if($ga->status==5)
                                    <a href="{{asset('assets/user/images/reject_file/'.$campaign->proof_file)}}">{{$campaign->proof_file}}</a>
                                @else($ga->status==4)
                                    <a href="{{asset('assets/user/images/proof_file/'.$campaign->proof_file)}}">{{$campaign->proof_file}}</a>
                                @endif
                            </td>
                        </tr>
                    @endif
                    @endforeach
                    </tbody>
                    
                </table>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                
            </div>
        </div>
    </div>
</div></div></div></div></div>
</section>

    {{--dropdown active--}}
    <script>
        $('#Campaigns li:nth-child(3)').addClass('active');
        $('#Campaigns').addClass('show');
    </script>
@endsection
