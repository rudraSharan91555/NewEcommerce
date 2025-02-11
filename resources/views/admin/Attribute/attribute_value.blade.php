@extends("admin/layout")
@section("content")
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">ADD Attribute value</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">ADD Attribute value</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Settings</button>
                    <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
                    </div>
                </div>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">ADD Attribute value</h6>
        <hr />
        <div class="col">
            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="saveData('0','','')" class="btn btn-outline-info px-5 radius-30">Add ADD Attribute value</button>
            <hr/>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Attribute Name</th>
                                <th>Value</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $list)
                            <tr>
                                <td>{{$list->id}}</td>
                                <td>{{$list['singleAttribute']->name}},({{$list['singleAttribute']->slug}})</td>
                                <td>{{$list->value}}</td>
                                <td><button type="button" onclick="saveData('{{$list->id}}','{{$list->attributes_id}}','{{$list->value}}')" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#exampleModal">Update</button>
                                    <button onclick="deleteData('{{$list->id}}','attribute_values')" class="btn btn-outline-danger px-5 radius-30">Delete</button>
                                </td>



                            </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Attribute Id</th>
                                <th>Value</th>
                                <th>Created_at</th>
                                <th>Updated_at</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Attribute</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formSubmit" action="{{url('admin/update_attribute_value')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="border p-4 rounded">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                            </div>
                            <!-- <h5 class="mb-0 text-info">User Registration</h5> -->
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <label  class="col-sm-3 col-form-label">Attribute Name</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="attributes_id" id="attribute_id">
                                    @foreach($attribute as $list1)
                                    <option value="{{$list1->id}}">{{$list1->name}}({{$list1->slug}})</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  class="col-sm-3 col-form-label">Attribute Value</label>
                            <div class="col-sm-9">
                                <input type="text" name="value" class="form-control" id="attribute_value" placeholder="Enter Your Name" required>
                            </div>
                        </div>

                        <input type="hidden" name="id" id="enter_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <span id="submitButton">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </span>

                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function saveData(id, attribute_id, attribute_value) {
        $('#enter_id').val(id);
        $('#attribute_id').val(attribute_id);
        $('#attribute_value').val(attribute_value);



    }
</script>
@endsection