@extends('layouts.master')
@section("content")

	<table class="table chores">
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
			<tr class="chore" data-href="{{\URL::route('chores.take', $c->id)}}">
				<td class="urgency">
					<a class="{{$c->urgency()}} urgency btn disabled"></a>
				</td>
				<td>{{$c->name}}</td>
				<td class="desktop-only">{{$c->room->name}}</td>
				<td class="desktop-only">{{$c->frequencyString()}}</td>
				<td class="desktop-only">{{$c->daysString()}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<script type="text/javascript">

		$(document).ready(function(){
			$("tr[data-href]").click(function(){
				window.location.href = $(this).attr('data-href');
			});
		});

	</script>
@stop