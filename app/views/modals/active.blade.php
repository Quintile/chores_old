<?php
$membership = \HouseholdUser::where('user_id', \Auth::user()->id)->first();
if($membership)
	$household = \Household::find($membership->household_id);
?>
@if(!\Auth::user()->hasActiveHousehold() && !\Preference::check('household-ignore-active') && isset($household))
<div id="modal-active" class="reveal-modal small" data-reveal>
	<div class="row">
		<div class="medium-12 columns">
			<h4>You don't have an active household!</h4>
			<p>Now that you belong to a household, it's important you have at least one household set to active.</p>
			<p>Your active household is what determines which chores you can see, claim and score points with. You can switch between active households at anytime, so you should
			select one to be your active household now.</p>
			<p>Why not set <strong>{{$household->name}}</strong> to be your active household?
		</div>
	</div>
	<div class="row">
		<div class="medium-6 columns">
			<a href="{{\URL::route('households.active', $household->id)}}" class="button expand">Set To Active</a>
		</div>

		<div class="medium-6 columns">
			<a class="button alert expand" onclick="ignoreActive(true)">Ignore This</a>
		</div>
	</div>
</div>
<script type="text/javascript">

	function ignoreActive(value)
	{
		var posting = $.post( '{{\URL::route("preferences.ajax")}}', {'pref': 'household-ignore-active', 'value': value});
		$('#modal-active').foundation('reveal', 'close');
	}

	$('#modal-active').foundation('reveal', 'open');
</script>
@endif