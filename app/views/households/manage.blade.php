@extends('layouts.master')
@section('content')
	
<div class="row">
	<div class="medium-12 columns">
		<h3>Manage Your Households</h3>
		<ul id="manage-households">
		@foreach(\Auth::user()->households as $h)
			<li class="household">
				<div class="row" style="margin: 0">
					<div class="medium-12">
						<h3 class="household-title">
							{{$h->name}}
							@if($h->isActiveHousehold())
								(Active)
							@endif
						</h3>
						<button href="#" data-dropdown="drop-options-{{$h->id}}" aria-controls="drop-options-{{$h->id}}" aria-expanded="false" class="tiny button dropdown right">
							Options
						</button><br />
						<ul id="drop-options-{{$h->id}}" data-dropdown-content class="f-dropdown" aria-hidden="true" tabindex="-1">
						  @if(!$h->isActiveHousehold())
						  	<li><a href="{{\URL::route('households.active', $h->id)}}">Make Active Household</a></li>
						  @endif
						  <li><a href="{{\URL::route('households.leave', $h->id)}}" onclick="return confirm('Are you sure you want to leave this household? You will need to be invited back to rejoin.')">Leave Household</a></li>
						  @if($h->isAdmin(\Auth::user()->id))
						  	<li><a href="{{\URL::route('households.delete', $h->id)}}" onclick="return confirm('Are you sure you want to delete this household?\n This cannot be undone!\nAll users will be forced to leave the household and it will no longer exist!\nIf you just want to leave the household, cancel and select Leave Household.')">Delete Household</a></li>
						  @endif
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="medium-6 columns">
						<h4>User List</h4>
						<ul class="user-list">
							@foreach($h->users as $u)
								<li class="household-user">
									@if($h->isAdmin(\Auth::user()->id) && $u->id !== \Auth::user()->id)
									<button href="#" data-dropdown="drop-users-{{$u->id}}" aria-controls="drop-users-{{$u->id}}" aria-expanded="false" class="tiny button dropdown right">
										Options
									</button>
									<ul id="drop-users-{{$u->id}}" data-dropdown-content class="f-dropdown" aria-hidden="true" tabindex="-1">
									 	<li><a href="{{\URL::route('households.admin', array($h->id, $u->id))}}" onclick="return confirm('Are you sure you want to do this? You will lose the ability to delete this household.')">Make Administrator</a></li>
									</ul>
									@endif
									<span class="left">{{$u->name}}</span>
									@if($h->isAdmin($u->id))
										&nbsp;<small>(Admin)</small>
									@endif
									<div style="clear: both"></div>
								</li>
							@endforeach

							@foreach($h->invites as $i)
								<li class="pending">
									{{$i->user->name}}
									<small>(Pending invite from {{$i->origin->name}})</small>
								</li>
							@endforeach
						</ul>

						<h4>Add User To Household</h4>
						<form action="{{\URL::route('households.invite')}}" method="post">
							<input type="hidden" name="household-id" value="{{$h->id}}" />
							<div class="row collapse">
								<div class="small-2 columns">
									<span class="prefix">Email</span>
								</div>
								<div class="small-8 columns">
									<input type="text" name="household-add-email" />
								</div>
								<div class="small-2 columns">
									<button class="button postfix">Invite</button>
								</div>
							</div>
						</form>
					</div>

					<div class="medium-6 columns">
						<h4>Chore Information</h4>
						<p>Coming Soon...</p>
					</div>
				</div>

			</li>
		@endforeach
		</ol>
	</div>
</div>
@stop