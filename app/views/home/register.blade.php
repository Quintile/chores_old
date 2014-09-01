@extends('layouts.master')
@section('content')

<form action="{{\URL::route('register.post')}}" method="post">
	<div class="row">
		<div class="medium-6 columns medium-centered panel">
			<div class="row">
				<div class="medium-12 columns">
					<label>
						Name
						<input type="text" name="register-name" />
					</label>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
					<label>
						Email
						<input type="email" name="register-email" />
					</label>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
					<label>
						Password
						<input type="password" name="register-password" />
					</label>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
					<label>
						Confirm Password
						<input type="password" name="register-password2" />
					</label>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
					<button class="button expand">Register</button>
				</div>
			</div>
		</div>
	</div>
</form>
@stop