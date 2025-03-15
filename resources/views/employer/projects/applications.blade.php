@extends('layouts.app')
@section('title', config('app.name') . ' | Job Applications')

@section('content')
<div class="theme-layout" id="scrollup">
    <section class="overlape">
        <div class="block no-padding">
            <div style="background: url('/images/resource/mslider1.jpg') center/cover;" class="parallax"></div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="inner-header text-center my-5">
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
                    <div class="col-12">
                        @if($jas->count() == 0)
                            <div class="alert alert-warning text-center">
                                <h4>No applications found</h4>
                            </div>
                        @else
                         <div class="mb-3">
                                <a href="{{ route('employer.payu', ['id' => $job->id]) }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-credit-card"></i> Make Payment
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered custom-table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th>Name</th>
                                            <th>State</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jas as $ja)
                                            <?php $user = DB::table('users')->find($ja->uid); ?>
                                            @if($user)
                                                <tr>
                                                    <th scope="row">{{$loop->iteration}}</th>

                                                    <td>
                                                        <a href="{{ route('applicant.view', $ja->uid) }}" class="font-weight-bold">
                                                            {{$user->name}}
                                                        </a>
                                                    </td>
                                                    <td>{{$user->state}}</td>

                                                    <!-- Email Display with Hide/Show Logic -->
                                                    <td>
                                                        @if($jas->currentPage() == 1 && $loop->index < 5 || $job->is_visible == 0)
                                                            {{$user->email}}
                                                        @else
                                                            {{ 'xxxx' . strstr($user->email, '@') }}
                                                            <!-- Trigger the modal with a button -->
                                                        @endif
                                                    </td>

                                                    <!-- Phone Display with Hide/Show Logic -->
                                                    <td>
                                                        @if($jas->currentPage() == 1 && $loop->index < 5 || $job->is_visible == 0)
                                                            {{$user->phone}}
                                                        @else
                                                            {{ substr($user->phone, 0, 2) . 'xxxxx' . substr($user->phone, -2) }}
                                                            <!-- Trigger the modal with a button -->
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <div class="btn-group">
                                                            @if(\App\Shortlisted::where(['jid' => $ja->jid, 'uid' => $ja->uid])->exists())
                                                                <a href="#" class="btn btn-warning btn-sm" id="shortl">Shortlisted</a>
                                                            @else
                                                                <a href="{{ route('employer.job.shortlist', [$ja->jid, $ja->uid]) }}" class="btn btn-warning btn-sm" id="shortl">Shortlist</a>
                                                            @endif

                                                            <a href="{{ route('applicant.view', $ja->uid) }}" target="_blank" class="btn btn-info btn-sm">View Profile</a>

                                                            @if(\App\Reject::where(['uid' => $ja->uid, 'jid' => $ja->jid])->exists())
                                                                <a href="#" class="btn btn-danger btn-sm" id="reject">Rejected</a>
                                                            @else
                                                                <a href="{{ route('employer.job.reject', [$ja->jid, $ja->uid]) }}" class="btn btn-danger btn-sm" id="reject">Reject</a>
                                                            @endif

                                                            <a href="{{ route('employer.job.answers', [$ja->jid, $ja->uid]) }}" target="_blank" class="btn btn-secondary btn-sm" id="ans">View Answers</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#contactAdminModal">Contact Admin</button>
                            </div>

                            <div class="d-flex justify-content-center my-4">
                                {{-- {{ $jas->links() }} --}}
                            </div>

                            <!-- Action Buttons for All -->
                            <div class="d-flex justify-content-start mb-3">
                                <form action="{{ route('employer.job.shortlistall') }}" method="post" class="d-inline mr-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$ja->jid}}">
                                    <button type="submit" class="btn btn-success">Shortlist all</button>
                                </form>
                            
                                <form action="{{ route('employer.job.selectall') }}" method="post" class="d-inline mr-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$ja->jid}}">
                                    <button type="submit" class="btn btn-success">Select all</button>
                                </form>
                            
                                <form action="{{ route('employer.job.rejectall') }}" method="post" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$ja->jid}}">
                                    <button type="submit" class="btn btn-danger">Reject all</button>
                                </form>
                            </div>                                                        
                            <!-- Other Links -->
                            <div class="mb-4">
                                <a href="{{ route('employer.job.shortlisteds', $ja->jid) }}" class="btn btn-primary btn-sm">Shortlisted Users</a>
                                <a href="{{ route('employer.job.selecteds', $ja->jid) }}" class="btn btn-primary btn-sm">Selected Users</a>
                                <a href="{{ route('employer.job.exportapps', $ja->jid) }}" class="btn btn-primary btn-sm">Export Applications</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for Contacting Admin -->
    <div class="modal fade" id="contactAdminModal" tabindex="-1" role="dialog" aria-labelledby="contactAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactAdminModalLabel">Contact Admin for Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please contact the administrator to get the full contact details of the user.</p>
                    <!--<form>-->
                    <!--    <div class="form-group">-->
                    <!--        <label for="admin-email">Admin Email</label>-->
                    <!--        <input type="email" class="form-control" id="admin-email" value="admin@company.com" readonly>-->
                    <!--    </div>-->
                    <!--</form>-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
