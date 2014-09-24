<nav class="top-bar" data-topbar role="navigation">
  <ul class="title-area">
    <li class="name">
      <h1><a href="#"><span class="title-1">Excessive</span> <span class="title-2">Chores</span></a></h1>
    </li>
     <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
  </ul>

  <section class="top-bar-section">
  	@if(\Auth::check())
    <ul class="right">
      <li class="has-dropdown user-menu">
        <a href="#">{{\Auth::user()->name}}</a>
        <ul class="dropdown">
          <li><a href="{{\URL::route('logout')}}">Logout</a></li>
        </ul>
      </li>
    </ul>
    <div class="right" style="color: #FFF; font-family: 'Open Sans Condensed'; font-size: 24px; margin-right: 20px">{{number_format(2342)}}</div>
    
    @endif
  </section>
</nav>