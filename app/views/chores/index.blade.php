@extends('layouts.master')
@section("content")

	<table class="table table-condensed">
		<thead>
			<tr>
				<th></th>
				<th>Chore</th>
				<th>Room</th>
				<th>Last Done</th>
			</tr>
		</thead>
		<tbody>
			@foreach($chores as $c)
			<tr>
				<td>
					<div class="{{$c->urgency()}} urgency"></div>
				</td>
				<td>{{$c->name}}</td>
				<td>{{$c->room->name}}</td>
				<td>{{$c->days()}} Days</td>
			</tr>
			@endforeach
		</tbody>
	</table>

@stop