<ul class="side-nav">
	
	<li class="heading">Home</li>
	<li><a href="{{\URL::route('home')}}">News</a>

	@if(\Auth::check())
    <li class="heading">Chores</li>
    <li><a href="{{\URL::route('chores')}}">Chores (By Room)</a></li>
    <li><a href="{{\URL::route('chores.add')}}">Add a Chore</a></li>
    <li class="heading">Rooms</li>
    <li><a href="{{\URL::route('rooms.index')}}">Room Management</a></li>
  	<li class="heading">Household</li>
  	<li><a href="{{\URL::route('households.create')}}">Create Household</a></li>
  	@if(\Auth::user()->households()->count())
      <li><a href="{{\URL::route('households.manage')}}">Manage Households</a></li>
    @endif
  	<li><a href="{{\URL::route('households.invites')}}">Invites</a></li>

  	<li class="heading">System</li>
  	<li><a href="{{\URL::route('preferences')}}">Preferences</a></li>
	@endif
</ul>