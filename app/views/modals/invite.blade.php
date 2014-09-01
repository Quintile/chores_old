@if(\Auth::user()->hasUnreadInvites() && \Request::url() !== \URL::route('households.invites'))
<div id="modal-invites" class="reveal-modal small" data-reveal>
	<div class="row">
		<div class="medium-12 columns">
			<h4>You have a new invite!</h4>
			<p>Someone has sent you an invite to join a household!</p>
			<p>You can join the household and begin participating in the household chores right away, or you can ignore this invite.</p>
		</div>
	</div>
	<div class="row">
		<div class="medium-4 columns">
			<a href="{{\URL::route('households.invites')}}" class="button expand" onclick="inviteRemind(1)">View Invites</a>
		</div>

		<div class="medium-4 columns">
			<a class="button alert expand" onclick="inviteIgnore()">Ignore</a>
		</div>

		<div class="medium-4 columns">
			<a class="button expand" onclick="inviteRemind()">Remind Me Later</a>
		</div>
	</div>
</div>

<script type="text/javascript">

	function inviteRemind(time)
	{
		//Set a remind timer
		var posting = $.post( '{{\URL::route("households.invites.remind", $invite->id)}}', {'time': time});
		$('#modal-invites').foundation('reveal', 'close');
	}

	function inviteIgnore()
	{
		//Set to ignore that specific invite
		var posting = $.post ('{{\URL::route("households.invites.ignore", $invite->id)}}');
		$('#modal-invites').foundation('reveal', 'close');
	}

	$('#modal-invites').foundation('reveal', 'open');

</script>

@endif