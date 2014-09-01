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
		  	@if(Session::get('flash_message'))
		  	<div class="row dont-clear">
				<div data-alert class="alert-box info radius medium-12 columns">
					{{ Session::get('flash_message') }}
					<a href="#" class="close">&times;</a>
				</div>
			</div>
			@endif

			@yield('content')
		</div>
		
		<script src="{{asset('foundation/js/foundation.min.js')}}"></script>
		<script>
			$(document).foundation();
		</script>

		<!--Check for invites -->
		@if(\Auth::check())
			@include('modals.invite', array('invite' => \Auth::user()->unreadInvites()->first()))
			@include('modals.active', array('household' => \Household::find(\HouseholdUser::where('user_id', \Auth::user()->id)->orderBy('created_at', 'DESC')->first()->household_id)))
		@endif

	</body>
</html>