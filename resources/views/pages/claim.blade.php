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
									<div class="header">
										<div class="title">
											<p class="categiry">
												All Claims Submitted by
												<strong>{{Auth::user()->student_name}}</strong>
											</p>
											@if (Session::has('message'))
											   <div class="alert alert-info">{{ Session::get('message') }}
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												  <span aria-hidden="true">&times;</span>
												</button>
											   </div>
											@endif
										</div>
									</div>
									
									<div class="content table-responsive table-full-width">
										<table class="table table-hover">
											<thead>
												<th>EC ID</th>
												<th>Course</th>
												
												<th>EC Type</th>
												<th>Submitted Date</th>
												<th>Status</th>
												<th>Details</th>
												<th>Action</th>
											</thead>
											<tbody>
											@foreach ($claims as $claim)
                                                <tr>
													<td>{{$claim->claim_id}}</td>
													<td>{{$claim->module_name}}</td>
												
													<td>{{$claim->claim_type}}</td>
													
													<td>{{$claim->submission_date}}</td>
													<td><span class="success">{{$claim->status}}</span></td>
													<td><a href="/claim/{{$claim->claim_id}}/details" target="blank"><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
													@if($claim->status=='Pending')

														@if(strtotime($claim->module_end) > strtotime(date('Y-m-d')))
															<td><a href="/claim/{{$claim->claim_id}}/edit">Edit</a> |
														
															<a href="#" data-href="/claim/{{$claim->claim_id}}/delete" data-toggle="modal" data-target="#confirm-delete">Delete</a></td>

														@else
															<td><a href="" disabled>Deadline Over</a></td>
														@endif
														

													@else
														<td>None </td>
													@endif
												</tr>
                                            @endforeach
												
												
											</tbody>
										</table>
											{{$claims->links()}}
									</div>
								</div>
							</div>


						</div>
					</div>
				</div>
            </div>
        </div>
        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		            <div class="modal-header">
		               <p>Confirmation</p>
		            </div>
		            <div class="modal-body">
		                <p>Are you sure to delete this claim?</p>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		                <a class="btn btn-danger btn-ok">Delete</a>
		            </div>
		        </div>
		    </div>
		</div>
        <!-- End Modal -->

<script type="text/javascript">
	$('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});
</script>

@endsection