<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>All Claims</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

     <!-- Bootstrap core CSS     -->
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/lightbox.css')}}">
    <link href="{{URL::asset('css/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="{{URL::asset('css/animate.min.css')}}" rel="stylesheet" />
    <!-- Validator css -->
    <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">

    <!--  Light Bootstrap Table core CSS    -->
    <link href="{{URL::asset('css/light-bootstrap-dashboard.css')}}" rel="stylesheet" />
    


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="{{URL::asset('css/demo.css')}}" rel="stylesheet" />

   
    


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="{{URL::asset('css/pe-icon-7-stroke.css')}}" rel="stylesheet" />

    
    <script src="{{URL::asset('js/jquery-1.10.2.js')}}" type="text/javascript"></script>
	<script src="{{URL::asset('js/bootstrap.min.js')}}" type="text/javascript"></script>


	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="{{URL::asset('js/bootstrap-checkbox-radio-switch.js')}}"></script>

	<!--  Charts Plugin -->
	<script src="{{URL::asset('js/chartist.min.js')}}"></script>

    <!--  Notifications Plugin    -->
    <script src="{{URL::asset('js/bootstrap-notify.js')}}"></script>

    <!--  Google Maps Plugin    -->
    <script type="javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js" ></script>
    


    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="{{URL::asset('js/light-bootstrap-dashboard.js')}}"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
    <script src="{{URL::asset('js/demo.js')}}"></script>
	<script src="{{URL::asset('js/canvasjs.min.js')}}"></script>
  
   
    
</head>
<body>
 <?php $management=5; $type=''; $userName=''; ?>

           @if(Auth::guard('web')->check()) 
                <?php $management=0;
                    $userName=Auth::guard('web')->user()->student_name;
                    $type="student";
                ?>
           @elseif(Auth::guard('admin')->check()) 
                <?php $management=1;
                    $user=Auth::guard('admin')->user();
                    $userName=$user->name;
                    if($user->type_id==2){
                        $type='admin';
                    }else if($user->type_id==3){
                         $type='EC Manager';
                    }else{
                        $type='EC Coordinator';
                    }

                ?>
           @endif
<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="{{URL::asset('img/sidebar-5.jpg')}}">
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="/" class="simple-text">
					<span class="profile_pic"><img src="{{URL::asset('img/new_logo.png')}}" alt="Name" width="50px" height="50px"></span>
                    <span class="profile_name">{{$userName}}</span>
                    <span class="user_type">{{$type}}</span>
                </a>
            </div>

           <!--  @yield('menu') -->

   
           <ul class="nav">
          @if($type=='EC Manager')
                {!!'<li>
                    <a href="http://localhost:8000/admin/dashboard" class="active">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="http://localhost:8000/admin/viewClaims">
                        <i class="fa fa-file-text-o"></i>
                        <p>All Claim</p>
                    </a>                    
                </li>
                <li>
                    <a href="http://localhost:8000/admin/view/students">
                        <i class="fa fa-users"></i>
                        <p>All Students</p>
                    </a>
                </li>'!!}

           @endif
           @if($type=='EC Coordinator')
                {!!'<li>
                    <a href="http://localhost:8000/admin/viewClaims">
                        <i class="fa fa-file-text-o"></i>
                        <p>All Claim</p>
                    </a>                    
                </li>
                <li>
                    <a href="http://localhost:8000/admin/view/students">
                        <i class="fa fa-users"></i>
                        <p>All Students</p>
                    </a>
                </li>'!!}
           @endif
           @if($type=='admin')
                {!!'<li>
                    <a href="http://localhost:8000/admin/dashboard" class="active">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="http://localhost:8000/admin/viewClaims">
                        <i class="fa fa-file-text-o"></i>
                        <p>All Claim</p>
                    </a>                    
                </li>
                <li>
                    <a href="http://localhost:8000/admin/view/students">
                        <i class="fa fa-users"></i>
                        <p>All Students</p>
                    </a>
                </li>'!!}
                <li>
                    <a href="#">
                        <i class="fa fa-check-square-o"></i>
                        <p>Manage Course </p>
                    </a>
                    <ul class="sub-nav">
                        <li>
                            <a href="http://localhost:8000/admin/view/batch">
                                <i class="fa fa-male"></i>
                                <p>Manage Batch </p>
                            </a>
                        </li>
                        <li>
                            <a href="http://localhost:8000/admin/view/module">
                                <i class="fa fa-user"></i>
                                <p>Manage Module</p>
                            </a>
                        </li>
                    </ul>
                </li>
           @endif
           @if($type=='student')
                <li>
                    <a href="http://localhost:8000/allClaimsByStudent/{{Auth::guard('web')->user()->student_id}}">
                        <i class="fa fa-list"></i>
                        <p>All Claims</p>
                    </a>
                </li> 
                <li>
                    <a href="http://localhost:8000/form/create/claim">
                        <i class="fa fa-plus"></i>
                        <p>Create Claim</p>
                    </a>
                </li>     

           @endif 
                
                
                <li>
                    <a href="#">
                        <i class="pe-7s-bell"></i>
                        <p>Notifications</p>
                    </a>
                </li>               
            </ul>
           <!-- End menu -->
    	</div>
    </div>

    <div class="main-panel">
		<nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    @yield('heading')
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-dashboard"></i>
								<p class="hidden-lg hidden-md">Dashboard</p>
                            </a>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-globe"></i>
                                    <b class="caret hidden-sm hidden-xs"></b>
                                    <span class="notification hidden-sm hidden-xs">5</span>
									<p class="hidden-lg hidden-md">
										5 Notifications
										<b class="caret"></b>
									</p>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Notification 1</a></li>
                                <li><a href="#">Notification 2</a></li>
                                <li><a href="#">Notification 3</a></li>
                                <li><a href="#">Notification 4</a></li>
                                <li><a href="#">Another notification</a></li>
                              </ul>
                        </li>
                        <li>
                           <a href="">
                                <i class="fa fa-search"></i>
								<p class="hidden-lg hidden-md">Search</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            @if($management==1)
                                <a href="{{URL::asset('admin/logout')}}">
                            @else
                                <a href="{{URL::asset('logout')}}">
                            @endif
                                <p>Log out</p>
                            </a>
                        </li>
						<li class="separator hidden-lg hidden-md"></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content">
            <div class="container-fluid">
				<div class="card">
				    <div class="content">
						<div class="row"> 
							<div class="col-md-12">
								<div class="card card-plain">
									<div class="header">
										
									</div>
									<div class="content table-responsive table-full-width">
										@yield('body')
									</div>
								</div>
							</div>


						</div>
					</div>
				</div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">                
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> EWSD Assignment
                </p>
            </div>
        </footer>


    </div>
</div>
<script type="text/javascript" src="{{URL::asset('js/lightbox.js')}}"></script>

@yield('modal')
</body>

     <!--   Core JS Files   -->

</html>