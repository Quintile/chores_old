@extends('layouts.master')
@section('content')
	
<div class="row">
	<div class="medium-12 columns">
		<h3>Manage Your Households</h3>
		<ul id="manage-households">
		@foreach(\Auth::user()->households as $h)
			<li class="household">
				<div class="row" style="margin: 0">
					<div class="medium-12">
						<h4 class="household-title">{{$h->name}}</h4>
						<button href="#" data-dropdown="drop-options-{{$h->id}}" aria-controls="drop-options-{{$h->id}}" aria-expanded="false" class="tiny button dropdown right">
							Options
						</button><br />
						<ul id="drop-options-{{$h->id}}" data-dropdown-content class="f-dropdown" aria-hidden="true" tabindex="-1">
						  <li><a href="#">Make Active Household</a></li>
						  <li><a href="{{\URL::route('households.leave', $h->id)}}">Leave Household</a></li>
						  @if($h->user_id === \Auth::user()->id)
						  	<li><a href="#">Delete Household</a></li>
						  @endif
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="medium-6 columns">
						<h5>User List</h5>
						<ul>
							@foreach($h->users as $u)
								<li class="household-user">
									{{$u->name}}
									@if($u->id === $h->user_id)
										<small>(Admin)</small>
									@endif
								</li>
							@endforeach

							@foreach($h->invites as $i)
								<li class="pending">
									{{$i->user->name}}
									<small>(Pending invite from {{$i->origin->name}})</small>
								</li>
							@endforeach
						</ul>

						<h5>Add User To Household</h5>
						<form action="{{\URL::route('households.invite')}}" method="post">
							<input type="hidden" name="household-id" value="{{$h->id}}" />
							<div class="row collapse">
								<div class="small-2 columns">
									<span class="prefix">Email</span>
								</div>
								<div class="small-8 columns">
									<input type="text" name="household-add-email" />
								</div>
								<div class="small-2 columns">
									<button class="button postfix">Invite</button>
								</div>
							</div>
						</form>
					</div>

					<div class="medium-6 columns">
						<h5>Chore Information</h5>
						<p>Coming Soon...</p>
					</div>
				</div>

			</li>
		@endforeach
		</ol>
	</div>
</div>
@stop