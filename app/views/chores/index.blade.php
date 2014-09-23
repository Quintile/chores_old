@extends('layouts.master')
@section('content')

<div class="row">
	<div class="medium-12 columns">
		<ul class="chore-list">
		@foreach(\Auth::user()->activeHousehold()->rooms as $r)
			@if($r->chores()->count() > 0)
			<li>
				<h1>{{$r->name}}</h1>
				<table class="chore-table">
					<thead>
						<tr>
							<th style="width: 18px"></th>
							<th>Name</th>
							<th>Last Done</th>
							<th>Score</th>
							<th>Priority</th>
							<th>Claimed</th>
							<th style="width: 106px"></th>
						</tr>
					</thead>
					<tbody>
						@foreach($r->chores as $c)
						<tr class="chore @if($c->days() === '0') finished @elseif($c->claimer() == \Auth::user()->name) self-claimed @elseif($c->claimer()) other-claimed @endif">
							<td class="chore-status"><span class="chore-alert {{$c->alertStatus()}}"></span></td>
							<td>{{$c->name}}</td>
							<td>{{$c->daysString()}}</td>
							<td class="number">{{$c->score()}}</td>
							<td class="number">{{$c->priority()}}</td>
							@if($c->doneToday())
								<td class="chore-claimed-name">{{$c->lastDoneBy()}} (Done)</td>
							@elseif($c->claimer())
								<td class="chore-claimed-name">{{$c->claimer()}}</td>
							@else
								<td><a href="{{\URL::route('chores.claim', $c->id)}}" class="button secondary tiny right">Claim This Chore</a></td>
							@endif
							<td>
								<button href="#" data-dropdown="drop-chore-{{$c->id}}" aria-controls="drop-chore-{{$c->id}}" aria-expanded="false" class="button secondary dropdown tiny right">Options</button>
								<ul id="drop-chore-{{$c->id}}" data-dropdown-content class="f-dropdown" aria-hidden="true" tabindex="-1">
									<li><a href="{{\URL::route('chores.claim', $c->id)}}">Claim This Chore</a></li>
									<li><a href="{{\URL::route('chores.finish', $c->id)}}">
										@if($c->claimer() == \Auth::user()->name)
											Finish This Chore
										@else
											Claim & Finish This Chore
										@endif
									</a></li>
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