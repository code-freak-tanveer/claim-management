@extends('layouts.main')
@section('heading')
       <a class="navbar-brand" href="#">Batch</a>
@endsection
@section('body')
<div class="content">
            <div class="container-fluid">
				<div class="card">
				    <div class="content">
						<div class="row"> 
							<div class="col-md-12">
								<div class="card card-plain">
									<div class="header">
										<h4 class="title">Create new Batch</h4>
										@if (Session::has('message'))
										   <div class="alert alert-info">{{ Session::get('message') }}
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
										   </div>
										@endif
									</div>
									<form method="post" action="add/batch" id="batch_form">
									{{csrf_field()}}
										<div class="row">
											<div class="col-md-6 col-xs-12">
												<div class="col-md-12">
													<div class="form-group">
														<label for="studentid">Batch Name</label>
														<input type="text" required minlength="5" name="batch_title" class="form-control" placeholder="Batch Name">
													</div>
												</div>
											</div>
											<div class="col-md-6 col-xs-12">
												<div class="col-md-6">
													<div class="form-group">
														<label for="studentid">Session Start</label>
														<input type="date" required id="batch_start" name="batch_start" class="form-control" placeholder="Select a Date">

													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="studentid">Session End</label>
														<input type="date" required name="batch_end" class="form-control" placeholder="Select a Date">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-xs-12">
												<div class="col-md-12">
													<div class="form-group">
														<label>Select Faculty</label>
														<select class="form-control" required name="faculties" id="faculties">
															<!-- Javascrip faculty -->
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-xs-12">
												<div class="col-md-12">
													<div class="form-group">
														<label>Select Course</label>
														<select class="form-control" required name="courses" id="courses">
															<!-- Javascrip Courses -->
														</select>
													</div>
												</div>
											</div>
										</div>
										<div id="module_container">
											<div class="row">
											<div class="col-md-6 col-xs-12">
												<div class="col-md-12">
													<div class="form-group">
														<label>Select Module</label>
														<select class="form-control modules" required name="modules[]" id="">
															<!-- Javascript modules -->
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-xs-12">
												<div class="col-md-6">
													<div class="form-group">
														<label for="studentid">Start Date</label>
														<input type="date" required name="module_start[]" class="form-control" placeholder="Select a Date">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="studentid">End Date</label>
														<input type="date" required name="module_end[]" class="form-control" placeholder="Select a Date">
													</div>

												</div>
											</div>
											
										</div>
										</div>
										<div class="add-button col-md-12">
											<button type="button" id="addModule" class="btn btn-info btn-fill"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Module</button>
										</div>
										<button type="submit" class="btn btn-info btn-fill pull-right">Create Batch</button>
									</form>
								</div>
							</div>


						</div>
					</div>
				</div>
            </div>
        </div>
        <script type="text/javascript">
        $(function(){
        		// validation start
        			$('#batch_form').validate({
        				rules :{

        				}
        			});

        		// validation end
        		getAllfacultis();
        		$('#faculties').change(function(){
        			var id=$(this).val();
        			getAllCourse(id); 
                });

                $('#courses').change(function(){
                	var id=$(this).val();
					getAllModules(id);
                });

                $('#addModule').click(function(){
                	var htmlString='<div class="row">';
						htmlString+='<div class="col-md-6 col-xs-12">';
						htmlString+='<div class="col-md-12">';
						htmlString+='<div class="form-group">';
						htmlString+='<label>Select Module</label>';
						htmlString+='<select class="form-control modules" name="modules[]" id="';
						htmlString+='modules"></select></div></div></div>';
						htmlString+='<div class="col-md-6 col-xs-12">';
						htmlString+='<div class="col-md-6">';
						htmlString+='<div class="form-group">';
						htmlString+='<label for="studentid">Start Date</label>';
						htmlString+='<input type="date" required name="module_start[]" class="';htmlString+='form-control" placeholder="Select a Date"></div></div>';
						
						htmlString+='<div class="col-md-6">';
						htmlString+='<div class="form-group">';
						htmlString+='<label for="studentid">End Date</label>';
						htmlString+='<input type="date" required name="module_end[]" class="form-control" placeholder="Select a Date"></div></div></div></div>';
                	$('#module_container').append(htmlString);

                	var id=$('#courses').val();
						$.ajax({
	                    type: "GET",
	                    url: '/get/'+id+'/modules',
	                    success: function(data) {
	                        var htmlString="<option value='"+''+"'>Please Select One</option>";
	                        $.each(data, function (item, obj) {
	                                htmlString+="<option value='"+obj.module_id+"'>"+obj.module_name+"</option>";
	                             
	                    });

	                    $('.modules').last().html("");
	                    
	                    $('.modules').last().append(htmlString);
	                        
	                	}
	    			})
                });

                $('.delete').on('click',function(){
                	$(this).closest('.row').remove()
                });
                        
        	});
        	 function getAllCourse(id){
                $.ajax({
                    type: "GET",
                    url: '/get/'+id+'/courses',
                    success: function(data) {
                        var htmlString="<option value='"+''+"'>Please Select One</option>";
                        $.each(data, function (item, obj) {
                                htmlString+="<option value='"+obj.course_id+"'>"+obj.course_name+"</option>";
                             
                    });

                    $('#courses').html("");
                        
                    $('#courses').append(htmlString);
                        
                }
    })
            }
            function getAllModules(id){
                $.ajax({
                    type: "GET",
                    url: '/get/'+id+'/modules',
                    success: function(data) {
                        var htmlString="<option value='"+''+"'>Please Select One</option>";
                        $.each(data, function (item, obj) {
                                htmlString+="<option value='"+obj.module_id+"'>"+obj.module_name+"</option>";
                             
                    });

                    $('.modules').html("");
                    
                    $('.modules').append(htmlString);
                        
                }
    })
            }

             function getAllfacultis(){
                $.ajax({
                    type: "GET",
                    url: '/get/faculties',
                    success: function(data) {
                        var htmlString="<option value='"+''+"'>Please Select One</option>";
                        $.each(data, function (item, obj) {
                                htmlString+="<option value='"+obj.faculty_id+"'>"+obj.faculty_name+"</option>";
                             
                    });
                    
                    $('#faculties').append(htmlString);


                }
    })
            }
        </script>
@endsection