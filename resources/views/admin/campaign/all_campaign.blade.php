@extends('admin.master')

@section('title', 'Admin | All Gigs')

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
        <h2 class="mb-4">Gigs List</h2>

        <div class="input-group mb-3">
            <input type="text" class="form-control" id="liveSearch" placeholder="Search...">
        </div>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Gigs
                <div class="float-right">
                    <a href="{{ route('admin.campaign.create') }}" class="btn btn-primary btn-sm">Create Gig</a>
                </div>
            </div>
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
                

                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Per job cost</th>
                            <th scope="col">User</th>
                            <th scope="col">Publish Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Show Status</th> <!-- New column -->
                            <th scope="col">View Status</th> <!-- New column -->
                            <th scope="col">Priority</th>
                            <th scope="col">Show Slot</th>
                            <th scope="col">Action</th>
                            <th scope="col" style="width:100px">Timing</th>
                            <th scope="col">Show</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($campaigns as $campaign)
                            <?php
                            if ($campaign->user_id == 'Admin') {
                                $user = 'Admin';
                            } else {
                                $user = DB::table('employers')->find($campaign->user_id);
                                $user = $user->name;
                            }
                            ?>
                            <tr class="campaignRow">
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $campaign->campaign_title }}</td>
                                <td>{{ $campaign->per_cost }}</td>
                                <td>{{ $user }}</td>
                                <td>{{ \Carbon\Carbon::parse($campaign->created_at)->format('Y-m-d') }}</td>
                                <td><a href="{{ route('admin.campaign.status', $campaign->id) }}"
                                        class="btn btn-{{ $campaign->gigstatus ? 'success' : 'danger' }} btn-sm">
                                        {{ $campaign->gigstatus ? 'Active' : 'Inactive' }}
                                    </a></td>
                                <td>
                                    <a href="{{ route('admin.campaign.showstatus', $campaign->id) }}"
                                        class="btn btn-sm
                                    @if ($campaign->show_status == 0) btn-primary
                                    @elseif($campaign->show_status == 1) btn-secondary
                                    @elseif($campaign->show_status == 2) btn-warning
                                    @else btn-danger @endif">
                                        @if ($campaign->show_status == 0)
                                            New
                                        @elseif($campaign->show_status == 1)
                                            Normal
                                        @elseif($campaign->show_status == 2)
                                            Old
                                        @else
                                            Expires Soon
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    <form action="{{ route('admin.campaign.toggleStatus', $campaign->id) }}" method="POST"
                                        id="toggleStatusForm-{{ $campaign->id }}">
                                        @csrf
                                        <input type="hidden" name="view_status"
                                            value="{{ $campaign->view_status == 1 ? 0 : 1 }}">
                                        <button type="submit" class="btn btn-info btn-sm">
                                            {{ $campaign->view_status == 1 ? 'Show Approved Applicants' : 'Show Total Applicants' }}
                                        </button>
                                    </form>
                                </td>
                                   <td>
                                    <form action="{{ route('admin.campaign.set-priority') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $campaign->id }}">
                                        <div class="input-group">
                                            <input type="text" name="priority" class="form-control"
                                                value="{{ $campaign->priority }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary btn-sm">Set Priority</button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('admin.campaign.showfirst', $campaign->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <div class="input-group input-group-sm">
                                            <!-- Input Field -->
                                            <input type="number" name="set_slot" id="slotNumber-{{ $campaign->id }}"
                                                class="form-control form-control-sm" placeholder="Slot #" min="0"
                                                value="{{ $campaign->set_slot }}" style="max-width: 60px;"
                                                oninput="updateSlotDisplay({{ $campaign->id }})">

                                            <!-- Display Selected Slot -->
                                            <span class="input-group-text"
                                                id="slotDisplay-{{ $campaign->id }}">{{ $campaign->set_slot ?? '-' }}</span>

                                            <!-- Submit Button -->
                                            <button type="submit"
                                                class="btn {{ $campaign->set_slot ? 'btn-success' : 'btn-secondary' }}">
                                                {{ $campaign->set_slot ? 'Update Slot' : 'Set Slot' }}
                                            </button>
                                        </div>
                                    </form>
                                    <form action="{{ route('admin.campaign.showsecond', $campaign->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <div class="input-group input-group-sm mt-2">
                                            <!-- Second Slot Field -->
                                            <input type="number" name="second_slot"
                                                id="secondSlotNumber-{{ $campaign->id }}"
                                                class="form-control form-control-sm" placeholder="Second Slot #"
                                                min="0" value="{{ $campaign->second_slot }}"
                                                style="max-width: 60px;"
                                                oninput="updateSecondSlotDisplay({{ $campaign->id }})">

                                            <!-- Display Second Slot -->
                                            <span class="input-group-text"
                                                id="secondSlotDisplay-{{ $campaign->id }}">{{ $campaign->second_slot ?? '-' }}</span>

                                            <!-- Submit Button for Second Slot -->
                                            <button type="submit"
                                                class="btn {{ $campaign->second_slot ? 'btn-success' : 'btn-secondary' }}">
                                                {{ $campaign->second_slot ? 'Update Slot' : 'Set Slot' }}
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    @if ($campaign->mobile == 0)
                                        <form action="{{ route('admin.campaign.make-mobile') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $campaign->id }}">
                                            <button type="submit" class="btn btn-success btn-sm">Make mobile
                                                specific</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.campaign.undo-mobile') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $campaign->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm">Undo mobile
                                                specific</button>
                                        </form>
                                    @endif
                                </td>
                                <td>{{ $campaign->timing ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.campaign.gig-details', $campaign->id) }}"
                                        class="btn btn-info btn-sm customs-btn-bd text-white"
                                        style="float:left;margin:5px 5px"> <i class="fa fa-eye"></i></a>
                                    <a href="{{ route('admin.campaign.edit', $campaign->id) }}"
                                        class="btn btn-primary btn-sm customs-btn-bd text-white"
                                        style="float:left;margin:0px 5px"> <i class="fa fa-edit"></i></a>

                                    <form action="{{ route('admin.campaign.delete') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $campaign->id }}" />
                                        <button onClick ="return confirm('Are You sure want to delete the gigs ?')"
                                            type="submit" class="btn btn-sm btn-danger"
                                            style="float:left;margin:0px 5px"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
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
                
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#liveSearch').on('keyup', function() {
                var searchText = $(this).val().toLowerCase();

                $('.campaignRow').hide(); // Hide all rows initially

                // Iterate over all table rows, including those on different pages
                $('.campaignRow').filter(function() {
                    return $(this).text().toLowerCase().includes(searchText);
                }).show();
            });
        });
    </script>

    {{-- dropdown active --}}
    <script>
        $('#Campaigns li:nth-child(3)').addClass('active');
        $('#Campaigns').addClass('show');
    </script>
@endsection
