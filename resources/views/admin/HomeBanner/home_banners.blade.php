@extends('admin.layout')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">Home Banner</h6>
        <hr />
        <button type="button" onclick="saveData('','','','')" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Home Banner
        </button>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Text</th>
                                <th>Link</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $list)
                            <tr>
                                <td>{{ $list->id }}</td>
                                <td>{{ $list->text }}</td>
                                <td>{{ $list->link }}</td>
                                <td>
                                    <img src="{{ asset('storage/images/'.$list->image) }}" width="100px" height="100px">
                                </td>
                                <td><button type="button" onclick="saveData('{{$list->id}}','{{$list->text}}','{{$list->link}}','{{$list->image}}')" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#exampleModal">Update</button>
                                    <button onclick="deleteData('{{$list->id}}','home_banners')" class="btn btn-outline-danger px-5 radius-30">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Text</th>
                                <th>Link</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Home Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.updateHomeBanner') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-9 mx-auto">
                            <div class="card border-top border-4 border-info">
                                <div class="card-body">
                                    <div class="border p-4 rounded">
                                        <div class="row mb-3">
                                            <label for="enter_text" class="col-sm-3 col-form-label">Text</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="text" class="form-control" id="enter_text" placeholder="Enter Your Text" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="enter_link" class="col-sm-3 col-form-label">Link</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="link" class="form-control" id="enter_link" placeholder="Enter Your Link">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="photo" class="col-sm-3 col-form-label">Image</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" name="image" id="photo">
                                            </div>
                                        </div>
                                        <div id="image_key">
                                            <img src="" id="imagePreview" height="200px" width="200px">
                                        </div>
                                        <input type="hidden" name="id" id="enter_id">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('imagePreview').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    function saveData(id, text, link, image) {
        $('#enter_id').val(id);
        $('#enter_text').val(text);
        $('#enter_link').val(link);

        const imagePath = image ? "{{ asset('storage/images') }}/" + image : "{{ asset('images/upload.png') }}";
        $('#image_key').html(`<img src="${imagePath}" id="imagePreview" height="200px" width="200px">`);
    }
</script>

@endsection  