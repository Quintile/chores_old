@extends('layouts.master')
@section("content")

	<table class="table chores">
		<thead>
			<tr>
				<th></th>
				<th>Chore</th>
				<th class="desktop-only">Room</th>
				<th class="desktop-only">Frequency</th>
				<th class="desktop-only">Last Done</th>
			</tr>
		</thead>
		<tbody>
			<?php $room = null; $count = 0; ?>
			@foreach($chores as $c)

			@if($count == 0)
				<div class="panel panel-default">
					<div class="panel-heading">{{$c->room->name}}</div>
					<div class="panel-body">
			@endif

			@if($count++ > 0 && $c->room->name != $room)
				</div></div>
				<div class="panel panel-default">
					<div class="panel-heading">{{$c->room->name}}</div>
					<div class="panel-body">
			@endif
			<tr class="chore 
				@if($c->days() == '0')
					success
				@endif" 
				data-href="{{\URL::route('chores.take', $c->id)}}">
				<td class="urgency">
					<a class="{{$c->urgency()}} urgency btn disabled"></a>
				</td>
				<td>{{$c->name}}</td>
				<td class="desktop-only">{{$c->room->name}}</td>
				<td class="desktop-only">{{$c->frequencyString()}}</td>
				<td class="desktop-only">{{$c->daysString()}}</td>
			</tr>
			<?php $room = $c->room->name; ?>
			@endforeach
			</div></div>
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