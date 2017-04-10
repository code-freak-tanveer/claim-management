@extends('layouts.main')
           @section('heading')
               <a class="navbar-brand" href="#">Create New Claim</a>
           @endsection
          
            @section('body')
            
             <div class="content">
            <div class="container-fluid">
				<div class="card">
				    <div class="content">
						<div class="row"> 
							<div class="col-md-12">
								<form method="post" id="claim_form" action="/claim/new" enctype="multipart/form-data">
									{{csrf_field()}}
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="studentid">ID</label>
												<input type="text" disabled class="form-control" value="{{Auth::user()->student_id}}">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="name">Full Name</label>
												<input type="text" disabled class="form-control" value="{{Auth::user()->student_name}}">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="email">Email address</label>
												<input type="text" name="email" disabled class="form-control" value="{{Auth::user()->email}}">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>Course Name</label>
												<select class="form-control" name="course" id="courseList">
													
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Assesment Type</label>
												<select class="form-control" required name="assesment" id="assessmentList">
													
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Extenuating Circumstances Type</label>
												<select class="form-control" required name="claim_type">
													<option value="">Please Select One</option>
													<option value="Illness/Hospitalisation">Illness/Hospitalisation</option>
													<option value="Family illness">Family illness</option>
													<option value="Bereavement">Bereavement</option>
													<option value="Acute emotional/personal circumstances">Acute emotional/personal circumstances</option>
													<option value="Victim of crime">Victim of crime</option>
													<option value="Domestic disruption">Domestic disruption</option>
													<option value="Involvement in event">Involvement in event</option>
													<option value="Jury Service/Court Attendance">Jury Service/Court Attendance</option>
													<option value="Others">Others</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Claim Details</label>
												<textarea rows="5" name="claim_details" required minlength="20" class="form-control" placeholder="Write in Details about your Claim"></textarea>
											</div>
										</div>
									</div>
									<div id="evidence_container">
                                       
									   <div class="row" >
									       <div class="col-md-1">
                                             <div class="form-group">
                                                    <label>Action</label>
                                                    <input disabled="true" type="Button" value="--" class="btn btn-default"/>
                                            </div> 
										</div>
										<div class="col-md-4">
                                            <div class="form-group">
                                                <label>Upload Evidence</label>
                                                <input type="file" class="btn btn-default" name="fileToUpload[]" id="fileToUpload">
                                            </div>
								        </div>
								
										<div class="col-md-7">
											<div class="form-group">
												<label>Evidence Detais</label>
												<textarea rows="4" name="evidence_details[]" class="form-control" placeholder="Write in Details about your Evidence"></textarea>
											</div>
											
										</div>
										
										
										
									   </div> 
									    
									</div>
									<input type="button" class="btn btn-success" id="addMore" value="Add More +"/>
									<button type="submit"  class="btn btn-info btn-fill pull-right">Submit Claim</button> 
									
									<div class="row">
										<div class="col-md-12">
											<div class="note">
												<p><strong>Note:</strong> For different extenuating circumstances types, you need to submit spesific evidence. Here is the specifications:</p>
												<ul>
													<li><strong>Illness/Hospitalisation</strong>  (Evidence:  A medical certificate or letter)</li>
													<li><strong>Family illness</strong>  (Evidence:  A medical certificate or letter)</li>
													<li><strong>Bereavement</strong> death of close relative or friend  (Evidence:  Death certificate or supporting letter from an independent source)</li>
													<li><strong>Acute emotional/personal circumstances</strong>  (Evidence: Letter from the University Counselling Service or equivalent and/or medical evidence)</li>
													<li><strong>Victim of crime</strong>  (Evidence:  Crime reference number plus any written evidence available from the police)</li>
													<li><strong>Domestic disruption</strong> (Evidence:  Appropriate letter)</li>
													<li><strong>Representing the University at a national event or involvement in other prestigious  event</strong> (Evidence:  Letter of confirmation from the relevant organising body) </li>
													<li><strong>Jury Service/Court Attendance</strong> (Evidence:  Court or equivalent letter)</li>
													<li><strong>Other</strong> please give details in Section B overleaf and provide supporting documents</li>
												</ul>
											</div>
										</div>
									</div>
									<div class="clearfix"></div>
								</form>
								
							</div>
						</div>
					</div>
				</div>
            </div>
           
        </div>
           
            <script type="text/javascript">
                var counter=1;
                $(function(){ 
	               getAllCourse();
                    
                    $('#addMore').click(function (e){
                        loadFileUploader();
                    });
                    // Form validation start
                    	$('#claim_form').validate({
						    rules : {
						        evidence_details : { evidence : true }
						    }

						});
                    // Form validation end

                });
            function loadFileUploader(){
                var htmlStr='';
                htmlStr+='<div class="row">';
                htmlStr+='<div class="col-md-1">';
                htmlStr+='<div class="form-group">';
                htmlStr+='<label>Action</label>';
                htmlStr+='<input id="remove" type="Button" value="X" class="btn btn-danger"/></div></div>';
               
                htmlStr+='<div class="col-md-4">';
                htmlStr+='<div class="form-group">';
                htmlStr+='<label>Upload Evidence</label>';
                htmlStr+='<input type="file"  class="btn btn-default" name="fileToUpload[]" id="fileToUpload"></div></div>';
                htmlStr+='<div class="col-md-7">';
                htmlStr+='<label>Evidence Detais</label>';
                htmlStr+=' <textarea rows="4" name="evidence_details[]" class="form-control" placeholder="Write in Details about your Evidence"></textarea></div></div></div> ';
                $('#evidence_container').append(htmlStr);
                
                $('#evidence_container').on('click','#remove',function(e){
                        $(this).closest('.row').remove();
                });
                
            }
            function getAllCourse(){
                $.ajax({
                    type: "GET",
                    url: '/{{Auth::guard('web')->user()->batch_id}}/modules',
                    success: function(data) {
                        var htmlString="<option value='"+''+"'>Please Select One</option>";
                        $.each(data, function (item, obj) {
                                htmlString+="<option value='"+obj.module_id+"'>"+obj.module_name+"</option>";
                             
                    });
                        
                    $('#courseList').append(htmlString);
                        
                }
    })
            }
                
                $("#courseList").change(function(){
                    
                    var id=$(this).val();
                   // alert("id"+id);
                    $('#assessmentList').html("");
                    getAssessments(id);
                });
                
                function getAssessments(id){
                    $.ajax({
                        type:"GET",
                        url:"/"+id+"/assessments",
                        success: function(data){
                           var htmlStr="<option value='"+''+"'>Please Select One</option>";
                           $.each(data,function(x,assessment){
                               htmlStr+="<option value='"+assessment.assessment_id+"'>"+assessment.assessment_type+"</option>"
                           });
                            console.log(htmlStr);
                            $('#assessmentList').append(htmlStr);
                        }
                    });
                }
           
        </script>
        <script type="text/javascript">
        $(function(){
        	jQuery.validator.addMethod("evidence", function(value, element) {
   
		  		if (value==''){

		  			return false;
		  		}
		  		return true;
		}, 		'You Must provide a description.');
        });
        	
        </script>
        
    
@endsection