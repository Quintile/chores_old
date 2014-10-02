@if(\Session::has('success') || \Session::has('error'))

	<div id="alert" class="{{(\Session::has('success')) ? 'alert-success' : 'alert-error'}}">
		<h1>{{(\Session::has('success')) ? "Success" : "Error"}}</h1>
		<p>{{(\Session::has('success')) ? \Session::get('success') : \Session::get('error')}}</p>
	</div>

	<script type="text/javascript">

	$(document).ready(function(){
		$("#alert").fadeIn(800);
		setTimeout(function(){
			$("#alert").fadeOut(2500);
		}, 5000);
	});

	</script>

@endif