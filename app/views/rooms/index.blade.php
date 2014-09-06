@extends('layouts.master')
@section('content')

<div class="row">
	<div class="medium-6 columns">
		<h3>View Rooms</h3>
		@if(\Auth::user()->activeHousehold()->hasNoRooms())
			<h5 style="margin-left: 20px">No Rooms</h5>
		@endif
		<ul id="rooms-list">
			@foreach(\Auth::user()->activeHousehold()->rooms as $room)
			<li>
				<h5>{{$room->name}}</h5>
				
					<a class="button tiny alert" href="{{\URL::route('rooms.delete', $room->id)}}">Delete</a>
					<a class="button tiny" href="#">Edit</a>
				
			</li>
			@endforeach
		</ul>
	</div>
	<div class="medium-6 columns">
		<h3>Create A Room</h3>
		<form action="{{\URL::route('rooms.store')}}" method="post">
			<div class="panel">
				<div class="row">
					<div class="small-12 columns">
						<label>
							Room Name
							<input type="text" name="room-name" />
						</label>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<label>
							Description <small>(Optional)</small>
							<textarea rows="4" name="room-description"></textarea>
						</label>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<button class="button expand">Create Room</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$("form input").first().focus();
</script>
@stop
@section('modals')

@stop