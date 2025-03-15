@extends('admin.master')

@section('title', 'Admin | member withdraw log')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Member Withdraw Log</h2>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Withdraw
            </div>
            <div class="card-body">
                @if($transitions->count() > 0)
                    <table class="table  table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Payment Reason</th>
                            <th scope="col">Payable Amount</th>
                            <th scope="col">Pervious Amount</th>
                            <th scope="col">Balance</th>
                            <th scope="col">Applied at</th>

                        </tr>
                        </thead>
                        <tbody>
                            @foreach($transitions as $transition)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transition->reason }}</td>
                                    <td>{{ $transition->transition }}</td>
                                    <td>{{ $transition->pbalance }}</td>
                                    <td>{{ $transition->balance }}</td>
                                    <td>{{ $transition->created_at->format('d M, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No transitions found for this user.</p>
                @endif
                {{$transitions->links()}}
            </div>
        </div>
    </div>


    {{--dropdown active--}}
    <script>
        $('#memberSetting li:nth-child(1)').addClass('active');
        $('#memberSetting').addClass('show');
    </script>
@endsection
