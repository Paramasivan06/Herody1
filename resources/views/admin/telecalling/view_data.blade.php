@extends('admin.master')

@section('title', 'Admin | Telecalling distributed data')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Telecalling distributed data</h2>

        <div class="card mb-4">
            <div class="card-body">
                @if(count($datas)==0)
                <p>No data.</p>
                @else
                    <table class="table table-striped table-bordered table-responsive">
                        <thead>
                        <tr>
                            @foreach ($keys as $key)
                                <th scope="col">{{$key}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                @foreach ($data as $datav)
                                    <td>{{$datav}}</td>
                                @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>


    {{--dropdown active--}}
    <script>
        $('#telecalling').addClass('show');
    </script>
@endsection
