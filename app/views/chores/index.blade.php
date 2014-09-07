@extends('layouts.master')
@section('content')

<div class="row">
	<div class="medium-6 columns">
		<h3>View Chores</h3>
		<p class="info">
			This list is for keeping track of which chores have been added under which rooms, and is not intended
			to be used as a readable list for deciding what chores need to be done.
		</p>
		<p class="info">
			For more usable lists, please
			check out <a href="#">link a</a>, <a href="#">link b</a> or <a href="#">link c</a>.
		</p>
		<ul class="view-chores-room-list">
		@foreach(\Auth::user()->activeHousehold()->rooms as $r)
			<li>
				{{$r->name}}
				<ul class="view-chores-chore-list">
				@if($r->chores()->count() == 0)
					<li>None</li>
				@endif
				@foreach($r->chores as $c)
					<li>
						<a data-dropdown="drop-chore-{{$c->id}}" aria-controls="drop-chore-{{$c->id}}" aria-expanded="false">{{$c->name}}</a> {{$c->importance()}}
						<ul id="drop-chore-{{$c->id}}" class="f-dropdown" data-dropdown-content aria-hidden="true" tabindex="-1">
							<li><a href="{{\URL::route('chores.view', $c->id)}}">Go To Chore Page</a></li>
							@if($c->household()->isAdmin(\Auth::user()->id) || (\Preference::check('household-pref-editing') == 'members' || $c->user_id == \Auth::user()->id))
							<li><a href="{{\URL::route('chores.edit', $c->id)}}">Edit Chore</a></li>
							@endif
							<li><a href="{{\URL::route('chores.delete', $c->id)}}" onclick="return confirm('Are you sure you want to delete this? This cannot be undone.')">Delete Chore</a></li>
						</ul>
					</li>
				@endforeach
				</ul>
			</li>
		@endforeach
		</ul>
	</div>
	<div class="medium-6 columns">
		<form action="{{(isset($chore)) ? \URL::route('chores.edit', $chore->id) : \URL::route('chores.add.post')}}" method="post">
			<h3>{{(isset($chore)) ? 'Edit' : 'Create'}} A Chore</h3>
			<div class="panel" id="create-chore">
				<div class="row">
					<div class="small-6 columns">
						<label>
							Name
							<input type="text" name="chore-name" autofocus @if(isset($chore)) value="{{$chore->name}}" @endif />
						</label>
					</div>
					<div class="small-6 columns">
						<label>
							Room
							<select name="chore-room">
							@foreach(\Room::orderBy('name')->get() as $r)
								<option value="{{$r->id}}" @if(!isset($chore) && \Preference::check('create-chore-lastroom') == $r->id) selected @elseif(isset($chore) && $chore->room_id == $r->id) selected @endif>{{$r->name}}</option>
							@endforeach
							</select>
						</label>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<label>
							Description
							<textarea name="chore-description">{{(isset($chore)) ? $chore->description : ''}}</textarea>
						</label>
					</div>
				</div>
				<div class="row">
					<div class="small-3 columns">
						<label>
							Duration
							<input type="number" name="chore-duration" min="1" value="{{(isset($chore)) ? $chore->duration : ''}}" />
						</label>
					</div>
					<div class="small-9 columns">
						<p class="info">
						<strong>Duration: </strong> The number of <strong>minutes</strong> it takes to complete the chore (on average). This value is used to calculate it's score.
						</p>
					</div>
				</div>
				<div class="row">
					<div class="small-4 columns">
						<label id="frequency">
							Frequency
							@if(\Preference::check('create-chore-frequency') == 'simple')
							<select name="chore-frequency">
								<option value="1" @if(isset($chore) && $chore->frequency == '1') selected @endif>Daily</option>
								<option value="3" @if(isset($chore) && $chore->frequency == '3') selected @endif>Twice a Week</option>
								<option value="7" @if(isset($chore) && $chore->frequency == '7') selected @endif>Weekly</option>
								<option value="14" @if(isset($chore) && $chore->frequency == '14') selected @endif>Bi-Weekly</option>
								<option value="30" @if(isset($chore) && $chore->frequency == '30') selected @endif>Monthly</option>
								<option value="60" @if(isset($chore) && $chore->frequency == '60') selected @endif>Bi-Monthly</option>
								<option value="365" @if(isset($chore) && $chore->frequency == '365') selected @endif>Yearly</option>
							</select>
							@else
								<input type="number" name="chore-frequency" min="1" />
							@endif
						</label>
					</div>
					<div class="small-8 columns">
						<p class="info">
						<strong>Frequency: </strong> The number of <strong>days</strong> between when this chore needs to be completed.
						</p>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<div class="right">
							<label>
								<input type="checkbox" id="chore-frequency-toggle" @if(\Preference::check('create-chore-frequency') == "simple") checked="checked" @endif />
								Use Simple Frequency
							</label>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="small-4 columns">
						<label id="importance">
							Importance
							@if(\Preference::check('create-chore-importance') == 'simple')
							<select name="chore-importance">
								@if(isset($chore) && is_null($chore->personalImportance()))
								<option value="" selected></option>
								@endif
								<option value="1" @if(isset($chore) && $chore->personalImportance() == 1) selected @endif>Not Important</option>
								<option value="5" @if(isset($chore) && $chore->personalImportance() == 5) selected @endif>Somewhat</option>
								<option value="10" @if(isset($chore) && $chore->personalImportance() == 10) selected @endif>Important</option>
							</select>
							@else
								<input type="number" name="chore-importance" min="1" max="10" @if(isset($chore)) value="{{$chore->personalImportance()}}" @endif />
							@endif
						</label>
					</div>
					<div class="small-8 columns">
						<p class="info">
						<strong>Importance: </strong> More important chores take priority over less important chores, even if the days since they were last done are the same. <a href="#">Learn more</a>
						</p>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<div class="right">
							<label>
								<input type="checkbox" id="chore-importance-toggle" @if(\Preference::check('create-chore-importance') == "simple") checked="checked" @endif />
								Use Simple Importance
							</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<button class="button expand">{{(isset($chore)) ? 'Edit' : 'Create'}} Chore</button>
						@if(isset($chore))
						<a class="button default expand" href="{{\URL::route('chores.add')}}">Cancel Edit Mode</a>
						@endif
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<div style="display: none">
	<div id="template-advanced-frequency">
		<input type="number" name="chore-frequency" min="1" style="display: none" />
	</div>
	<div id="template-simple-frequency">
		<select name="chore-frequency" style="display: none">
			<option value="1" @if(isset($chore) && $chore->frequency == '1') selected @endif>Daily</option>
			<option value="3" @if(isset($chore) && $chore->frequency == '3') selected @endif>Twice a Week</option>
			<option value="7" @if(isset($chore) && $chore->frequency == '7') selected @endif>Weekly</option>
			<option value="14" @if(isset($chore) && $chore->frequency == '14') selected @endif>Bi-Weekly</option>
			<option value="30" @if(isset($chore) && $chore->frequency == '30') selected @endif>Monthly</option>
			<option value="60" @if(isset($chore) && $chore->frequency == '60') selected @endif>Bi-Monthly</option>
			<option value="365" @if(isset($chore) && $chore->frequency == '365') selected @endif>Yearly</option>
		</select>
	</div>
	<div id="template-advanced-importance">
		<input type="number" name="chore-importance" min="1" max="10" style="display: none" @if(isset($chore)) value="{{$chore->personalImportance()}}" @endif />
	</div>
	<div id="template-simple-importance">
		<select name="chore-importance" style="display: none">
			@if(isset($chore) && is_null($chore->personalImportance()))
				<option value="" selected></option>
			@endif
			<option value="1" @if(isset($chore) && $chore->personalImportance() == '1') selected @endif>Not Important</option>
			<option value="5" @if(isset($chore) && $chore->personalImportance() == '5') selected @endif>Somewhat</option>
			<option value="10" @if(isset($chore) && $chore->personalImportance() == '10') selected @endif>Important</option>
		</select>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function(){

		@if(\Preference::check('create-chore-frequency'))
			var frequency = "{{\Preference::check('create-chore-frequency')}}";

		@else
			var frequency = 'simple';
		@endif


		$("#chore-frequency-toggle").click(function(){
			if(!$(this).prop('checked'))
			{
				$("#frequency select").remove();
				$("#frequency").append($("#template-advanced-frequency").html());
				$("#frequency input").fadeIn();
				frequency = 'advanced';
			}
			else
			{
				$("#frequency input").remove();
				$("#frequency").append($("#template-simple-frequency").html());
				$("#frequency select").fadeIn();
				frequency = 'simple';
			}

			var posting = $.post( '{{\URL::route("preferences.ajax")}}', {'pref': 'create-chore-frequency', 'value': frequency});

		});

		@if(\Preference::check('create-chore-importance'))
			var importance = "{{\Preference::check('create-chore-importance')}}";
		@else
			var importance = 'simple';
		@endif

		$("#chore-importance-toggle").click(function(){
			if(!$(this).prop('checked'))
			{
				$("#importance select").remove();
				$("#importance").append($("#template-advanced-importance").html());
				$("#importance input").fadeIn();
				importance = 'advanced';
			}
			else
			{
				$("#importance input").remove();
				$("#importance").append($("#template-simple-importance").html());
				$("#importance select").fadeIn();
				importance = 'simple';
			}

			var posting = $.post( '{{\URL::route("preferences.ajax")}}', {'pref': 'create-chore-importance', 'value': importance});
		});
	});

</script>

@stop

@section('modals')
@include('modals.norooms')
@stop