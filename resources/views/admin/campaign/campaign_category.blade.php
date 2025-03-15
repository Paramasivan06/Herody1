@extends('admin.master')

@section('title', 'Admin | Gig category')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Gig Category</h2>
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white font-weight-bold">
                        Gig category list
                    </div>
                    <div class="card-body ">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($campaign_category as $campaign_cat)

                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$campaign_cat->name}}</td>

                                    <td>
                                        @if ($campaign_cat->status==1)
                                            <span class="badge  badge-pill  badge-success">Active</span>
                                        @else
                                            <span class="badge  badge-pill  badge-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td class=" actions">
                                        <a href="" class="btn btn-info btn-sm btn-square"
                                           data-name="{{$campaign_cat->name}}"
                                           data-status="{{$campaign_cat->status}}"
                                           data-id="{{$campaign_cat->id}}"
                                           data-toggle="modal" data-target="#categoryUpdate"
                                        >Edit</a>
                                    </td>
                                </tr>

                            @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <!-- Create category Modal -->
    <div class="modal modal-danger fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="myModalLabel">Create Category</h4>
                </div>
                <form action="{{route('admin.campaign_category.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label for="header_subtitle"><strong>Category Name</strong></label>
                                <input class="form-control form-control-lg mb-3" type="text" name="name" id="name"
                                       value="" required>
                            </div>
                        </div>

                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label for="header_subtitle"><strong>Photo</strong> <small class="text-info">( image will be resize 640 * 423 )</small>
                                </label>
                                <input class="form-control form-control-lg mb-3" type="file" name="c_photo"
                                        required>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="header_subtitle"><strong>Category Status</strong></label>
                                <select class="form-control" id="" name="status" required>
                                    <option selected value="">status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit category Modal -->
    <div class="modal modal-danger fade" id="categoryUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="myModalLabel">Edit Category</h4>
                </div>
                <form action="{{route('admin.campaign_category.update','update')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    <div class="modal-body">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="header_subtitle"><strong>Category name</strong></label>
                                <input class="form-control form-control-lg mb-3" type="text" name="name"
                                       id="name" required>
                            </div>
                        </div>

                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label for="header_subtitle"><strong>Photo</strong> <small class="text-info">( image will be resize 640 * 423 )</small>
                                </label>
                                <input class="form-control form-control-lg mb-3" type="file" name="c_photo" >
                            </div>
                        </div>

                        <input class="form-control form-control-lg mb-3" type="hidden" name="id" id="id">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="header_subtitle"><strong>Category Status</strong></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option selected value="">status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--dropdown active--}}
    <script>
        $('#activeCampaignCat').addClass('active');
        $('#activeCampaignCat').addClass('show');
    </script>
@endsection


@section('scripts')
    {{--script for modal Category edit--}}
    <script>
        $('#categoryUpdate').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget);

            var name = button.data('name');
            var status = button.data('status');
            var id = button.data('id');


            var modal = $(this);

            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #status').val(status);
            modal.find('.modal-body #id').val(id);

            modal.find('select[name=category_status]').val(status);

        })
    </script>

    {{--script for modal Category Delete--}}
    <script>
        $('#CategoryDelete').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        })
    </script>
@endsection

