@extends('layouts.master')
@section('content')
<div class="row">
	<div class="medium-12 columns">
		<h3>Invites</h3>
		<p>This is where invites live blah blah</p>
		<ul id="invites">
		@foreach(\Auth::user()->invites as $i)
			<li>
				<a href="{{\URL::route('households.invites.dismiss', $i->id)}}" class="button tiny right alert">Dismiss</a>
				<a href="{{\URL::route('households.invites.accept', $i->id)}}" class="button tiny right">Accept</a>
				<h4>{{$i->household->name}}</h4>
				<span>From {{$i->origin->name}}</span>
			</li>
		@endforeach
		</ul>
	</div>
@stop