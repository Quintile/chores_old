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
					<div class="medium-12 columns">
						<h4>Settings</h4>
						<div class="row">
							<div class="small-3 columns">
								<label>
									Chore Importance
									<select id="household-pref-importance" @if(!$h->isAdmin(\Auth::user()->id)) disabled @endif>
										<option value="creator" @if(\Preference::check('household-pref-importance') == 'creator') selected @endif>Set By Creator</option>
										<option value="average" @if(\Preference::check('household-pref-importance') == 'average') selected @endif>Set By Average</option>
									</select>
								</label>
								<div class="response-wrapper">
									<div class="ajax-response-importance ajax-response"></div>
								</div>
							</div>
							<div class="small-3 columns">
								<label>
									Editing
									<select id="household-pref-editing" @if(!$h->isAdmin(\Auth::user()->id)) disabled @endif>
										<option value="owner" @if(\Preference::check('household-pref-editing') == 'owner') selected @endif>By Owner Only</option>
										<option value="members" @if(\Preference::check('household-pref-editing') == 'members') selected @endif>By Household Members</option>
									</select>
								</label>
								<div class="response-wrapper">
									<div class="ajax-response-editing ajax-response"></div>
								</div>
							</div>
							<div class="small-3 columns">

							</div>
							<div class="small-3 columns">

							</div>
						</div>
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
				<div class="row">
					<div class="medium-12 columns">
						<h4 id="gen-{{$h->id}}">Generator</h4>
						<p>The generator for a household is a tool that can be used to automatically assign a set number of chores to each member of the household per day, offering rewards to those that complete 
						all of their assigned chores. This generator can be configured below.</p>
						<div class="generator-status">
							{{ ($h->generator->active) ? '<span class="generator-status-on">This generator is active.</span>' : '<span class="generator-status-off">This generator is inactive.</span>'}}
						</div>
						<form action="{{\URL::route('households.generator.settings', $h->id)}}" method="post">
							<div class="row">
								<div class="medium-3 columns">
									<label>
										Type
										<select name="generator-type">
											<option value="duration" @if($h->generator->type == "duration") selected @endif>
												Duration (Minutes)
											</option>
											<option value="count" @if($h->generator->type == "count") selected @endif>Number of Chores</option>
										</select>
									</label>
								</div>
								<div class="medium-3 columns">
									<label>
										Maximum
										<input type="number" min="1" value="{{$h->generator->max}}" name="generator-max" />
									</label>
								</div>
								<div class="medium-6 columns">
									<button class="button generator-toggle small">Save Settings</button>
									<a class="button generator-toggle small @if($h->generator->active) alert @endif " href="{{\URL::route('households.generator', $h->id)}}">Turn {{($h->generator->active) ? "Off" : "On"}}</a>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row">
					<div class="medium-12 columns">
						<h4>Generator Subscription</h4>
						<p>You can subscribe to a household generator to recieve emails when the household generates chores for it's users, indicating which chores you were assigned to.</p>
						<form class="generator-sub">
							<label>
								<input type="checkbox" id="generator-sub-check" data-household-id="{{$h->id}}" @if($h->generator->subscribes()) checked="checked" @endif /> Subscribe To This Generator
							</label>
							<div id=""
						</form>
					</div>
				</div>
			</li>
		@endforeach
		</ol>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#household-pref-importance").change(function(){
			var element = $(this);
			var posting = $.post( '{{\URL::route("preferences.household.ajax")}}', {'pref': 'household-pref-importance', 'value': $(this).val()});
			posting.done(function(data){
				$(".ajax-response-importance").html('Settings Saved');
				$(element).addClass('ajax-success');
				$(".ajax-response-importance").fadeIn(500, function(){
					$(".ajax-response-importance").fadeOut(1000, function(){
						$(element).removeClass('ajax-success');
					});
				});
			});
		});

		$("#household-pref-editing").change(function(){
			var element = $(this);
			var posting = $.post( '{{\URL::route("preferences.household.ajax")}}', {'pref': 'household-pref-editing', 'value': $(this).val()});
			posting.done(function(data){
				$(".ajax-response-editing").html('Settings Saved');
				$(element).addClass('ajax-success');
				$(".ajax-response-editing").fadeIn(500, function(){
					$(".ajax-response-editing").fadeOut(1000, function(){
						$(element).removeClass('ajax-success');
					});
				});
			});
		});

		$("#generator-sub-check").click(function(){
			var element = $(this);
			var posting = $.post( '{{\URL::route("generators.ajax")}}', {'household': $(this).attr('data-household-id'), 'value': $(this).prop('checked')});
			posting.done(function(data){
				//Needs some kind of update notifaction

			});
		});

		
	});
</script>

@stop