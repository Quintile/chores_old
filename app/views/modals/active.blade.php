@extends('layouts.master')
@section('content')

<div id="modal-invites" class="reveal-modal small" data-reveal>
	<div class="row">
		<div class="medium-12 columns">
			<h4>You have a new invite!</h4>
			<p>Someone has sent you an invite to join a household!</p>
			<p>You can join the household and begin participating in the household chores right away, or you can ignore this invite.</p>
		</div>
	</div>
	<div class="row">
		<div class="medium-6 columns">
			<a href="{{\URL::route('households.invites')}}" class="button expand" onclick="inviteRemind(1)">View Invites</a>
		</div>

		<div class="medium-6 columns">
			<a class="button alert expand" onclick="inviteIgnore()">Ignore</a>
		</div>
	</div>
</div>
@stop