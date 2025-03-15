@extends('admin.master')

@section('title', 'Admin | Withdraw Requests')

@section('body')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container-fluid">
    <h2 class="mb-4">Withdraw Requests</h2>
    
    <div class="input-group mb-3">
        <input type="text" class="form-control" id="liveSearch" placeholder="Search...">
    </div>

    <div class="card mb-4">
        <div class="card-header bg-white font-weight-bold">
            Withdraw Requests
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Withdraw method</th>
                        <th scope="col">User Name</th>
                        <th scope="col">User Email/Phone</th>
                        <th scope="col">Payment Details</th>
                        <th scope="col">Payable Amount</th>
                        <th scope="col">Requested At</th>
                        <th scope="col" style="min-width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if($withdrawRequests->isNotEmpty())
                        @foreach($withdrawRequests as $withdrawRequest)
                            <?php $user = \App\User::find($withdrawRequest->user_id); ?>
                            <?php
        // Check for duplicate payment_details with a different user_id
        $isDuplicateWithDifferentUser = false;
        foreach ($allRequests as $request) {
            if (
                $withdrawRequest->payment_details === $request['payment_details'] && 
                $withdrawRequest->user_id !== $request['user_id']
            ) {
                $isDuplicateWithDifferentUser = true;
                break;
            }
        }
    ?>
                            <tr class="campaignRow">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $withdrawRequest->withdraw_method->name }}</td>
                                <td>
                                    {{ $user->name ?? 'N/A' }} <br>
                                    @if($user)
                                        <a href="{{ route('admin.member.details', ['id' => $user->id]) }}" class="btn btn-primary btn-sm customs-btn-bd text-white">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    @endif
                                </td>
                                <td>
    <span class="{{ isset($duplicateEmails[optional($user)->email]) ? 'text-danger' : '' }}">
        {{ optional($user)->email ?? 'N/A' }}
        @if (isset($duplicateEmails[optional($user)->email]))
            <small>(Duplicate with another user)</small>
        @endif
    </span>
    <br>
    <span class="{{ isset($duplicatePhones[optional($user)->phone]) ? 'text-danger' : '' }}">
        {{ optional($user)->phone ?? 'N/A' }}
        @if (isset($duplicatePhones[optional($user)->phone]))
            <small>(Duplicate with another user)</small>
        @endif
    </span>
</td>


<td class="{{ $isDuplicateWithDifferentUser ? 'text-danger' : '' }}">
            {{ $withdrawRequest->payment_details }}
            @if ($isDuplicateWithDifferentUser)
                <small>(Duplicate with another user)</small>
            @endif
        </td>                                <td>{{ $withdrawRequest->payable_amount }}</td>
                                <td>{{ $withdrawRequest->created_at->format('d M, Y') }}</td>
<td class="d-flex justify-content-between align-items-center">
    <a href="#" class="btn btn-danger btn-sm mr-2" data-id="{{ $withdrawRequest->id }}" data-toggle="modal" data-target="#withdrawReject">
        Reject
    </a>
    <a href="#" class="btn btn-info btn-sm mr-2" data-id="{{ $withdrawRequest->id }}" data-toggle="modal" data-target="#withdrawApprove">
        Approve
    </a>
    <a href="#" class="btn btn-success btn-sm pay-now-btn" data-id="{{ $withdrawRequest->id }}" data-toggle="modal" data-target="#payNowModal">
        Pay Now
    </a>
</td>
</tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">No withdraw requests found.</td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="payNowModal" tabindex="-1" role="dialog" aria-labelledby="payNowModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payNowModalLabel">Pay Now</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.process-payout', '') }}" method="POST" id="payNowForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="payNowId">
                    <p>Are you sure you want to proceed with the payment?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Pay Now</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Approve Modal --}}
<div class="modal fade" id="withdrawApprove" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="approveModalLabel"><i class="fa fa-check"></i> Approve Withdraw Request</h4>
            </div>
            <form action="{{ route('admin.withdraw.approve') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="approveId">
                    <strong>Are you sure you want to approve this request?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="withdrawReject" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="rejectModalLabel"><i class="fa fa-times"></i> Reject Withdraw Request</h4>
            </div>
            <form action="{{ route('admin.withdraw.reject') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="rejectId">
                    <strong>Are you sure you want to reject this request?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#liveSearch').on('keyup', function () {
            const searchText = $(this).val().toLowerCase();
            $('.campaignRow').hide().filter(function () {
                return $(this).text().toLowerCase().includes(searchText);
            }).show();
        });

        $('#withdrawApprove').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            $('#approveId').val(id);
        });

        $('#withdrawReject').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            $('#rejectId').val(id);
        });
    });
</script>
<script>
    $(document).on('click', '.pay-now-btn', function () {
        var id = $(this).data('id');
        var formAction = "{{ route('admin.process-payout', '') }}/" + id;
        $('#payNowForm').attr('action', formAction);
        $('#payNowModal').find('#payNowId').val(id);
    });
</script>
@endsection

