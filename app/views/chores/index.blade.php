@extends('layouts.master')
@section('content')

<div class="row">
	<div class="medium-6 columns">
		<h3>View Chores</h3>
		<ul>
		@foreach(\Auth::user()->activeHousehold()->rooms as $r)
			<li>
				{{$r->name}}
				<ul>
				@if($r->chores()->count() == 0)
					<li>None</li>
				@endif
				@foreach($r->chores() as $c)
					<li>{{$c->name}}</li>
				@endforeach
				</ul>

			</li>

		@endforeach
		</ul>
	</div>
	<div class="medium-6 columns">
		<h3>Create A Chore</h3>
		<div class="panel" id="create-chore">
			<div class="row">
				<div class="small-6 columns">
					<label>
						Name
						<input type="text" name="chore-name" />
					</label>
				</div>
				<div class="small-6 columns">
					<label>
						Room
						<select name="chore-room">
						@foreach(\Room::orderBy('name')->get() as $r)
							<option value="{{$r->id}}">{{$r->name}}</option>
						@endforeach
						</select>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="small-12 columns">
					<label>
						Description
						<textarea name="chore-description"></textarea>
					</label>
				</div>
			</div>
			<div class="row">
				<div class="small-3 columns">
					<label>
						Duration
						<input type="number" name="chore-duration" min="1" />
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
							<option value="1">Daily</option>
							<option value="3">Twice a Week</option>
							<option value="7">Weekly</option>
							<option value="14">Bi-Weekly</option>
							<option value="30">Monthly</option>
							<option value="60">Bi-Monthly</option>
							<option value="365">Yearly</option>
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
				<div class="small-12 columns">
					<button class="button expand">Create Chore</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div style="display: none">
	<div id="template-advanced">
		<input type="number" name="chore-frequency" min="1" style="display: none" />
	</div>
	<div id="template-simple">
		<select name="chore-frequency" style="display: none">
			<option value="1">Daily</option>
			<option value="2">Every Other Day</option>
			<option value="3">Twice a Week</option>
			<option value="7">Weekly</option>
			<option value="14">Bi-Weekly</option>
			<option value="30">Monthly</option>
			<option value="60">Bi-Monthly</option>
			<option value="365">Yearly</option>
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
				$("#frequency").append($("#template-advanced").html());
				$("#frequency input").fadeIn();
				frequency = 'advanced';
			}
			else
			{
				$("#frequency input").remove();
				$("#frequency").append($("#template-simple").html());
				$("#frequency select").fadeIn();
				frequency = 'simple';
			}

			var posting = $.post( '{{\URL::route("preferences.ajax")}}', {'pref': 'create-chore-frequency', 'value': frequency});

		});
	});

</script>

@stop

@section('modals')
@include('modals.norooms')
@stop