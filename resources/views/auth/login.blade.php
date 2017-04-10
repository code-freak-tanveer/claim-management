@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          
        <div class="login_area">
       
		<div class="form">
		 @if (Session::has('message'))
		   <div class="alert alert-danger">{{ Session::get('message') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		   </div>
		@endif

			<ul class="tab-group">
				<li class="tab active"><a href="#staff">Staff Login</a></li>
				<li class="tab"><a href="#student">Student Login</a></li>
			</ul>
			<div class="tab-content">
				<div id="staff">
					<h1>Staff Login! </h1>
					

					<form action="admin/login" method="post">
					    {{csrf_field()}}
						<div class="field-wrap">						
							<input type="email" value="{{old('email')}}" required autocomplete="off" name="email" placeholder="Username or Email Address" />
						</div>

						<div class="field-wrap">
							<input type="password" name="password" required autocomplete="off"  placeholder="Password" />
						</div>

						<p class="forgot"><a href="#">Forgot Password?</a></p>

						<button type="submit" class="button button-block"/>Log In</button>
					</form>

				</div>

				<div id="student">   
					<h1>Student Login!</h1>
					

					<form action="login_action" method="post">
						<div class="field-wrap">
						<input type="hidden" name="_token" value="{{CSRF_token()}}">						
							<input type="email" value="{{old('email')}}" required autocomplete="off" name="email"  placeholder="Student ID or Username" />
						</div>

						<div class="field-wrap">
							<input type="password" name="password" required autocomplete="off"  placeholder="Password" />
						</div>

						<p class="forgot"><a href="#">Forgot Password?</a></p>

						<button class="button button-block"/>Log In</button>
					</form>
				</div>
			</div><!-- tab-content -->
		</div> <!-- /form -->
	</div>
           
        </div>
    </div>
</div>
@endsection
