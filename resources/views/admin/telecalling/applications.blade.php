@extends('admin.master')

@section('title', 'Admin | Telecalling Application')

@section('body')
<style>
    .pagination .page-link {
        color: #007bff;
        border: 1px solid #dee2e6;
        padding: 8px 12px;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #f8f9fa;
    }

    .table-responsive {
        border-collapse: separate;
        /* Ensures spacing works */
        border-spacing: 10px;
        /* Adjust column gap */
    }

    .table td,
    .table th {
        padding: 12px;
        /* Adjusts cell padding */
    }
</style>
    <div class="container-fluid">
        <h2 class="mb-4">Telecalling Application</h2>

        <div class="card mb-4">
            <div class="card-body">
                @if($applications->isEmpty())
                    <p class="text-center text-danger">No applications found.</p>
                @else
                 <!-- Pagination Links -->
             <div class="d-flex justify-content-left">
                <nav>
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($applications->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">«</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $applications->previousPageUrl() }}" rel="prev">«</a>
                            </li>
                        @endif
            
                        {{-- First Page --}}
                        @if ($applications->currentPage() > 3)
                            <li class="page-item">
                                <a class="page-link" href="{{ $applications->url(1) }}">1</a>
                            </li>
                            @if ($applications->currentPage() > 4)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endif
            
                        {{-- Page Range --}}
                        @for ($page = max(1, $applications->currentPage() - 2); $page <= min($applications->lastPage(), $applications->currentPage() + 2); $page++)
                            <li class="page-item {{ $page == $applications->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $applications->url($page) }}">{{ $page }}</a>
                            </li>
                        @endfor
            
                        {{-- Last Page --}}
                        @if ($applications->currentPage() < $applications->lastPage() - 2)
                            @if ($applications->currentPage() < $applications->lastPage() - 3)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $applications->url($applications->lastPage()) }}">{{ $applications->lastPage() }}</a>
                            </li>
                        @endif
            
                        {{-- Next Page Link --}}
                        @if ($applications->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $applications->nextPageUrl() }}" rel="next">»</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">»</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applications as $application)
                                <?php $user = \App\User::find($application->uid); ?>
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>
                                        @if($user)
                                            {{$user->user_name}}
                                        @else
                                            <span class="text-danger">User Not Found</span>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($application->status)
                                            @case(0) <span class="badge badge-pill badge-info">@lang('Applied')</span> @break
                                            @case(1) <span class="badge badge-pill badge-success">@lang('Application Approved')</span> @break
                                            @case(2) <span class="badge badge-pill badge-danger">@lang('Application Rejected')</span> @break
                                            @case(3) <span class="badge badge-pill badge-info">@lang('Data Distributed')</span> @break
                                            @case(4) <span class="badge badge-pill badge-success">@lang('Feedback Submitted')</span> @break
                                            @case(5) <span class="badge badge-pill badge-danger">@lang('Proof Rejected')</span> @break
                                        @endswitch
                                    </td>
                                    <td>
                                        @if($application->status === 4)
                                            <a href="{{route("admin.telecalling.feedback",$application->id)}}">View Feedback</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($application->status == 0)
                                            <form action="{{route("admin.telecalling.select")}}" method="POST" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{$application->uid}}">
                                                <input type="hidden" name="tid" value="{{$application->tid}}">
                                                <button class="btn btn-success btn-sm">Select</button>
                                            </form>
                                            <form action="{{route("admin.telecalling.reject")}}" method="POST" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{$application->uid}}">
                                                <input type="hidden" name="tid" value="{{$application->tid}}">
                                                <button class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        @elseif($application->status == 3 || $application->status === 4)
                                            <a href="{{route('admin.telecalling.viewdata',[$application->tid,$application->uid])}}" class="btn-link">View Distributed Data</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                {{-- Pagination --}}
                {{-- {{$applications->links()}} --}}
            </div>
        </div>
    </div>

    {{-- Dropdown Active --}}
    <script>
        $('#telecalling li:nth-child(1)').addClass('active');
        $('#telecalling').addClass('show');
    </script>
@endsection
