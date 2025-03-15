@extends('admin.master')

@section('title', 'Admin | All Internships')

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
    <h2 class="mb-4">Internships List</h2>

    <div class="card mb-4">
        <div class="card-header bg-white font-weight-bold">
            Internships
        </div>
        <div class="card-body">
            @if(count($jobs) == 0)
                <h2 class="text-center">@lang('No Data Available')</h2>
            @else
            {{-- {{$jobs->links()}} --}}
             <!-- Pagination Links -->
             <div class="d-flex justify-content-left">
                <nav>
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($jobs->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">«</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $jobs->previousPageUrl() }}" rel="prev">«</a>
                            </li>
                        @endif
            
                        {{-- First Page --}}
                        @if ($jobs->currentPage() > 3)
                            <li class="page-item">
                                <a class="page-link" href="{{ $jobs->url(1) }}">1</a>
                            </li>
                            @if ($jobs->currentPage() > 4)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endif
            
                        {{-- Page Range --}}
                        @for ($page = max(1, $jobs->currentPage() - 2); $page <= min($jobs->lastPage(), $jobs->currentPage() + 2); $page++)
                            <li class="page-item {{ $page == $jobs->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $jobs->url($page) }}">{{ $page }}</a>
                            </li>
                        @endfor
            
                        {{-- Last Page --}}
                        @if ($jobs->currentPage() < $jobs->lastPage() - 2)
                            @if ($jobs->currentPage() < $jobs->lastPage() - 3)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $jobs->url($jobs->lastPage()) }}">{{ $jobs->lastPage() }}</a>
                            </li>
                        @endif
            
                        {{-- Next Page Link --}}
                        @if ($jobs->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $jobs->nextPageUrl() }}" rel="next">»</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">»</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
                <table class="table table-striped table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Category</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Stipend</th>
                            <th scope="col">Publish Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Visibility</th> <!-- New Column -->
                            <th scope="col">Number of candidates Required</th>
                            <th scope="col">Work Place</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $job)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$job->title}}</td>
                                <td>{{$job->cat}}</td>
                                <td>{{$job->end}}</td>
                                <td>{{$job->stipend}}</td>
                                <td>{{ \Carbon\Carbon::parse($job->created_at)->format('Y-m-d') }}</td>
                                <td><a href="{{route('admin.job.campaign_status', $job->id)}}" class="btn btn-{{$job->projectstatus ? 'success' : 'danger'}} btn-sm">
                                    {{$job->projectstatus ? 'Active' : 'Inactive'}}
                                </a></td>
                                <td>
                                    <form action="{{ route('admin.job.toggle_visibility', $job->id) }}" method="get">
                                        <button type="submit" class="btn btn-{{ $job->is_visible ? 'success' : 'warning' }} btn-sm">
                                            {{ $job->is_visible ? 'Hide' : 'Show' }}
                                        </button>
                                    </form>
                                </td>                                
                                <td>{{$job->count}}</td>
                                <td>{{$job->place}}</td>
                                <td>
                                    @if($job->mobile == 0)
                                    <form action="{{route('admin.job.make-mobile')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$job->id}}">
                                        <button type="submit" class="btn btn-success btn-sm">Make mobile specific</button>
                                    </form>
                                    @else
                                    <form action="{{route('admin.job.undo-mobile')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$job->id}}">
                                        <button type="submit" class="btn btn-danger btn-sm">Undo mobile specific</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            {{-- {{$jobs->links()}} --}}
        </div>
    </div>
</div>

@endsection
