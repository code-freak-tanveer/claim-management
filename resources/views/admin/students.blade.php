@extends('layouts.main')
@section('heading')
               <a class="navbar-brand" id="navbar" href="#">Studnts</a>
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
                                       
                                    <div id="latest" >
                                         <table class="table table-hover" id="latest_claim">
                                            
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

<script type="text/javascript">
$(function(){
    getClaims();
});
    
function getClaims(){
    $.ajax({
        type:'GET',
        url:'/admin/students',
        success: function(data){
            loadWithData(data,"Latest");
        }
    });
   
  
}

function loadWithData(data,table){
    var role='@if(Auth::guard("admin")->user()->type_id==1){{"ecman"}}@else {{"other"}}@endif';
    var htmlStr="<thead>";
    htmlStr+="<th>Student ID</th>";
    htmlStr+="<th>Student Name</th>";
    htmlStr+="<th>Faculty</th>";
    htmlStr+="<th>Course</th>";
    htmlStr+="<th>Batch</th>";
    htmlStr+="<th>Contact</th>";
    htmlStr+="<th>Go Details</th>";
  
    
    htmlStr+="</thead><tbody>";

    $.each(data,function(x,claim){
        htmlStr+="<tr><td>"+claim.student_id+"</td>";
        htmlStr+="<td>"+claim.student_name+"</td>";   
        htmlStr+="<td>"+claim.faculty_name+"</td>";   
        htmlStr+="<td>"+claim.course_name+"</td>";   
        htmlStr+="<td >"+claim.batch_title+"</td>";   
        htmlStr+="<td><span class=\"success\">"+claim.contact+"</span></td>";

        htmlStr+="<td><a target=\"blank\" href=\"http://localhost:8000/profile/"+claim.student_id+"\">details</a></td>";
       
        htmlStr+="</tr>";

    });
    
    if(table=="Latest"){
        $("#latest_claim").html("");
        $("#latest_claim").append(htmlStr+"</tbody>");  
    }
   
  
 }

</script>  

@endsection
<!--        Modal-->
        
<!--        End Modal-->
