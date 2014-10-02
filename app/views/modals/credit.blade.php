<div id="modal-credit" class="reveal-modal small" data-reveal>
  <h4>Give Credit To Another User</h4>
  <p>If someone else did a chore, and you want to give them credit to save time or do them a favor, you can use this form to do so.</p>
  <a class="close-reveal-modal">&#215;</a>
  <div class="row">
  	<div class="medium-6 columns">
  		<h5 id="modal-chore-name" style="text-align: right"></h5>
  	</div>
  	<div class="medium-6 columns">
  		<select id="modal-chore-users">
  			@foreach(\Auth::user()->activeHousehold()->users as $u)
  				@if($u->id != \Auth::user()->id)
  					<option>{{$u->name}}</option>
  				@endif
  			@endforeach
  		</select>
  	</div>
  </div>
  <div class="row">
  	<div class="medium-12 columns">
  		<button class="button right">Give Credit</button>
  	</div>
</div>

<script>
	$(".chore-credit").click(function(){
		var choreid = $(this).attr('data-chore-id');
		var row = $("tr[data-chore-id="+choreid+"]");
		var chore = {};
		chore.name = $(row).find('td[data-property=chore-name]').text();
		chore.days = $(row).find('td[data-property=chore-days]').text();
		chore.score = $(row).find('td[data-property=chore-score]').text();

		$("#modal-chore-name").html("Give <strong>"+chore.name+"</strong> to:");

		$("#modal-credit").foundation("reveal", "open");

		$(this).blur();
	});
</script>