@extends('admin.mission.form-layout')
@section('title','Admin | Form Responses')
@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card rounded-0">
                <div class="card-header">
                    <h5 class="card-title">
                        Viewing response for form 
                        <strong>{{ $submission->form->name }}</strong>
                        
                    </h5>
                </div>

                <ul class="list-group list-group-flush">
                    @foreach($form_headers as $header)
                        <li class="list-group-item">
                            <strong>{{ $header['label'] ?? title_case($header['name']) }}: </strong> 
                            <span class="float-right">
                                {{ $submission->renderEntryContent($header['name'], $header['type']) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @if($camp->status!=4)
            <div class="row mt-3">
                <div class="col-md-6">
                    <button class="btn btn-success" data-toggle="modal" data-target="#payModal">Approve Response</button>
                </div>
                <div class="col-md-6">
                    <form action="{{route('admin.mission.rejectResp')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$camp->id}}">
                        <button class="btn btn-danger">Reject Response</button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card rounded-0">
                <div class="card-header">
                    <h5 class="card-title">Details</h5>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Form: </strong> 
                        <span class="float-right">{{ $submission->form->name }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Submitted By: </strong> 
                        <span class="float-right">{{ $submission->user->email ?? 'Guest' }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Last Updated On: </strong> 
                        <span class="float-right">{{ $submission->updated_at->toDayDateTimeString() }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Submitted On: </strong> 
                        <span class="float-right">{{ $submission->created_at->toDayDateTimeString() }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


{{-- Modal --}}
<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Enter Amount</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
		  <form action="{{route('admin.mission.acceptResp')}}" method="post">
			@csrf
            <input type="hidden" name="id" value="{{$camp->id}}">
			<div class="form-group">
				<span class="form-control-label" for="title">@lang('Enter amount to pay')</span>
				<input type="number" name="reward" class="form-control" placeholder="Enter amount to pay">
			</div>
			<button type="submit" class="btn btn-success">Pay</button>
		  </form>
		</div>
	  </div>
	</div>
  </div>
@endsection
