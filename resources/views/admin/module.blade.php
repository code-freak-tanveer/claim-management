@extends('layouts.main')
@section('heading')
       <a class="navbar-brand" href="#">Module</a>
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
										<h4 class="title">Create new Module</h4>
									</div>
									@if (Session::has('message'))
									   <div class="alert alert-info">{{ Session::get('message') }}
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									   </div>
									@endif
									<form method="post" action="add/module" id="module_form">
									{{csrf_field()}}
										<div class="row">
											<div class="col-md-12">
												<div class="col-md-4">
													<div class="form-group">
														<label for="studentid">Module Name</label>
														<input type="text" required minlength="5" name="module_name" class="form-control" placeholder="Module Name">
													</div>
													<div class="form-group" id="checkboxes">
														<label for="studentid">Select Assesments</label><br>
														<input type="checkbox" class="form-control" name="assessment[]" value="assignment" checked><span class="checkbox-text">Assignment</span><br>
														<input type="checkbox" class="form-control" name="assessment[]" value="exam" ><span class="checkbox-text">Exam</span><br>
														<input type="checkbox" class="form-control" name="assessment[]" value="class-test"><span class="checkbox-text">Class Test</span><br>
														<input type="checkbox" class="form-control" name="assessment[]" value="project"><span class="checkbox-text">Project</span><br>																										
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Select Faculty</label>
														<select class="form-control" required name="faculties" id="faculties">
															<!-- Javscript -->
														</select>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Select Course</label>
														<select class="form-control" required name="courses" id="courses">
															<!-- Javascript -->
														</select>
													</div>
												</div>
											</div>
										</div>	
										<div class="add-button col-md-12">
											<button type="submit" class="btn btn-info btn-fill pull-left">Create Module</button>
										</div>										
									</form>
									<div class="empty-space"></div>
									<div class="header">
										<h4 class="title">All Modules</h4>
									</div>
									<div class="content table-responsive table-full-width">
										<table class="table table-hover">
											<thead>
												<th>Module Name</th>
												<th>Faculty</th>
												<th>Course</th>
												<th>Assesment</th>
											</thead>
											<tbody id="module_list">
												<!-- javascript -->
												
											</tbody>
										</table>
									</div>
								</div>
							</div>


						</div>
					</div>
				</div>
            </div>
        </div>

        <script type="text/javascript">

        	function getAllmoduleList(){
        		$.ajax({
        			type:'GET',
        			url:'/get/modules',
        			success: function(data){
        			

        				 var htmlString="";
        				 var assessmentString="";
        				
                       	 $.each(data, function (item, obj) {
                       	 	$.each(obj.assessments,function(i,assessment){
                       	 		assessmentString+=assessment.assessment_type+', ';
                       	 	});
                       	 	console.log(obj);
                            htmlString+='<tr>';
							htmlString+='<td>'+obj.module_name+'</td>';
							htmlString+='<td>'+obj.courses[0].faculties.faculty_name+'</td>';
							htmlString+='<td>'+obj.courses[0].course_name+'</td>';
							htmlString+='<td>'+assessmentString+'</td></tr>';
							assessmentString="";	
        			});
                       	 $('#module_list').html("");
                       	 $('#module_list').append(htmlString);
                   }
        		})
        	}

        	$(function(){
        		getAllfacultis();
        		$('#faculties').change(function(){
        			var id=$(this).val();
        			getAllCourse(id);
                });

                getAllmoduleList();
                // validation start
                	$('#module_form').validate({
                		rules : {
                			'assessment[]' :{
                				required:true
                			}
                		},
                		messages :{
                			'assessment[]' :{
                				required:'Select At least One Assesment'
                			}
                		},
				        errorPlacement: function(error, element) {
					        if ($("#checkboxes").has(element).size() > 0) {
					            error.insertAfter($("#checkboxes"));
					        } else {
					            error.insertAfter(element);
					        }
					    }
                	});
                // validation end
                        
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

             function getAllfacultis(){
                $.ajax({
                    type: "GET",
                    url: 'http://localhost:8000/get/faculties',
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