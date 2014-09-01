@extends('layouts.master')
@section('content')

<form action="{{\URL::route('login.post')}}" method="post">
	<div class="row">
		<div class="medium-6 columns medium-centered panel">
			<div class="row">
				<div class="medium-12 columns">
					<label>
						Email
						<input type="email" name="login-email" />
					</label>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
					<label>
						Password
						<input type="password" name="login-password" />
					</label>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
					<button class="button expand">Login</button>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
					<a class="right" href="{{\URL::route('register')}}">Register</a>
				</div>
			</div>
		</div>
	</div>
</form>


@stop