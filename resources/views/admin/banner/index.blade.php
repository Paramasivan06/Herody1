@extends('admin.master')

@section('title', 'Admin | banner section')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Banner Section</h2>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Banner
                <a href="" class="btn btn-primary btn-md float-right customs_btn" data-toggle="modal"
                   data-target="#createMethod">
                    <i class="fa fa-plus"></i> ADD NEW
                </a>
            </div>
            <div class="card-body">
                <table class="table  table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">SN</th>
                        <th scope="col">Name</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($banners as $banner)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$banner->name}}</td>
                            <td>
                                <img src="{{ asset('assets/user/images/banner/' . $banner->image) }}" width="50" height="50" alt="Banner Image">
                            </td>
                            <td>
                                <a  href="#0" class="btn btn-info btn-sm btn-square"
                                   data-id="{{$banner->id}}"
                                   data-name="{{$banner->name}}"
                                   data-image="{{$banner->image}}"
                                   data-detail="{{$banner->text}}"
                                    data-toggle="modal" data-target="#editBanner" >Edit</a>

                                <a href="" class="btn btn-danger btn-sm btn-square" data-id="{{$banner->id}}" data-toggle="modal" data-target="#bannerRemove">Remove</a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{--create new method--}}
    <div id="createMethod" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Method</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{route('admin.banner.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="font-weight-bold" for="name">Name<span
                                                class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Banner name"
                                           required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image" class="font-weight-bold">Image<span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control" accept=".png,.jpeg,.jpg" required>
                                </div>
                            </div>
                            

                            <div class="col-md-12 my-4">
                                <h3 class="p-1 mybg-color text-center">Banner Instruction </h3>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="detail" class="font-weight-bold">Details or link For Banners<span
                                                class="text-danger"></span></label>
                                    <textarea name="detail" class="form-control" rows="5"
                                              placeholder="Instruction for withdraw"></textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnNewMethod" class="btn btn-primary mybg-color">Create</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="editBanner" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Method</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data" action="{{route('admin.banner.update','update')}}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <input class="form-control form-control-lg mb-3" type="hidden" name="id" id="id">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="font-weight-bold" for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" required>
                                </div>
                            </div>
                            

                            <div class="col-md-8 mb-4">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="image" class="col-md-12 font-weight-bold">Image</label>
                                        <div class="col-md-4">
                                            <img class="border border-primary p-1" id="methodImageView" style="width: 100%; height: 80%;">
                                        </div>
                                        <div class="col-md-8">
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="detail" class="font-weight-bold">Details or Link For Banners<span class="text-danger"></span></label>
                                    <textarea name="detail" class="form-control" rows="5" placeholder="Instruction to cash withdraw" id="detail" ></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnEditMethod" class="btn mybg-color">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--<!-- withdraw remove Alert Modal -->--}}
    <div class="modal modal-danger fade" id="bannerRemove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash"></i> Remove !</h4>
                </div>
                <form action="{{route('admin.banner.destroy','delete')}}"
                      method="post">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <input class="form-control form-control-lg mb-3" type="hidden" name="id" id="id">
                        <strong>Are you sure you want to Remove ?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{--dropdown active--}}
    <script>
        $('#Banner li:nth-child(1)').addClass('active');
        $('#Banner').addClass('show');
    </script>
@endsection



@section('scripts')
    {{--edit method--}}

    <script>
        $('#editBanner').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget)

            var name = button.data('name');
            var image = button.data('image');
            var path = "{{ asset('assets/user/images/banner/') }}";
            
            var detail = button.data('detail');
            
            var id = button.data('id');


            var modal = $(this);

            modal.find('.modal-body #name').val(name);
            
            modal.find('.modal-body #image').val(image);
            
            modal.find('.modal-body #detail').val(detail);
            

            modal.find('.modal-body #id').val(id);



            $('#methodImageView').attr('src', path+'/'+image);

        })


    </script>

    {{--remove script--}}
    <script>
        $('#bannerRemove').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        })
    </script>

@endsection
