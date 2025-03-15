@extends('admin.master')

@section('title', 'Admin | Project Application')

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
        <h2 class="mb-4">Project Application</h2>

        <div class="input-group mb-3">
            <input type="text" class="form-control" id="liveSearch" placeholder="Search...">
        </div>

        <div class="card mb-4">
            <div class="card-body">
                 <!-- Pagination Links -->
                 <div class="d-flex justify-content-left">
                    <nav>
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($campaigns->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">«</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $campaigns->previousPageUrl() }}" rel="prev">«</a>
                                </li>
                            @endif
                
                            {{-- First Page --}}
                            @if ($campaigns->currentPage() > 3)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $campaigns->url(1) }}">1</a>
                                </li>
                                @if ($campaigns->currentPage() > 4)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                            @endif
                
                            {{-- Page Range --}}
                            @for ($page = max(1, $campaigns->currentPage() - 2); $page <= min($campaigns->lastPage(), $campaigns->currentPage() + 2); $page++)
                                <li class="page-item {{ $page == $campaigns->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $campaigns->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor
                
                            {{-- Last Page --}}
                            @if ($campaigns->currentPage() < $campaigns->lastPage() - 2)
                                @if ($campaigns->currentPage() < $campaigns->lastPage() - 3)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link" href="{{ $campaigns->url($campaigns->lastPage()) }}">{{ $campaigns->lastPage() }}</a>
                                </li>
                            @endif
                
                            {{-- Next Page Link --}}
                            @if ($campaigns->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $campaigns->nextPageUrl() }}" rel="next">»</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">»</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                @if($campaigns->count() > 0)
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($campaigns as $campaign)
                                @if($campaign->user) {{-- Check if user exists --}}
                                    <tr class="campaignRow">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $campaign->user->email }}</td>
                                        <td>
                                            @switch($campaign->status)
                                                @case(0)
                                                    <span class="badge badge-pill badge-info">Applied</span>
                                                    @break
                                                @case(1)
                                                    <span class="badge badge-pill badge-success">Application Approved</span>
                                                    @break
                                                @case(2)
                                                    <span class="badge badge-pill badge-danger">Application Rejected</span>
                                                    @break
                                                @case(3)
                                                    <span class="badge badge-pill badge-info">Proof Submitted</span>
                                                    @break
                                                @case(4)
                                                    <span class="badge badge-pill badge-success">Proof Accepted, Paid</span>
                                                    @break
                                                @case(5)
                                                    <span class="badge badge-pill badge-danger">Proof Rejected</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @if ($campaign->status == 0)
                                                <a href="{{ route('admin.mission.accept', $campaign->id) }}" class="btn btn-success btn-sm">Approve</a>
                                                <a href="{{ route('admin.mission.reject', $campaign->id) }}" class="btn btn-danger btn-sm">Reject</a>
                                            @elseif($campaign->status == 3)
                                                <a href="{{ route('admin.mission.response', $campaign->id) }}" class="btn-link">View Response(s)</a>
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-danger">User Not Found (UID: {{ $campaign->uid }})</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                   

                    {{-- Export Button --}}
                    <a href="{{ route('admin.campaign.apps.export', $campid) }}" class="btn btn-primary mt-3">Export All Applications</a>

                @else
                    <p class="text-center text-muted">No applications found.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Live Search Script --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#liveSearch').on('keyup', function () {
                var searchText = $(this).val().toLowerCase();
                $('.campaignRow').each(function () {
                    $(this).toggle($(this).text().toLowerCase().includes(searchText));
                });
            });
        });
    </script>

    {{-- Dropdown Active --}}
    <script>
        $('#Campaigns li:nth-child(3)').addClass('active');
        $('#Campaigns').addClass('show');
    </script>
@endsection
