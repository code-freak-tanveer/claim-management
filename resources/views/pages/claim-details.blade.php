@extends('layouts.main')

@section('heading')
 <a class="navbar-brand" href="#">View Claim</a>
@endsection

@section('body')

<div class="content">
            <div class="container-fluid">
				<div class="card">
				    <div class="content">
						<div class="row"> 
							<div class="col-md-12">
								<div class="card card-plain">

								@foreach($claims as $claim)
									<div class="header">

										<h4 class="highlight-title">Claim ID: <strong>{{$claim->claim_id}}</strong></h4>
										@if (Session::has('message'))
											   <div class="alert alert-info">{{ Session::get('message') }}
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												  <span aria-hidden="true">&times;</span>
												</button>
											   </div>
											@endif
									
									</div>
									<div class="content claim-details">
										<table class="information">
										
											<tr>
												<td>Student ID</td>
												<td>{{$claim->student_id}}</td>
											</tr>
											<tr>
												<td>Student Name</td>
												<td>{{$claim->student_name}}</td>
											</tr>
											<tr>
												<td>Faculty</td>
												<td>{{$claim->faculty_name}}</td>
											</tr>
											<tr>
												<td>Course</td>
												<td>{{$claim->course_name}}</td>
											</tr>
											<tr>
												<td>Module</td>
												<td>{{$claim->module_name}}</td>
											</tr>
											<tr>
												<td>Assesment Type</td>
												<td>{{$claim->assessment_type}}</td>
											</tr>
											<tr>
												<td>Extenuating Circumstances TYPE</td>
												<td>{{$claim->claim_type}}</td>
											</tr>
											<tr>
												<td>Claim Details</td>
												<td>{{$claim->claim_details}}</td>
											</tr>
											<tr>
												<?php 
													$datediff=strtotime(date('Y-m-d'))-strtotime($claim->submission_date);
												?>
												<td>Submitted Date</td>
												<td>{{$claim->submission_date}}
													 @if($datediff>(14*3600*24))
			                                         	<span class="label label-danger">Over Due</span>
			                                         @endif
												</td>
											</tr>
											<tr>
												<td>Action</td>
												<td><span class="success">{{$claim->status}}</span></td>
											</tr>
											<tr>
												<td>Action Details</td>
												<td>{{$claim->comments}}</td>
											</tr>
											@php ($i=1)
											@foreach($evidences as $evidence)

											<tr>
												<td>Evidence {{$i++}}</td>
												
												<td>
													<?php 
														$fileType = substr($evidence->evidence_file, -3);

													?>
													@if($fileType=='pdf')
														<a href="/uploaded_file/{{$evidence->evidence_file}}" target="_blank">View Evidence File as {{$fileType}}</a>
													@else
													<a class="iframe" href="/uploaded_file/{{$evidence->evidence_file}}" data-lightbox="image-1" data-title="{{$evidence->details}}">View Evidence File</a>
													@endif
													<p><strong>Evidence Details:</strong>{{$evidence->details}}</p>
												</td>
												
											</tr>	
											@endforeach										
										</table>
										
										@if(Auth::guard('admin')->check())
											

											@if((Auth::guard('admin')->user()->type_id==1) &&  ($claim->status=="Pending" && $datediff<(14*3600*24)))
											
										
	                                        <div class="action col-md-12 ">
	                                            <form method="post" action="{{URL::asset('admin/claim/action')}}">
	                                            {{csrf_field()}}
	                                                <p class="title">Action:</p>
	                                                <div class="col-md-12">
	                                                    <div class="form-group">
	                                                        <label>Action Details</label>
	                                                        <textarea rows="5" class="form-control" name="comments" placeholder="Write the details about action" value="" ></textarea>
	                                                    </div>
	                                                    <div class="radio">
														  <label><input type="radio" name="action" value="Rejected" >Reject</label>
														</div>
														<div class="radio">
														  <label><input type="radio" name="action" value="Approved" >Upheld</label>
														</div>
														
														</div>
	                                                </div>
	                                                <div class="col-md-12 action_buttons">
	                                                    <span class="button">
	                                                    	<input type="hidden" name="claim_id" value="{{$claim->claim_id}}" >
	                                                    	<input type="submit" name="submit" value="submit" />
														</span>
	                                                   
	                                                </div>
	                                            </form>
	                                        </div>
			                                        
	                                   		@endif
                                   					
                                   		@endif	
                                   		@endforeach							
									</div>
								</div>
							</div>


						</div>
					</div>
				</div>
            </div>
        </div>
@endsection