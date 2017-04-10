@extends('layouts.main')
           @section('heading')
               <a class="navbar-brand" href="#">Edit Claim</a>
           @endsection
         
            @section('body')

             <div class="content">
            <div class="container-fluid">
				<div class="card">
				    <div class="content">
						<div class="row"> 
							<div class="col-md-12">
								<form method="post"  id="claim_form" action="/claim/update" enctype="multipart/form-data">
									{{csrf_field()}}
									<input type="hidden" name="claim_id" value="{{$claim->claim_id}}">
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
												<input type="text" disabled class="form-control" value="{{Auth::user()->email}}">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>Module Name</label>
												<select class="form-control" required name="course" id="courseList">
													
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
													<option value="Illness/Hospitalisation"  @if($claim->claim_type=='Illness/Hospitalisation') {{"selected"}} @endif>Illness/Hospitalisation</option>
													<option value="Family illness" @if($claim->claim_type=='Family illness') {{"selected"}} @endif>Family illness</option>
													<option value="Bereavement" @if($claim->claim_type=='Bereavement') {{"selected"}} @endif>Bereavement</option>
													<option value="Acute emotional/personal circumstances" @if($claim->claim_type=='Acute emotional/personal circumstances') {{"selected"}} @endif>Acute emotional/personal circumstances</option>
													<option value="Victim of crime" @if($claim->claim_type=='Victim of crime') {{"selected"}} @endif>Victim of crime</option>
													<option value="Domestic disruption" @if($claim->claim_type=='Domestic disruption') {{"selected"}} @endif>Domestic disruption</option>
													<option value="Involvement in event" @if($claim->claim_type=='Involvement in event') {{"selected"}} @endif>Involvement in event</option>
													<option value="Jury Service/Court Attendance" @if($claim->claim_type=='Jury Service/Court Attendance') {{"selected"}} @endif>Jury Service/Court Attendance</option>
													<option value="Others">Others</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Claim Details</label>
												<textarea rows="5" required minlength="20" id="claim_details" name="claim_details" class="form-control" placeholder="Write in Details about your Claim"></textarea>
												<script type="text/javascript">
													$('#claim_details').val('{{$claim->claim_details}}');
												</script>
											</div>
										</div>
									</div>
									<div id="evidence_container">


                                       @foreach($claim->evidences as $evidence)
                                       	<div class="row" >
									       <div class="col-md-1">
                                             <div class="form-group">
                                                    <label>Action</label>
                                                    <input  type="Button" value="x" id="remove" class="btn btn-danger"/>
                                            </div> 
										</div>
										<div class="col-md-4">
                                       		 <div class="form-group">
                                                <label>Previous file</label>
                                                <input type="hidden" name="wasuploaded[]" class="form-control" value="{{$evidence->evidence_file}}">
                                        	</div> 
                                        <a class="iframe" href="/uploaded_file/{{$evidence->evidence_file}}" data-lightbox="image-1" data-title="{{$evidence->details}}">View Evidence File</a>
                                                
                                            
								        </div>
								
										<div class="col-md-7">
											<div class="form-group">
												<label>Evidence Detais</label>
												<textarea rows="4" name="previous_evidence_details[]" id="details" class="form-control" placeholder="Write in Details about your Evidence"></textarea>
												<script type="text/javascript">
													$('#details').val('{{$evidence->details}}');
												</script>
											</div>
											
										</div>
									   </div>
									   @endforeach
									   <div class="row" >
									       <div class="col-md-1">
                                             <div class="form-group">
                                                    <label>Action</label>
                                                    <input disabled type="Button" value="x"  class="btn btn-danger"/>
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
									<input type="button" class="btn btn-success" id="addMore" value="Add evidence +"/>
									<button type="submit"  class="btn btn-info btn-fill pull-right">Submit Claim</button> 
									
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

                    $('#evidence_container').on('click','#remove',function(e){
                        $(this).closest('.row').remove();
                	});

                	// validation
                		$('#claim_form').validate({
						    rules : {
						        claim_details : { required : true }
						    }

						});
                	// end validation
                });
            function loadFileUploader(){
                var htmlStr='';
                htmlStr+='<div class="row">';
                htmlStr+='<div class="col-md-1">';
                htmlStr+='<div class="form-group">';
                htmlStr+='<label>Action</label>';
                htmlStr+='<input id="remove" type="Button" value="x" class="btn btn-danger"/></div></div>';
               
                htmlStr+='<div class="col-md-4">';
                htmlStr+='<div class="form-group">';
                htmlStr+='<label>Upload Evidence</label>';
                htmlStr+='<input type="file"  class="btn btn-default" name="fileToUpload[]" id="fileToUpload"></div></div>';
                htmlStr+='<div class="col-md-7">';
                htmlStr+='<label>Evidence Detais</label>';
                htmlStr+=' <textarea rows="4" name="evidence_details[]" class="form-control" placeholder="Write in Details about your Evidence"></textarea></div></div></div> ';
                $('#evidence_container').append(htmlStr);
                
               
                
            }
            function getAllCourse(){
                $.ajax({
                    type: "GET",
                    url: '/{{Auth::user()->batch_id}}/modules',
                    success: function(data) {
                    	var course_id='{{$claim->assessments->modules->module_id}}';
                        var htmlString="<option value='"+''+"'>Please Select One</option>";
                        var selectState='';
                        $.each(data, function (item, obj) {
                        	if(course_id==obj.module_id){
								selectState='selected';

								getAssessments(course_id);
                        	}else{
                        		selectState='';
                        	}
                            htmlString+="<option value='"+obj.module_id+"' "+selectState+">"+obj.module_name+"</option>";
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
                        	var assessment_id='{{$claim->assessments->assessment_id}}';
                           var htmlStr="<option value='"+''+"'>Please Select One</option>";
                            var selectState='';
                           $.each(data,function(x,assessment){

                           	if(assessment_id==assessment.assessment_id){
								selectState='selected';
                        	}else{
                        		selectState='';
                        	}
                               htmlStr+="<option  value='"+assessment.assessment_id+"' "+selectState+">"+assessment.assessment_type+"</option>"
                           });
                            console.log(htmlStr);
                            $('#assessmentList').append(htmlStr);
                        }
                    });
                }
           
        </script>
    
@endsection