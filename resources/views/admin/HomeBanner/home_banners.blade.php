@extends("admin/layout")
@section("content")
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Home Banner</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Home Banner</li>
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

		<h6 class="mb-0 text-uppercase">Home Banner</h6>
		<hr />
		<div class="col">
			<button type="button" onclick="saveData('0','','','')" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Home Banner</button>
		</div>
		<hr/>
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
								<th>Acton</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data as $list)
							<tr>
								<td>{{$list->id}}</td>
								<td>{{$list->text}}</td>
								<td>{{$list->link}}</td>
								<td>{{$list->image}}</td>
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
								<th>Acton</th>
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
				<h5 class="modal-title" id="exampleModalLabel">Home Banner</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="formSubmit" action="{{url('admin/updateHomeBanner')}}" method="post" enctype="multipart/form-data">
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
						<label for="enter_text" class="col-sm-3 col-form-label">Text</label>
						<div class="col-sm-9">
							<input type="text" name="text" class="form-control" id="enter_text" placeholder="Enter Your Name" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="inputPhoneNo2" class="col-sm-3 col-form-label">Link</label>
						<div class="col-sm-9">
							<input type="text" name="link" class="form-control" id="enter_link" placeholder="Phone No" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="inputEmailAddress2" class="col-sm-3 col-form-label">Image</label>
						<div class="col-sm-9">
							<input type="file" name="image" class="form-control" id="photo" placeholder="Email Address" required>
						</div>
						<div id="image_key">
							<img src="" id="imgPreview" height="200px" width="200px">
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
	function saveData(id,text,link,image)
	{
		$('#enter_id').val(id);
		$('#enter_text').val(text);
		$('#enter_link').val(link);

		if(image == ''){
			var key_image = "{{URL::asset('images/upload.png')}}";
			$('#photo').prop('required',true);
		}else{
			var key_image = image;
			$('#photo').prop('required',false);
		}
		var html = '	<img src="'+key_image+'"   id="imgPreview" height="200px" width="200px">';
		$('#image_key').html(html);
	}
</script>
@endsection