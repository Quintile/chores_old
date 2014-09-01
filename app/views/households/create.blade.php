@extends('layouts.master')
@section('content')
<div class="row">
	<div class="medium-12 columns">
		<h4>Households</h4>
		<p>What re households blah blah</p>
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