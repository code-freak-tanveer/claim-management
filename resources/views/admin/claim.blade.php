@extends('layouts.main')
@section('heading')
               <a class="navbar-brand" href="#">View Claims</a>
@endsection

@section('body')
<div class="content">
            <div class="container-fluid">
				<div class="card">
				    <div class="content">
						<div class="row"> 
							<div class="col-md-12">
								<div class="card card-plain">
									<div class="filtering">
                                        <span class="title"><strong>Filter:</strong></span>
                                        <span class="input-filter"><input type="text" id="module" name="module" class="by_module form-control" placeholder="By Module" ></span>
                                        <span class="input-filter"><input type="text" class="by_type form-control" placeholder="By Assesment Type" ></span>
                                        <span class="input-filter"><input type="text" class="by_action form-control" placeholder="By Action" ></span>
                                        <span class="button"><button type="submit" class="btn btn-info btn-fill">Filter</button></span>
                                    </div>
									<div class="content table-responsive table-full-width">
									<ul class="nav nav-tabs">
                                        <li class="tab"><a href="#all" data-toggle="tab" >All Claims</a></li>
                                        <li class="tab active"><a href="#latest" data-toggle="tab" >Latest</a></li>
                                        
                                        <li class="tab"><a href="#pending" data-toggle="tab">Pending</a></li>
                                        <li class="tab"><a href="#approved" data-toggle="tab">Approved</a></li>
                                        <li class="tab"><a href="#overdued" data-toggle="tab">Overdued</a></li>
                                        <li class="tab"><a href="#nonevidence" data-toggle="tab">No Evidence</a></li>
                                    </ul>
                                        <div class="tab-content">
                                            <div id="all" class="tab-pane fade">
                                                 <table class="table table-hover" id="all_claim">
                                                    
                                                 </table>
                                                
                                            </div>
                                            <div id="latest" class="tab-pane fade">
                                                 <table class="table table-hover" id="latest_claim">
                                                    
                                                 </table>
                                                
                                            </div>
                          
                                        <div id="pending" class="tab-pane fade">
										<table class="table table-hover" id="pending_claim">
											
										</table>
                                        </div>
                                        <div id="approved" class="tab-pane fade">
										<table class="table table-hover" id="approved_claim">
											
										</table>
                                        </div>
                                        <div id="overdued" class="tab-pane fade">
                                        <table class="table table-hover" id="overdued_claim">
                                            
                                        </table>
                                        </div>
                                         <div id="nonevidence" class="tab-pane fade">
                                        <table class="table table-hover" id="no-evidence">
                                            
                                        </table>
                                        
                                        </div>
                                        </div>
									</div>
								</div>
							</div>


						</div>
					</div>
				</div>
            </div>
        </div>

<script type="text/javascript">
$(function(){
    getClaims();
});
    
function getClaims(){
     $.ajax({
        type:'GET',
        url:'claim/all',
        success: function(data){
            loadWithData(data,"all");
        }
    });
    $.ajax({
        type:'GET',
        url:'claim/latest',
        success: function(data){
            loadWithData(data,"Latest");
        }
    });
    
    $.ajax({
        type:'GET',
        url:'claim/pending',
        success: function(data){
            loadWithData(data,"Pending");
        }
    });
    $.ajax({
        type:'GET',
        url:'claim/approved',
        success: function(data){
            loadWithData(data,"Approved");
        }
    });

     $.ajax({
        type:'GET',
        url:'claim/no-evidence',
        success: function(data){
            loadWithData(data,"no-evidence");
        }
    });
     $.ajax({
        type:'GET',
        url:'claim/overdued',
        success: function(data){
            loadWithData(data,"overdued_claim");
        }
    });
    
    
}

function loadWithData(data,table){
    var role='@if(Auth::guard("admin")->user()->type_id==1){{"ecman"}}@else {{"other"}}@endif';
    var htmlStr="<thead>";
    htmlStr+="<th>Student Name</th>";
    htmlStr+="<th>Subject</th>";
    htmlStr+="<th>EC Type</th>";
    htmlStr+="<th>Summary</th>";
    htmlStr+="<th>Submitted Date</th>";
    htmlStr+="<th>Status</th>";
    htmlStr+="<th>Go Details</th>";
  
     
    
    
    htmlStr+="</thead><tbody>";

    $.each(data,function(x,claim){
        htmlStr+="<tr><td>"+claim.student_name+"</td>";
        htmlStr+="<td>"+claim.module_name+"</td>";   
        htmlStr+="<td>"+claim.assessment_type+"</td>";   
        htmlStr+="<td>"+claim.claim_details+"</td>";   
        htmlStr+="<td >"+claim.submission_date+"</td>";   
        htmlStr+="<td><span class=\"success\">"+claim.status+"</span></td>";

        htmlStr+="<td><a target=\"blank\" href=\"claim/"+claim.claim_id+"/details\">details</a></td>";
       
        htmlStr+="</tr>";

    });
    
    if(table=="Latest"){
        $("#latest_claim").html("");
        $("#latest_claim").append(htmlStr+"</tbody>");  
    }
    else if(table=="Pending"){
        $("#pending_claim").html("");
        $("#pending_claim").append(htmlStr+"</tbody>"); 
    }
    else if(table=="Approved"){
        $("#approved_claim").html("");
        $("#approved_claim").append(htmlStr+"</tbody>");
    }
    else if(table=="no-evidence"){
        $("#no-evidence").html("");
        $("#no-evidence").append(htmlStr+"</tbody>"); 
    }
    else if(table=="overdued_claim"){
        $("#overdued_claim").html("");
        $("#overdued_claim").append(htmlStr+"</tbody>"); 
    }
    else if(table=="all"){
        $("#all_claim").html("");
        $("#all_claim").append(htmlStr+"</tbody>"); 
    }
  
 }

</script>  

@endsection
<!--        Modal-->
        
<!--        End Modal-->