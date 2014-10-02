<button href="#" data-dropdown="drop-chore-{{$c->id}}" aria-controls="drop-chore-{{$c->id}}" aria-expanded="false" class="button secondary dropdown tiny right">Options</button>
<ul id="drop-chore-{{$c->id}}" data-dropdown-content class="f-dropdown chore-options" aria-hidden="true" tabindex="-1">
	<li>
		@if($c->claimer() == \Auth::user()->name)
		<a class="disabled">Claim This Chore</a>
		@else
		<a href="{{\URL::route('chores.claim', $c->id)}}">Claim This Chore</a>
		@endif
	</li>
	<li>
		<a href="{{\URL::route('chores.finish', $c->id)}}">
		@if($c->claimer() == \Auth::user()->name)
			Finish This Chore
		@else
			Claim & Finish This Chore
		@endif
		</a>
	</li>
	<li>
		<a data-chore-id="{{$c->id}}" class="chore-credit">Give Credit To Another User</a>
	</li>
	<li>
		<a>View Details</a>
	</li>
</ul>

