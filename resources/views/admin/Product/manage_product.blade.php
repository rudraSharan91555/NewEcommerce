@extends("admin/layout")
@section("content")
<script src="{{ asset('ckeditor4/ckeditor.js') }}"></script>
<script src="{{ asset('ckfinder/ckfinder.js') }}"></script>

<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Manage Product</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Manage Product</li>
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

		<h6 class="mb-0 text-uppercase">Manage Product</h6>
		<hr />
		<div class="col">
			<button type="button" onclick="saveData('0','','','')" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Manage Product</button>
		</div>
		<hr/>
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-xl-9 mx-auto">
						<h6 class="mb-0 text-uppercase">Horizontal Form</h6>
						<hr>
						<div class="card border-top border-4 border-info">
							<form action="{{url('admin/updateProduct')}}" method="post" enctype="multipart/form-data">
								@csrf
								<div class="card-body">
									<div class="border p-4 rounded">
										<div class="card-title d-flex align-items-center">
											<div><i class="bx bxs-user me-1 font-22 text-info"></i>
											</div>
											<h5 class="mb-0 text-info">Product</h5>
										</div>
										<hr>
										<input type="hidden" name="id" value="{{$id}}">
										<div class="row mb-3">
											<label for="inputEnterYourName" class="col-sm-3 col-form-label">Product Name</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="inputEnterYourName" name="name" value="{{$data->name}}" placeholder="Enter Your Name">
											</div>
										</div>
										<div class="row mb-3">
											<label for="inputPhoneNo2" class="col-sm-3 col-form-label">Product Slug</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="inputPhoneNo2" name="slug" placeholder="Slug" value="{{$data->slug}}">
											</div>
										</div>
										<div class="row mb-3">
											<label for="inputPhoneNo2" class="col-sm-3 col-form-label">Product Image</label>
											<div class="col-sm-9">
												<input type="file" class="form-control" id="inputPhoneNo2" name="image" placeholder="Phone No">
											</div>
											@if($data->image!='')
											<img style="width: 100px;" src="{{$data->image}}">
											@endif
										</div>
										<div class="row mb-3">
											<label for="inputEmailAddress2" class="col-sm-3 col-form-label">Item Code</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" name="item_code" id="inputEmailAddress2" value="{{$data->item_code}}" placeholder="Email Address">
											</div>
										</div>
										<div class="row mb-3">
											<label for="inputEmailAddress2" class="col-sm-3 col-form-label">Keywords</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" name="keywords" id="inputEmailAddress2" value="{{$data->keywords}}" placeholder="Email Address">
											</div>
										</div>

										<div class="row mb-3">
											<label for="inputConfirmPassword2" class="col-sm-3 col-form-label">Category</label>
											<div class="col-sm-9">
												<select name="category_id" id="category" class="form-control">
													@foreach($category as $catList)
													@if($data->category_id == $catList->id)
													<option selected value="{{$catList->id}}">{{$catList->name}}</option>

													@else
													<option value="{{$catList->id}}">{{$catList->name}}</option>
													@endif
													@endforeach
												</select>
											</div>
										</div>
										<div class="row mb-3">
											<label for="attribute_id" class="col-sm-3 col-form-label">Attribute</label>
											<div class="col-sm-9">
												<span id="multiAttr">
													@if(isset($data['attribute'][0]->id))
													<select name="attribute_id[]" id="attribute_id" class="form-control" multiple>

														@foreach($data['attribute'] as $attributeList)
														<option value="{{$attributeList['attribute_values']->id}}" selected>{{$attributeList['attribute_values']->value}}</option>
														@endforeach
													</select>
													@endif
												</span>
											</div>
										</div>

										<div class="row mb-3">
											<label for="inputConfirmPassword2" class="col-sm-3 col-form-label">Brand</label>
											<div class="col-sm-9">
												<select name="brand_id" class="form-control">
													@foreach($brand as $brandList)
													@if($data->brand_id == $brandList->id)
													<option selected value="{{$brandList->id}}">{{$brandList->text}}</option>
													@else
													<option value="{{$brandList->id}}">{{$brandList->text}}</option>
													@endif
													@endforeach
												</select>
											</div>
										</div>
										<div class="row mb-3">
											<label for="inputConfirmPassword2" class="col-sm-3 col-form-label">Tax</label>
											<div class="col-sm-9">
												<select name="tax_id" class="form-control">
													@foreach($tax as $taxList)
													@if($data->tax_id == $taxList->id)
													<option selected value="{{$taxList->id}}">{{$taxList->text}}%</option>
													@else
													<option value="{{$taxList->id}}">{{$taxList->text}}%</option>
													@endif
													@endforeach
												</select>
											</div>
										</div>
										<div class="row mb-3">
											<label for="inputChoosePassword2" class="col-sm-3 col-form-label">Description</label>
											<div class="col-sm-9">
												<textarea class="form-control" name="description" id="desc" rows="3" placeholder="short desc" required>{{$data->description}}</textarea>
											</div>
										</div>



										<div class="row">
											<label for="inputChoosePassword2" class="col-sm-3 col-form-label">Product Attributes</label>


											<div class="row col-sm-9">
												<div class="col-sm-3">
													<button type="button" id="addAttributeButton" class="btn btn-info ">Add attribute</button>
												</div>

												@php
												$count=1;
												$imageCount=111;
												@endphp
												<div class="row" id="addAttr">
													@foreach($data['productAttributes'] as $productAttr)

													<div id="addAttr_{{$count}}">
														<input type="hidden" name="productAttrId[]" value="{{$productAttr['id']}}">
														<div class="col-sm-3">
															<select name="color_id[]" id="color_id" class="form-control">
																@foreach($color as $colorList)
																@if($productAttr['color_id'] == $colorList->id)
																<option selected class="box_color" style="background-color:{{$colorList->value}}" value="{{$colorList->id}}">{{$colorList->text}}</option>
																@else
																<option class="box_color" style="background-color:{{$colorList->value}}" value="{{$colorList->id}}">{{$colorList->text}}</option>
																@endif
																@endforeach
															</select>
														</div>

														<div class="col-sm-3">
															<select name="size_id[]" id="size_id" class="form-control">
																@foreach($size as $sizeList)
																@if($productAttr['size_id'] == $sizeList->id)
																<option selected value="{{$sizeList->id}}">{{$sizeList->text}}</option>
																@else
																<option value="{{$sizeList->id}}">{{$sizeList->text}}</option>
																@endif
																@endforeach
															</select>
														</div>
														<div class="col-sm-3">
															<input type="text" name="sku[]" class="form-control" value="{{$productAttr['sku']}}" id="inputEmailAddress2" placeholder="Enter SKU">
														</div>
														<div class="col-sm-3">
															<input type="text" name="mrp[]" class="form-control" value="{{$productAttr['mrp']}}" id="inputEmailAddress2" placeholder="Enter MRP">
														</div>
														<div class="col-sm-3">
															<input type="text" name="price[]" class="form-control" value="{{$productAttr['price']}}" id="inputEmailAddress2" placeholder="Enter Price">
														</div>
														<div class="col-sm-3">
															<input type="text" name="length[]" class="form-control" value="{{$productAttr['length']}}" id="inputEmailAddress2" placeholder="Enter Lenth">
														</div>
														<div class="col-sm-3">
															<input type="text" name="breadth[]" class="form-control" value="{{$productAttr['breadth']}}" id="inputEmailAddress2" placeholder="Enter Breadth">
														</div>
														<div class="col-sm-3">
															<input type="text" name="height[]" class="form-control" value="{{$productAttr['height']}}" id="inputEmailAddress2" placeholder="Enter Height">
														</div>
														<div class="col-sm-3">
															<input type="text" name="weight[]" class="form-control" value="{{$productAttr['weight']}}" id="inputEmailAddress2" placeholder="Enter Weight">
														</div>

														<div class="row mb-3">
															<label for="inputChoosePassword2" class="col-sm-3 col-form-label">Product Images</label>


															<div class="row col-sm-9">
																<input type="hidden" name="imageValue[]" value="{{$count}}">
																<div class="col-sm-3">
																	<button type="button" id="addAttrImages" onclick="addAttrImages1('attrImage_{{$count}}','{{$count}}')" class="btn btn-info ">Add image</button>
																</div>
																<div id="attrImage_{{$count}}">
																	@if(isset($productAttr['images'][0]))
																	@foreach($productAttr['images'] as $productAttrImages)
																	<div id="attrImage_{{$imageCount}}">
																		<div class="col-sm-3">
																			<input type="file" name="attr_image_{{$count}}[]" class="form-control" id="inputPhoneNo2" placeholder="Phone No">
																		</div>
																		@if($productAttrImages->image!='')
																		<img style="width: 100px;" src="{{$productAttrImages->image}}">
																		@endif
																		@if($imageCount!==111)
																		<button type="button" id="addAttrImages" onclick="removeAttr('attrImage_{{$imageCount}}','{{$productAttrImages->id}}','product_attr_images')" class="btn btn-danger ">Remove</button>
																		@endif
																	</div>
																	<?php $imageCount++; ?>
																	@endforeach
																	@endif
																</div>




															</div>

														</div>
														@if($count!==1)
														<button type="button" id="addAttrImages" onclick="removeAttr('addAttr_{{$count}}','{{$productAttr->id}}','product_attrs')" class="btn btn-danger ">Remove</button>
														@endif
													</div>
													<?php $count++; ?>
													<?php $imageCount++; ?>
												
													@endforeach
												

												</div>
											</div>
										</div>





										<div class="row">
											<label class="col-sm-3 col-form-label"></label>
											<div class="col-sm-9">
												<button type="submit" class="btn btn-info px-5">Submit</button>
											</div>
										</div>
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var editor = CKEDITOR.replace('desc');
	CKFinder.setupCKEditor(editor);
</script>

<script>
	function removeAttr(id, attrId = '', type = '') {
		$('#' + id + '').remove();
		if (type != '') {
			removeAttrId(attrId, type);
		}
	}


	var imageCount = 1990;

	function addAttrImages1(id, count) {
		console.log(id);
		imageCount++;
		var image_id = 'attrImage_' + imageCount + '';
		var html = '<div id="attrImage_' + imageCount + '"><div class="col-sm-3"><input type="file" name="attr_image_' + count + '[]" class="form-control" id="inputPhoneNo2" placeholder="Phone No"></div><button type="button" id="addAttrImages" onclick="removeAttr(\'' + image_id + '\')" class="btn btn-danger ">Remove</button></div>';
		$('#' + id + '').append(html);
	}
</script>
<script>
	var count = 111;

	$("#addAttributeButton").click(function(e) {
		count++;
		imageCount++;
		var id = 'addAttr_' + count + '';
		var imageAttr = 'attrImage_' + count + '';
		var removeimageAttr = 'attrImage_' + imageCount + '';
		var html = '';
		var sizeData = $('#size_id').html();
		var colorData = $('#color_id').html();
		html += '<div id="addAttr_' + count + '"><input type="hidden" name="productAttrId[]" value="0"><div class="col-sm-3"><select name="color_id[]" class="form-control">' + colorData + '</select></div>';
		html += '<div class="col-sm-3"><select name="size_id[]" class="form-control">' + sizeData + '</select></div>';
		html += '	<div class="col-sm-3"><input type="text" name="sku[]" class="form-control" id="inputEmailAddress2" placeholder="Enter SKU"></div>';
		html += '<div class="col-sm-3"><input type="text" name="mrp[]" class="form-control" id="inputEmailAddress2" placeholder="Enter MRP"></div>';
		html += '<div class="col-sm-3"><input type="text" name="price[]" class="form-control" id="inputEmailAddress2" placeholder="Enter Price"></div>';
		html += '	<div class="col-sm-3"><input type="text" name="length[]" class="form-control" id="inputEmailAddress2" placeholder="Enter Lenth"></div>';
		html += '<div class="col-sm-3"><input type="text" name="breadth[]" class="form-control" id="inputEmailAddress2" placeholder="Enter Breadth"></div>';
		html += '<div class="col-sm-3"><input type="text" name="height[]" class="form-control" id="inputEmailAddress2" placeholder="Enter Height"></div>';
		html += '<div class="col-sm-3"><input type="text" name="weight[]" class="form-control" id="inputEmailAddress2" placeholder="Enter Weight"></div>';
		html += '<div class="row mb-3"><label for="inputChoosePassword2" class="col-sm-3 col-form-label">Product Images</label><div class="row col-sm-9"><input type="hidden" name="imageValue[]" value="' + count + '"><div class="col-sm-3"><button type="button" id="addAttrImages" onclick="addAttrImages1(\'' + imageAttr + '\',\'' + count + '\')" class="btn btn-info ">Add image</button></div><div id="attrImage_' + count + '"><div id=attrImage_' + imageCount + '><div class="col-sm-3"><input type="file" name="attr_image_' + count + '[]" class="form-control" id="inputPhoneNo2" placeholder="Phone No"></div><button type="button" id="addAttrImages" onclick="removeAttr(\'' + removeimageAttr + '\')" class="btn btn-danger ">Remove</button></div></div></div></div><button type="button" id="addAttrImages" onclick="removeAttr(\'' + id + '\')" class="btn btn-danger ">Remove</button></div>'
		$('#addAttr').append(html);
	})
</script>
<script>
	$("#category").change(function(e) {
		var category_id = $('#category').val();
		var html = '';
		var url = "{{ url('admin/getAttributes') }}";
		$.ajax({
			url: url,
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			},
			data: {
				'category_id': category_id,
			},
			type: 'post',

			success: function(result) {


				if (result.status == 'success') {
					html += '<select name="attribute_id[]" id="attribute_id" class="form-control" multiple>';
					jQuery.each(result.data.data, function(key, val) {
						jQuery.each(val.values, function(attrKey, attrVal) {
							console.log(val);
							html += '<option value="' + attrVal.id + '">' + val.attribute.name + '( ' + attrVal.value + ' )</option>';
						})
					})
					html += '	</select>';
					$('#multiAttr').html(html);
					$('#attribute_id').multiSelect();
					// showAlert(result.status, result.message);
					// console.log(html);

				} else {
					showAlert(result.status, result.message);

				}
			},
			error: function(result) {
				showAlert(result.responseJSON.status, result.responseJSON.message);
			}
		});



	});

	function removeAttrId(id, type) {

		var url = "{{ url('admin/removeAttrId') }}";
		$.ajax({
			url: url,
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			},
			data: {
				'id': id,
				'type': type
			},
			type: 'post',

			success: function(result) {


				if (result.status == 'success') {



				} else {
					showAlert(result.status, result.message);

				}
			},
			error: function(result) {
				showAlert(result.responseJSON.status, result.responseJSON.message);
			}
		});
	}
</script>
@endsection