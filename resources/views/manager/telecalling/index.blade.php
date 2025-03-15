@extends('layouts.app')

@section('title', 'Manager | All Telecallings')

@section('content')

    <div class="container-fluid">
        <h2 class="mb-4">Telecallings List</h2>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Telecallings
            <div class="float-right">
                <a href="{{route('manager.telecalling.create')}}" class="btn btn-primary btn-sm">Create Telecalling</a>
            </div>
            </div>
            <div class="card-body">
                @if($telecallings->count()==0)
                <p>No telecalling project found. Start one by clicking on the button above.</p>
                @else
                <table class="table  table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Per call amount</th>
                        <th scope="col">Entries in the excel file</th>
                        <th scope="col">Applications</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($telecallings as $telecalling)
                    <?php
                        
                        $inputFileName = "assets/telecalling/file/".$telecalling->file;

                        /**  Identify the type of $inputFileName  **/
                        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                        /**  Create a new Reader of the type that has been identified  **/
                        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                        /**  Load $inputFileName to a Spreadsheet Object  **/
                        $spreadsheet = $reader->load($inputFileName);
                        $datas = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                        $datacount = count($datas)-1;
                    ?>
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$telecalling->title}}</td>
                            <td>{{$telecalling->amount}}</td>
                            <td>{{$datacount}}</td>
                            <td>{{$telecalling->applications->count()}}</td>
                            <td>
                                @if($telecalling->distributed===0)
                                <form action="{{route("manager.telecalling.distribute")}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$telecalling->id}}"/>
                                    <button type="submit" class="btn btn-success">Distribute</button>
                                </form>
                                @else
                                Data has already been distributed among the selected users
                                @endif
                            </td>
                            <td>
                                @if($telecalling->applications->count()===0)
                                No application to view
                                @else
                                <a href="{{route('manager.telecalling.applications',$telecalling->id)}}">View Applications</a>
                                @endif
                            </td>
                            <td>
                                <form action="{{route("manager.telecalling.delete")}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$telecalling->id}}"/>
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                @endif
                {{$telecallings->links()}}
            </div>
        </div>
    </div>
@endsection
