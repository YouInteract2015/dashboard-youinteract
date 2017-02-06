<!DOCTYPE html>
<html>
<head>
	<!-- Standard Meta -->
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	<!-- Site Properities -->
	<title>YouInteract :: Portal</title>

	<link rel="stylesheet" type="text/css" href="/css/semantic.min.css">
	<link rel="stylesheet" type="text/css" href="/css/home.css">

	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
	<script src="/js/semantic.min.js"></script>
	<script src="/js/home.js"></script>

</head>



<body id="home">

	<div class="ui inverted menu fixed">
		<a class="{{ (Request::path() == "home" || Request::path() == "") ? "active" : "" }} item" href="/home">
			<i class="home icon" ></i> Home
		</a>
		<a class="{{ Request::path() == "about" ? "active" : "" }} item" href="/about">
			<i class="idea icon"></i> About 
		</a>
		<a class="{{ Request::path() == "help" ? "active" : "" }} item" href="/help">
			<i class="help icon"></i> Help
		</a>
		@if (Auth::check())
		<div class="ui dropdown">
			<a class="item" href="/admin">
					<i class="settings icon"></i> YouInteract Administration
					<i class="dropdown icon"></i>
			</a>
			<div class="menu">

					<div class="item">
							Kinect&copy; <i class="chevron right icon"></i>
							<div class="menu">
									<a class="item" href="/admin/kinect/devices">Devices</a>
									<a class="item" href="/admin/kinect/configs">Configs</a>
									<a class="item" href="/admin/kinect/themes">Themes</a>
									<a class="item" href="/admin/kinect/apps">Apps</a>
									<a class="item" href="/admin/kinect/schedulers">Schedulers</a>
							</div>
					</div>

					<div class="item">
							without Kinect&copy; <i class="chevron right icon"></i>
							<div class="menu">
									<a class="item" href="/admin/generic/devices">Devices</a>
									<a class="item" href="/admin/generic/configs">Configs</a>
									<a class="item" href="/admin/generic/templates">Themes</a>
									<a class="item" href="/admin/generic/items">Ttems</a>
									<a class="item" href="/admin/generic/schedulers">Schedulers</a>
							</div>
					</div>

				<a class="item" href="/admin/settings">Settings</a>
			</div>

		</div>
		@endif

		<!-- menu search -->
		<div class="right menu">
			<!--<div class="item">
				<div class="ui icon input">
					<input type="text" placeholder="Search...">
					<i class="search link icon"></i>
				</div>
			</div>-->
			@if (Auth::guest())
			<a class="item" href="/auth/login">
				<i class="sign in icon"></i> Login
			</a>
			@else
			<div class="ui dropdown item">
				<i class="user icon"></i> {{ Auth::user()->name }} <i class="icon dropdown"></i>
				<div class="menu">
					<a class="item" href="#">Change Password <i class="edit icon"></i></a>
					<a class="item" href="/auth/register">Add User <i class="add user icon"></i></a>
					<a class="item" href="/auth/logout">Logout <i class="sign out icon"></i></a>
				</div>
			</div>
			@endif
		</div>
	</div>


	<div class="ui inverted masthead segment">
		<div class="ui page grid">
			<div class="column">
				<img src="/images/screenshot.png" class="ui medium image">
				<div class="ui transition information">
					<h2 class="ui inverted header">
						YouInteract <i class="chevron circle right icon small"></i>  We code. You choose. They Interact. 
					</h2>
					<p></p> The backoffice of YouInteract solution is a portal specialized in all the configuration of the frontend software YouInteract.
				</div>
			</div>
		</div>
	</div> 


	<div class="ui vertical feature segment">
		<div class="ui centered page grid">
			@yield('content')
		</div>
	</div>



<!-- rodapé -->
	<div class="ui inverted footer vertical segment">
		<div class="ui stackable center aligned page grid">
			<div class="six wide column">
				<div class="ui two column center aligned stackable grid">
					<div class="column">
						<a href="http://www.ua.pt"><img src="/images/ua_logo.png"  class="ui large image" ></a> 
					</div>
					<div class="column">
						<a href="http://www.ua.pt/deti/"><img src="/images/deti_logo.png" class="ui large image"></a> 
					</div>
				</div>
				<p></p>
				<center>YouInteract © 2015 | Project in Informatics Engineering
					 <p></p> MIECT-UA</center>         
			</div>
		</div>
	</div>

</body>

</html>
