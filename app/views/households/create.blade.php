@extends('layouts.master')
@section('content')
<div class="row">
	<div class="medium-12 columns">
		<h4>Households</h4>
		<p>A <strong>Household</strong> is a collection of rooms, chores and users. A user can create a household  to represent their home, invite their family to join the
		household, and then as a group, they can compete and co-operate to always have the most important chores done.</p>
		<p>Users can belong to any number of households, but they must only have one set as the active household, which is what the website will use to display information on.
		This active household can be changed at anytime from the Manage Households section.</p>
		<p>If you don't have a household, create one now, and then invite your family, and start doing chores!</p>
	</div>
	<div class="medium-12 columns">
		<h4>Create Household</h4>

		<form action="{{\URL::route('households.create.post')}}" method="post">
			<div class="row collapse">
				<div class="small-2 columns">
					<span class="prefix">Household Name</span>
				</div>
				<div class="small-5 columns">
					<input type="text" name="household-name" />
				</div>
				<div class="small-2 columns">
					<button class="button postfix">Create</button>
				</div>
				<div class="small-2 columns"></div>
			</div>
		</form>
	</div>
</div>
@stop