@if(\Auth::user()->activeHousehold()->hasNoRooms())
<div id="modal-norooms" class="reveal-modal small" data-reveal>
	<div class="row">
		<div class="medium-12 columns">
			<h4>You have no rooms!</h4>
			<p>Before you can create chores, you need to create rooms in your household. Each chore must belong to a specific room.</p>
		</div>
	</div>
	<div class="row">
		<div class="medium-6 columns">
			<a class="button expand" href="{{\URL::route('rooms.index')}}">Room Management</a>
		</div>

		<div class="medium-6 columns">
			<a class="button alert expand" onclick="ignoreNoRooms(true)">Ignore</a>
		</div>
	</div>
</div>

<script type="text/javascript">

	function ignoreNoRooms(value)
	{
		var posting = $.post( '{{\URL::route("preferences.ajax")}}', {'pref': 'chores-ignore-norooms', 'value': value});
		$('#modal-norooms').foundation('reveal', 'close');
	}

	$('#modal-norooms').foundation('reveal', 'open');

</script>

@endif