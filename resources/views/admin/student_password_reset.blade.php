@extends('layouts.main')
@section('heading')
	<h4 class="title">Student Password Reset</h4>
@endsection
@section('body')
	<div class="pass-reset-form col-md-6 col-xs-12">
		@if (Session::has('message'))
		   <div class="alert alert-info">{{ Session::get('message') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		   </div>
		@endif
		<form method="post" action="/admin/update/reset_password/student" id="reset_form">
		{{csrf_field()}}
			<div class="col-md-12">
				<div class="form-group">
					<label for="studentid">Student ID</label>
					<input type="text" required name="id" id="id" class="form-control" placeholder="Student ID">
				</div>
				<div class="form-group">
					<label for="studentid">New Password</label>
					<input type="password" class="form-control" placeholder="Password" name="password" id="password">
				</div>
				<div class="form-group">
					<label for="studentid">Confirm Password</label>
					<input type="password" class="form-control" name="password_again" id="password_again" placeholder="Confirm Password">
				</div>
				<button type="submit" class="btn btn-info btn-fill pull-left">Submit</button>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		$('#reset_form').validate({
		    rules : {
		        password: {
		        	required: true,
      				minlength: 6
		        },
			    password_again: {
			      equalTo: "#password"
			    }
		    },
		    messages :{
		    	 password_again: {
			      equalTo: "Password doesn't match"
			    }
		    }

		});
	</script>
@endsection

