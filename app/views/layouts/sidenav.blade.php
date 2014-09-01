<ul class="side-nav">
	
	<li class="heading">Home</li>
	<li><a href="{{\URL::route('home')}}">News</a>

	@if(\Auth::check())

  	<li class="heading">Household</li>
  	<li><a href="{{\URL::route('households.create')}}">Create Household</a></li>
  	<li><a href="{{\URL::route('households.manage')}}">Manage Households</a></li>
  	<li><a href="{{\URL::route('households.invites')}}">Invites</a></li>
	@endif
</ul>