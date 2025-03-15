@extends('admin.master')

@section('title', 'Admin | member Deposit History')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Member Deposit Log</h2>

        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body ">
                        <div class="table-responsive">
                            @if(count($trans)==0)
                                <h2 class="text-center">@lang('No Data Available')</h2>
                            @else
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Trans Id</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Charge</th>
                                    <th scope="col">Payment Method</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Requested At</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($trans as $data)
                                    <tr>
                                        <td>{{$data->trx}}</td>
                                        <td>{{$data->user->user_name}}</td>
                                        <td>{{$gs->currencySymbol}} {{$data->amount}}</td>
                                        <td>{{$gs->currencySymbol}} {{$data->charge}}</td>
                                        <td>
                                            @if($data->gateway->id <= 513)
                                                <span class="btn btn-success"><i class="fa fa-credit-card"></i> {{$data->gateway->name}}</span>
                                            @else
                                                <span class="btn btn-primary"><i class="fa fa-bank"></i> {{$data->gateway->name}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($data->status == 2)
                                                <label class="badge badge-danger">Reject</label>
                                            @elseif($data->status == 0 && $data->image != '' && $data->detail != '')
                                                <label class="badge badge-warning">Pending</label>
                                            @elseif($data->status == 1)
                                                <label class="badge badge-success">Complete</label>
                                            @endif
                                        </td>
                                        <td>{{date('g:ia \o\n l jS F Y', strtotime($data->created_at))}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @endif
                            {{$trans->links()}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    {{--dropdown active--}}
    <script>
        $('#memberSetting li:nth-child(1)').addClass('active');
        $('#memberSetting').addClass('show');
    </script>
@endsection