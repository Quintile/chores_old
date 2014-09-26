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
    <div class="right user-score" style="color: #FFF; font-family: 'Open Sans Condensed'; font-size: 24px; margin-right: 20px">Week: {{number_format(\Auth::user()->score())}}</div>
    @endif
  </section>
</nav>

<script type="text/javascript">

     var week = '{{number_format(\Auth::user()->score())}}';
      var all = '{{number_format(\Auth::user()->scoreAllTime())}}';
      var flag = true;
      var timeout = 20000;

    function scoreLoop(){

        setTimeout(function(){
            if(flag)
        {
            timeout = 5000;
            $('.user-score').fadeOut(1000, function(){
                $('.user-score').text('All Time: '+all);
                flag = false;
                $('.user-score').fadeIn(500, scoreLoop);
            });
           
        }
        else
        {
            timeout = 10000;
            $('.user-score').fadeOut(1000, function(){
                $('.user-score').text('Week: '+week);
                flag = true;
                $('.user-score').fadeIn(500, scoreLoop);
            });
            
        }
           
    }, timeout);

        

    }

    $(document).ready(function(){

     

         scoreLoop();
    
    });

</script>