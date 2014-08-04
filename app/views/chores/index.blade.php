@extends('layouts.master')
@section("content")

	<table class="table table-condensed chores">
		<thead>
			<tr>
				<th></th>
				<th>Chore</th>
				<th>Room</th>
				<th>Frequency</th>
				<th>Last Done</th>
			</tr>
		</thead>
		<tbody>
			@foreach($chores as $c)
			<tr class="chore">
				<td>
					<a class="{{$c->urgency()}} urgency btn disabled"></a>
				</td>
				<td>{{$c->name}}</td>
				<td>{{$c->room->name}}</td>
				<td>{{$c->frequencyString()}}</td>
				<td>{{$c->days()}} Days</td>
			</tr>
			@endforeach
		</tbody>
	</table>

@stop