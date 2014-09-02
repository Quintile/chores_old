@extends('layouts.master')
@section('content')
<div class="row">
	<div class="medium-12 columns" id="invites">
		<h3>Invites</h3>
		<p>This is where you can view any recieved invites, as well as the status of any invites you've sent.</p>
		<p><strong>Recieving invites</strong> You can either accept an invite, which will cause you to join the specified household,
			or you can dismiss the invite, which will remove the invite.</p>
		<p><strong>Sent invites</strong> You can dismiss sent invites, which will cancel the request and stop the user from being able to
			join your household.</p>
		<h4>Recieved</h4>
		@if(!\Auth::user()->invites()->count())
			<h5>No Invites</h5>
		@endif
		<ul class="invites">
		@foreach(\Auth::user()->invites as $i)
			<li>
				<a href="{{\URL::route('households.invites.dismiss', $i->id)}}" class="button tiny right alert">Dismiss</a>
				<a href="{{\URL::route('households.invites.accept', $i->id)}}" class="button tiny right">Accept</a>
				<h4>{{$i->household->name}}</h4>
				<span>From {{$i->origin->name}}</span>
			</li>
		@endforeach
		</ul>

		<h4>Sent</h4>
		@if(!\Auth::user()->sentInvites()->count())
			<h5>No Invites</h5>
		@endif
		<ul class="invites">
		@foreach(\Auth::user()->sentInvites as $i)
			<li>
				<div class="row">
					<div class="small-10 columns">
						<h4>{{$i->household->name}}</h4>
						<span>To {{$i->user->name}}</span>
					</div>
					<div class="small-2 columns">
						<a href="{{\URL::route('households.invites.dismiss', $i->id)}}" class="button tiny right alert">Dismiss</a>
					</div>
				</div>
			</li>
		@endforeach
		</ul>
	</div>
@stop