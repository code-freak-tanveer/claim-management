@extends('layouts.main')

@section('heading')
	 <a class="navbar-brand" href="#">Profile</a>
@endsection

@section('body')


<div class="content">
            <div class="container-fluid">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="header">
									<h4 class="title">Academic Information</h4>
								</div>
								<div class="content">
									<table class="information">
										<tr>
											<td>Name</td>
											<td>{{$student->student_name}}</td>
										</tr>
										<tr>
											<td>Student ID</td>
											<td>{{$student->student_id}}</td>
										</tr>
										<tr>
											<td>Batch</td>
											<td>{{$student->batch_title}}</td>
										</tr>
										<tr>
											<td>Course Name</td>
											<td>{{$student->course_name}}</td>
										</tr>
										<tr>
											<td>Faculty</td>
											<td>{{$student->faculty_name}}</td>
										</tr>
										<tr>
											<td>Date of Birth</td>
											<td>11/11/1993</td>
										</tr>
										
										<tr>
											<td>Email</td>
											<td>{{$student->email}}</td>
										</tr>
										<tr>
											<td>Contact Number</td>
											<td>{{$student->contact}}</td>
										</tr>
										<tr>
											<td>Student Type</td>
											<td><span class="success">Regular</span></td>
										</tr>																			
									</table>									
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="header">
									<h4 class="title">Other Information</h4>
								</div>
								<div class="content">
									<table class="information">
										<tr>
											<td>Father's Name</td>
											<td>MD. Ruhul Amin</td>
										</tr>
										<tr>
											<td>Mother's Name</td>
											<td>Hasna Hena</td>
										</tr>
										<tr>
											<td>Guardian's Contact Number</td>
											<td>+8801672847723</td>
										</tr>
										<tr>
											<td>Address</td>
											<td>455/1, Manikdee, Dhaka 1206</td>
										</tr>
										<tr>
											<td>Zip Code</td>
											<td>1216</td>
										</tr>
										<tr>
											<td>City</td>
											<td>Dhaka</td>
										</tr>
										<tr>
											<td>Blood Group</td>
											<td>O+</td>
										</tr>																												
									</table>
								</div>
							</div>
						</div>   
					</div>
				</div>
                
				<div class="col-md-4">
					<div class="card card-user">
						<div class="content">
							<div class="profile-pic center">
								 <a href="#">
								<img class="avatar border-gray" src="{{URL::asset('img/new_logo.png')}}" alt="..."/>

								  <h4 class="title">{{$student->student_name}}<br />
									 <small>{{$student->email}}</small>
								  </h4>
								</a>
							</div>
							<p class="description text-center"> "Life is Beautiful <br>
												If you change your way of thinking <br>
												and Forgive Everything"
							</p>
						</div>
						<hr>
						<div class="text-center">
							<button href="#" class="btn btn-simple"><i class="fa fa-facebook-square"></i></button>
							<button href="#" class="btn btn-simple"><i class="fa fa-twitter"></i></button>
							<button href="#" class="btn btn-simple"><i class="fa fa-google-plus-square"></i></button>

						</div>
					</div>
				</div>               
				
            </div>
        </div>
@endsection