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
							<th style="width: 32px"></th>
							<th>Name</th>
							<th>Last Done</th>
							<th>Priority</th>
							<th>Score</th>
							<th style="width: 106px"></th>
						</tr>
					</thead>
					<tbody>
						@foreach($r->chores as $c)
						<tr class="chore" onclick="window.location.href='{{\URL::route('chores.claim', $c->id)}}'">
							<td><span class="chore-alert danger"></span></td>
							<td>{{$c->name}}</td>
							<td>{{$c->daysString()}}</td>
							<td>{{$c->priority()}}</td>
							<td>{{$c->score()}}</td>
							<td>
								<button href="#" data-dropdown="drop-chore-{{$c->id}}" aria-controls="drop-chore-{{$c->id}}" aria-expanded="false" class="button secondary dropdown tiny right">Options</button>
								<ul id="drop-chore-{{$c->id}}" data-dropdown-content class="f-dropdown" aria-hidden="true" tabindex="-1">
									<li><a href="#">This is a link</a></li>
								 	<li><a href="#">This is another</a></li>
								 	<li><a href="#">Yet another</a></li>
								</ul>
							</td>
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

<script type="text/javascript">

</script>

@stop