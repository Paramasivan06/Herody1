@extends('layouts.app')
@section('title',config('app.name').' | withdraw history')
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
          <div class="col-lg-6">
              <div class="card-wrapper">
                <div class="card bg-gradient-gray">
                    <div class="card-body">
                      <h3 class="card-title text-white">Wallet</h3>
                      
                      
                        <span class="avatar avatar-md rounded-circle">
                         <i class="fas fa-wallet"></i>
                        </span> 
                        <hr><h3 class="text-white ">Rs. {{Auth::user()->balance}}</h3>
                        <p class="text-white">Available Balance</p>
                        <a href="{{route('user.show_withdraw_method')}}" role="button" class="btn btn-success">Withdraw Money</a>
        
                 
                    </div>
                  </div>
                 
              </div>
          </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header bg-transparent">
              <h3 class="mb-0">Recent Withdrawals</h3>
            @if(count($withdrawLogs)==0)
                <h2 class="text-center">@lang('No Data Available')</h2>
            @else
                <table class="table  table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">@lang('ID')</th>
                        <th scope="col">@lang('Withdraw Method')</th>
                        <th scope="col">@lang('Payment Detail')</th>
                        <th scope="col">@lang('Payable Amount')</th>
                        <th scope="col">@lang('Charge')</th>
                        <th scope="col">@lang('Requested At')</th>
                        <th scope="col">@lang('Processing Time')</th>
                        <th scope="col">@lang('Status')</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($withdrawLogs as $withdrawLog)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>

                            <td>{{$withdrawLog->withdraw_method->method_name}}</td>
                            <td>{{$withdrawLog->payment_details}}</td>
                            <td>{{$withdrawLog->payable_amount*$withdrawLog->withdraw_method->rate}} {{$withdrawLog->withdraw_method->currency}}</td>
                            <td>{{$gs->currencySymbol}}{{$withdrawLog->charge}}</td>
                            <td>{{$withdrawLog->created_at->format('d M, Y')}}</td>
                            <td>{{$withdrawLog->withdraw_method->waiting}}</td>

                            <td>
                                @if ($withdrawLog->status==1)
                                    <span class="badge  badge-pill  badge-success">@lang('Approved')</span>
                                @elseif($withdrawLog->status==2)
                                    <span class="badge  badge-pill  badge-danger">@lang('Rejected')</span>
                                @else
                                    <span class="badge  badge-pill  badge-warning">@lang('Pending')</span>
                                @endif
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {{$withdrawLogs->links()}}
            @endif

            </div>
            
          </div>

         
        </div>
        </div>
        </div>
        
      </div>
      <!-- Footer -->
     
    </div>
@endsection