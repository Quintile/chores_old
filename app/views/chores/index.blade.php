@extends('layouts.master')
@section('content')

<div class="row">
	<div class="medium-12 columns">
		<ul class="chore-list">
		@foreach(\Auth::user()->activeHousehold()->rooms as $r)
			@if($r->chores()->count() > 0)
			<li>
				<h1>{{$r->name}}</h1>
				<table>
					<thead>
						<tr>
							<th>Name</th>
							<th>Last Done</th>
						</tr>
					</thead>
					<tbody>
						@foreach($r->chores as $c)
						<tr>
							<td>{{$c->name}}</td>
							<td>{{$c->daysString()}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</li>
			@endif
		@endforeach
		</ul>
	</div>
</div>

@stop