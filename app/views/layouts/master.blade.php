<!doctype html>
<html class="no-js" lang="en">
  <head>
	    <meta charset="utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	    <title>Excessive Chores</title>
	    <link rel="stylesheet" href="{{asset('foundation/css/foundation.css')}}" />
	    <link rel="stylesheet" href="{{asset('css/global.css')}}" />
	    <script src="{{asset('foundation/js/vendor/modernizr.js')}}"></script>
	    <script src="{{asset('foundation/js/vendor/jquery.js')}}"></script>
	</head>
	<body>
		@include('layouts.navbar')
		<div style="margin-bottom: 40px">
		</div>

		@if(\Auth::check())
		<div id="side-nav">
			@include('layouts.sidenav')
		</div>
		@endif
		<div id="content" @if(!\Auth::check()) style="margin: 0" @endif>
			@yield('content')
		</div>
		
		<script src="{{asset('foundation/js/foundation.min.js')}}"></script>
		<script>
			$(document).foundation();
		</script>

		<!--Check for invites -->
		@if(\Auth::check())
			@include('modals.invite', array('invite' => \Auth::user()->unreadInvites()->first()))
			@include('modals.active')
		@endif

		<!-- Individual yield modals -->
		@yield('modals')
		@include('layouts.alerts')
	</body>
</html>