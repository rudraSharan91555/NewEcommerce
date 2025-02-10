<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<!--plugins-->

<script src="{{asset('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
<script src="{{asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/plugins/chartjs/js/Chart.min.js')}}"></script>
<script src="{{asset('assets/plugins/chartjs/js/Chart.extension.js')}}"></script>
<script src="{{asset('assets/js/index.js')}}"></script>
<!--app JS-->
<script src="{{asset('assets/js/app.js')}}"></script>
<script src="https://developercodez.com/developerCorner/parsley/parsley.min.js"></script>
<script src="{{asset('snackbar/dist/js-snackbar.js')}}"></script>
 <script type="text/javascript" src="{{asset('multiSelect/jquery.multi-select.js')}}"></script>
    <script type="text/javascript">
    $(function(){
        $('#attribute_id').multiSelect();
    
        $('#line-wrap-example').multiSelect({
            positionMenuWithin: $('.position-menu-within')
        });
        $('#categories').multiSelect({
            noneText: 'All categories',
            presets: [
                {
                    name: 'All categories',
                    all: true
                },
                {
                    name: 'My categories',
                    options: ['a', 'c']
                }
            ]
        });
        $('#modal-example').multiSelect({
            'modalHTML': '<div class="multi-select-modal">'
        });
    });
    </script>
<script>
	$(document).ready(function() {
		$("#show_hide_password a").on('click', function(event) {
			event.preventDefault();
			if ($('#show_hide_password input').attr("type") == "text") {
				$('#show_hide_password input').attr('type', 'password');
				$('#show_hide_password i').addClass("bx-hide");
				$('#show_hide_password i').removeClass("bx-show");
			} else if ($('#show_hide_password input').attr("type") == "password") {
				$('#show_hide_password input').attr('type', 'text');
				$('#show_hide_password i').removeClass("bx-hide");
				$('#show_hide_password i').addClass("bx-show");
			}
		});
	});
</script>

<script>
// 	$(document).ready(function() {
//     $('#formSubmit').on('submit', function(e) {
//         if ($(this).parsley().validate()) {
//             e.preventDefault();
//             var formData = new FormData(this);
//             var loadingHtml = '<button class="btn btn-primary" type="button" disabled=""> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>';
//             var submitHtml = '<button type="submit" class="btn btn-primary">Save changes</button>';
            
//             $('#submitButton').html(loadingHtml);

//             $.ajax({
//                 type: 'POST',
//                 url: $(this).attr('action'),
//                 data: formData,
//                 cache: false,
//                 contentType: false,
//                 processData: false,
//                 success: function(result) {
//                     if (result.status === 'success') {
//                         showAlert(result.status, result.message);
//                         $('#submitButton').html(submitHtml);
                        
                        
//                         $('#exampleModal').modal('hide'); // Modal close
//                         setTimeout(function() {
//                             location.reload(); 
//                         }, 1000);
//                     } else {
//                         showAlert(result.status, result.message);
//                         $('#submitButton').html(submitHtml);
//                     }
//                 },
//                 error: function(result) {
//                     showAlert('error', result.responseJSON.message);
//                     $('#submitButton').html(submitHtml);
//                 }
//             });
//         }
//     });
// });

$(document).ready(function() {
    $('#formSubmit').on('submit', function(e) {
        if ($(this).parsley().validate()) {
            e.preventDefault();
            var formData = new FormData(this);
            var loadingHtml = '<button class="btn btn-primary" type="button" disabled=""> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>';
            var submitHtml = '<button type="submit" class="btn btn-primary">Save changes</button>';
            
            $('#submitButton').html(loadingHtml);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',  
                success: function(result) {
                    console.log("Response:", result); 

                    if (result.status === 'success') {
                        showAlert(result.status, result.message);
                        
                        setTimeout(function() {
                            $('#exampleModal').modal('hide'); 
                            if (result.reload) { 
                                window.location.reload(true); 
                            }
                        }, 1000);
                    } else {
                        showAlert(result.status, result.message);
                        $('#submitButton').html(submitHtml);
                    }
                },
                error: function(result) {
                    showAlert('error', result.responseJSON.message);
                    $('#submitButton').html(submitHtml);
                }
            });
        }
    });
});

	function deleteData(id, table) {
		let text = "Are you sure want to delete";
		if (confirm(text) == true) {
			$.ajax({
				type: 'GET',
				url: "{{url('admin/deleteData')}}/" + id + "/" + table + "",
				data: '',
				cache: false,
				contentType: false,
				processData: false,
				success: function(result) {
					if (result.status == 'success') {
						showAlert(result.status, result.message);

						if (result.data.reload != undefined) {
							window.location.href = window.location.href;
						}
					} else {
						showAlert(result.status, result.message);

						$('#submitButton').html(html1);
					}
				},
				error: function(result) {
					showAlert(result.responseJSON.status, result.responseJSON.message);
					$('#submitButton').html(html1);
				}


			});
		} else {

		}

	}
	
</script>

<script>
	
	function showAlert(type, message) {
    var alertBox = '<div class="alert alert-' + (type === "success" ? "success" : "danger") + ' alert-dismissible fade show" role="alert">' +
                   message +
                   '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    $('.page-content').prepend(alertBox);
    setTimeout(function() {
        $(".alert").alert('close');
    }, 3000);
}
</script>
<script>
	$(document).ready(() => {
		$("#photo").change(function() {
			const file = this.files[0];
			if (file) {
				let reader = new FileReader();
				reader.onload = function(event) {
					$("#imgPreview")
						.attr("src", event.target.result);
				};
				reader.readAsDataURL(file);
			}
		});
	});
</script>
<script>
	$(document).ready(function() {
		$('#example').DataTable();
	});
</script>
<script>
	$(document).ready(function() {
		var table = $('#example2').DataTable({
			lengthChange: false,
			buttons: ['copy', 'excel', 'pdf', 'print']
		});

		table.buttons().container()
			.appendTo('#example2_wrapper .col-md-6:eq(0)');
	});
</script>
