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
        <h2 class="mb-4">Business Form Responses</h2>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                List
            </div>
            <div class="card-body">
                @if(count($bforms)==0)
                    <h2 class="text-center">@lang('No Data Available')</h2>
                @else
                    <table class="table  table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Contact Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Area of Work</th>
                            <th scope="col">Requirement</th>
                          <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($bforms as $bform)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$bform->vname}}</td>
                                <td>{{$bform->cname}}</td>
                                <td>{{$bform->vemail}}</td>
                                <td>{{$bform->vmobile}}</td>
                                <td>{{$bform->area}}</td>
                                <td>{{$bform->msg}}</td>
                                <td><form action="{{route('admin.bform.delete')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$bform->id}}">
                                    <button class="btn btn-danger" id="submit" name="submit" type="submit" onclick="return confirm('Are you sure want to delete this?')">Delete</button>
                                </form></td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    
                    {{-- {{$bforms->links()}} --}}
                    <!-- Pagination Links -->
             <div class="d-flex justify-content-left">
                <nav>
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($bforms->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">«</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $bforms->previousPageUrl() }}" rel="prev">«</a>
                            </li>
                        @endif
            
                        {{-- First Page --}}
                        @if ($bforms->currentPage() > 3)
                            <li class="page-item">
                                <a class="page-link" href="{{ $bforms->url(1) }}">1</a>
                            </li>
                            @if ($bforms->currentPage() > 4)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endif
            
                        {{-- Page Range --}}
                        @for ($page = max(1, $bforms->currentPage() - 2); $page <= min($bforms->lastPage(), $bforms->currentPage() + 2); $page++)
                            <li class="page-item {{ $page == $bforms->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $bforms->url($page) }}">{{ $page }}</a>
                            </li>
                        @endfor
            
                        {{-- Last Page --}}
                        @if ($bforms->currentPage() < $bforms->lastPage() - 2)
                            @if ($bforms->currentPage() < $bforms->lastPage() - 3)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $bforms->url($bforms->lastPage()) }}">{{ $bforms->lastPage() }}</a>
                            </li>
                        @endif
            
                        {{-- Next Page Link --}}
                        @if ($bforms->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $bforms->nextPageUrl() }}" rel="next">»</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">»</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
                @endif
                
            </div>
        </div>
    </div>



    {{--dropdown active--}}
    <script>
        $('#pending li:nth-child(2)').addClass('active');
        $('#pending').addClass('show');
    </script>
@endsection