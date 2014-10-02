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
							<th>Claimed</th>
							<th style="width: 106px"></th>
						</tr>
					</thead>
					<tbody>
						@foreach($r->chores as $c)
						<tr class="chore @if($c->days() === '0') finished @elseif($c->claimer() == \Auth::user()->name) self-claimed @elseif($c->claimer()) other-claimed @endif" data-chore-id="{{$c->id}}">
							<td class="chore-status"><span class="chore-alert {{$c->alertStatus()}}"></span></td>
							<td data-property="chore-name">{{$c->name}}</td>
							<td data-property="chore-days">{{$c->daysString()}}</td>
							<td data-property="chore-score" class="number">{{$c->score()}}</td>
							@if($c->doneToday())
								<td class="chore-claimed-name">{{$c->lastDoneBy()}} (Done)</td>
							@elseif($c->claimer())
								<td class="chore-claimed-name">{{$c->claimer()}}</td>
							@else
								<td><a href="{{\URL::route('chores.claim', $c->id)}}" class="button secondary tiny right">Claim This Chore</a></td>
							@endif
							<td>
								@include('layouts.chores.options')
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
@section('modals')
@include('modals.credit')
@stop