@extends('admin.master')

@section('title', 'Admin | Gigs log')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Gigs Log</h2>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Gigs
            </div>
            <div class="card-body">
                @if(count($agigs)==0)
                    <h2 class="text-center">@lang('No Data Available')</h2>
                @else
                    <table class="table  table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Application Applied Date</th>
                            <th scope="col">Campaign Title</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Per Cost</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($agigs as $agig)
                        <?php $gig = \App\Gig::find($agig->cid); 
                              $user = $gig ? \App\Employer::find($gig->user_id) : null;
                              $delete = \App\DeletedGig::find($agig->cid);
                        ?>
                            <tr>
                                <td>{{ $agig->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if($gig)
                                        {{ $gig->campaign_title }}
                                    @elseif($delete)
                                        {{ $delete->campaign_title }}
                                    @else
                                        Not Available
                                    @endif
                                </td>
                                <td>
                                    @if($user)
                                        {{ $user->cname }}
                                    @elseif($delete)
                                        {{ $delete->brand }}
                                    @else
                                        Not Available
                                    @endif
                                </td>
                                <td>
                                    @if($gig)
                                        {{ $gig->per_cost }}
                                    @elseif($delete)
                                        {{ $delete->per_cost }}
                                    @else
                                        Not Available
                                    @endif
                                </td>
                                <!--<td>{{ $agig->created_at->format('Y-m-d') }}</td>-->
                                <!--<td>{{ $gig ? $gig->campaign_title : 'Not Available' }}</td>-->
                                <!--<td>{{ $user ? $user->cname : 'Not Available' }}</td>-->
                                <!--<td>{{ $gig ? $gig->per_cost : 'Not Available' }}</td>-->
                                <td>
                                @if($agig->status==0)
                                    <span class="badge  badge-pill  badge-info">@lang('Applied')</span>
                                @elseif($agig->status==1)
                                    <span class="badge  badge-pill  badge-success">@lang('Application Approved')</span>
                                @elseif($agig->status==2)
                                    <span class="badge  badge-pill  badge-danger">@lang('Application Rejected')</span>
                                @elseif($agig->status==3)
                                    <span class="badge  badge-pill  badge-info">@lang('Proof Submitted')</span>
                                @elseif($agig->status==4)
                                    <span class="badge  badge-pill  badge-success">@lang('Proof Accepted & Paid')</span>
                                @elseif($agig->status==5)
                                    <span class="badge  badge-pill  badge-danger">@lang('Proof Rejected')</span>
                                @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @endif
                {{$agigs->links()}}
            </div>
        </div>
    </div>


    {{--dropdown active--}}
    <script>
        $('#memberSetting li:nth-child(1)').addClass('active');
        $('#memberSetting').addClass('show');
    </script>
@endsection
