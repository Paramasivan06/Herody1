@extends('admin.master')

@section('title', 'Admin | Campaigns log')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Campaigns Log</h2>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Campaigns
            </div>
            <div class="card-body">
                @if(count($acampaigns)==0)
                    <h2 class="text-center">@lang('No Data Available')</h2>
                @else
                    <table class="table  table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Reward</th>
                            <th scope="col">Applied at</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($acampaigns as $acampaign)
                        <?php $campaign = \App\Campaign::find($acampaign->cid); ?>
                            <tr>
                                <td>{{$campaign->title}}</td>
                                <td>{{$campaign->brand}}</td>
                                <td>{{$campaign->reward}}</td>
                                <td>{{ \Carbon\Carbon::parse($acampaign->created_at)->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @endif
                {{$acampaigns->links()}}
            </div>
        </div>
    </div>


    {{--dropdown active--}}
    <script>
        $('#memberSetting li:nth-child(1)').addClass('active');
        $('#memberSetting').addClass('show');
    </script>
@endsection
