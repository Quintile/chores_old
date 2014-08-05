<!DOCTYPE html>
<html>
	<head>
		<title>Excessive Chores</title>
		@section('includes')
			<script src="{{asset('jquery/jquery-2.0.0.js')}}"></script>
			<script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>
			<link href="{{asset('bootstrap/css/bootstrap.css')}}" rel='stylesheet' type='text/css' />
			<link href="{{asset('bootstrap/css/bootstrap-theme.css')}}" rel='stylesheet' type='text/css' />
			<link href='http://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic|Raleway:400,300,200,500,600,700' rel='stylesheet' type='text/css'>
			<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700|Open+Sans:400,800,600' rel='stylesheet' type='text/css'>
			<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
			{{HTML::style('css/global.css')}}
		@show
		<meta name="viewport" content="width=device-width, initial-scale=1.0;">
	</head>

		<body>
	<div class="container">
	
	@if(Session::get('flash_message'))
		<div class="flash">
			{{ Session::get('flash_message') }}
		</div>
	@endif

	@yield('content')

		</div>
	</body>