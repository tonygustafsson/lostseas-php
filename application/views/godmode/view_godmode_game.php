<header title="God Mode: Game">
	<h3>God mode: Game</h3>
</header>

<section class="actions">
	<a class="ajaxHTML" title="Change user parameters" href="godmode/user/<?php echo $this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/players_user.png')?>" alt="User" width="32" height="32">User</a>
	<a class="ajaxHTML" title="Change game parameters" href="godmode/index/<?php echo $this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/settings_character.png')?>" alt="Game" width="32" height="32">Game</a>
	<a class="ajaxHTML" title="Change ship parameters" href="godmode/ship/<?php echo $this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/shipyard_sell.png')?>" alt="Ship" width="32" height="32">Ships</a>
	<a class="ajaxHTML" title="Change crew parameters" href="godmode/crew/<?php echo $this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/tavern_sailor.png')?>" alt="Crew" width="32" height="32">Crew</a>
</section>

<div id="msg"></div>

<section class="actions">
	<form method="post" id="godmode_change_user" action="">
		<select name="godmode_change_user">
			<? foreach($players as $this_player): ?>
				<? if (empty($this_player['name'])): ?>
					<? if ($player['user']['id'] === $this_player['id']): ?>
						<option value="<?php echo $this_player['id']?>" selected>TempUser (<?php echo $this_player['id']?>)</option>
					<? else: ?>
						<option value="<?php echo $this_player['id']?>">TempUser (<?php echo $this_player['id']?>)</option>
					<? endif; ?>
				<? else: ?>
					<? if ($player['user']['id'] === $this_player['id']): ?>
						<option value="<?php echo $this_player['id']?>" selected><?php echo $this_player['name']?> (<?php echo $this_player['id']?>)</option>
					<? else: ?>
						<option value="<?php echo $this_player['id']?>"><?php echo $this_player['name']?> (<?php echo $this_player['id']?>)</option>
					<? endif; ?>
				<? endif; ?>
			<? endforeach; ?>
		</select>
		
		<a id="godmode_change_user_url" class="ajaxHTML nopic" data-baseurl="<?php echo base_url('godmode/index')?>" href="<?php echo base_url('godmode/index/' . $user['id'])?>">Change</a>
	</form>
</section>

<form method="post" class="ajaxJSON" action="<?php echo base_url('godmode/game_update')?>">
	<input type="hidden" name="user_id" value="<?php echo $player['user']['id']?>">

	<h3>Character</h3>
	
	<table class="godmode">
		<tr>
			<th>Setting</th>
			<th>Value</th>
		</tr>
		
		<tr><td>character_name</td><td><input type="text" id="character_name" name="character_name" value="<?php echo $player['game']['character_name']?>"></td></tr>
		<tr><td>character_gender</td><td><input type="text" id="character_gender" name="character_gender" value="<?php echo $player['game']['character_gender']?>"></td></tr>
		<tr><td>character_avatar</td><td><input type="text" id="character_avatar" name="character_avatar" value="<?php echo $player['game']['character_gender_long']?>###<?php echo $player['game']['character_avatar']?>"></td></tr>
		<tr><td>character_age</td><td><input type="text" id="character_age" name="character_age" value="<?php echo $player['game']['character_age']?>"></td></tr>
		<tr><td>character_description</td><td><input type="text" id="character_description" name="character_description" value="<?php echo $player['game']['character_description']?>"></td></tr>
		<tr><td>nationality</td><td><input type="text" id="nationality" name="nationality" value="<?php echo $player['game']['nationality']?>"></td></tr>
		<tr><td>town</td><td><input type="text" id="town" name="town" value="<?php echo $player['game']['town']?>"></td></tr>
		<tr><td>place</td><td><input type="text" id="place" name="place" value="<?php echo $player['game']['place']?>"></td></tr>
		<tr><td>week</td><td><input type="number" id="week" name="week" value="<?php echo $player['game']['week']?>"></td></tr>
		<tr><td>title</td><td><input type="text" id="title" name="title" value="<?php echo $player['game']['title']?>"></td></tr>
	</table>
	
	<h3>Possessions</h3>
	
	<table class="godmode">
		<tr>
			<th>Setting</th>
			<th>Value</th>
		</tr>
		
		<tr><td>doubloons</td><td><input type="number" id="doubloons" name="doubloons" value="<?php echo $player['game']['doubloons']?>"></td></tr>
		<tr><td>bank_account</td><td><input type="number" id="bank_account" name="bank_account" value="<?php echo $player['game']['bank_account']?>"></td></tr>
		<tr><td>bank_loan</td><td><input type="number" id="bank_loan" name="bank_loan" value="<?php echo $player['game']['bank_loan']?>"></td></tr>
		<tr><td>cannons</td><td><input type="number" id="cannons" name="cannons" value="<?php echo $player['game']['cannons']?>"></td></tr>
		<tr><td>prisoners</td><td><input type="number" id="prisoners" name="prisoners" value="<?php echo $player['game']['prisoners']?>"></td></tr>
		<tr><td>food</td><td><input type="number" id="food" name="food" value="<?php echo $player['game']['food']?>"></td></tr>
		<tr><td>water</td><td><input type="number" id="water" name="water" value="<?php echo $player['game']['water']?>"></td></tr>
		<tr><td>porcelain</td><td><input type="number" id="porcelain" name="porcelain" value="<?php echo $player['game']['porcelain']?>"></td></tr>
		<tr><td>spices</td><td><input type="number" id="spices" name="spices" value="<?php echo $player['game']['spices']?>"></td></tr>
		<tr><td>silk</td><td><input type="number" id="silk" name="silk" value="<?php echo $player['game']['silk']?>"></td></tr>
		<tr><td>tobacco</td><td><input type="number" id="tobacco" name="tobacco" value="<?php echo $player['game']['tobacco']?>"></td></tr>
		<tr><td>rum</td><td><input type="number" id="rum" name="rum" value="<?php echo $player['game']['rum']?>"></td></tr>
		<tr><td>medicine</td><td><input type="number" id="medicine" name="medicine" value="<?php echo $player['game']['medicine']?>"></td></tr>
		<tr><td>rafts</td><td><input type="number" id="rafts" name="rafts" value="<?php echo $player['game']['rafts']?>"></td></tr>
	</table>

	<h3>Victories</h3>
	
	<table class="godmode">
		<tr>
			<th>Setting</th>
			<th>Value</th>
		</tr>
		
		<tr><td>victories_england</td><td><input type="number" id="victories_england" name="victories_england" value="<?php echo $player['game']['victories_england']?>"></td></tr>
		<tr><td>victories_france</td><td><input type="number" id="victories_france" name="victories_france" value="<?php echo $player['game']['victories_france']?>"></td></tr>
		<tr><td>victories_spain</td><td><input type="number" id="victories_spain" name="victories_spain" value="<?php echo $player['game']['victories_spain']?>"></td></tr>
		<tr><td>victories_holland</td><td><input type="number" id="victories_holland" name="victories_holland" value="<?php echo $player['game']['victories_holland']?>"></td></tr>
		<tr><td>victories_pirates</td><td><input type="number" id="victories_pirates" name="victories_pirates" value="<?php echo $player['game']['victories_pirates']?>"></td></tr>
	</table>

	<h3>Events</h3>
	
	<table class="godmode">
		<tr>
			<th>Setting</th>
			<th>Value</th>
		</tr>

		<tr><td>event_market_goods</td><td><input type="text" id="event_market_goods" name="event_market_goods" value="<?php echo $player['game']['event_market_goods']?>"></td></tr>
		<tr><td>event_market_slaves</td><td><input type="text" id="event_market_slaves" name="event_market_slaves" value="<?php echo $player['game']['event_market_slaves']?>"></td></tr>
		<tr><td>event_sailors</td><td><input type="text" id="event_sailors" name="event_sailors" value="<?php echo $player['game']['event_sailors']?>"></td></tr>
		<tr><td>event_work</td><td><input type="text" id="event_work" name="event_work" value="<?php echo $player['game']['event_work']?>"></td></tr>
		<tr><td>event_ship</td><td><input type="text" id="event_ship" name="event_ship" value="<?php echo $player['game']['event_ship']?>"></td></tr>
		<tr><td>event_ship_won</td><td><input type="text" id="event_ship_won" name="event_ship_won" value="<?php echo $player['game']['event_ship_won']?>"></td></tr>
		<tr><td>event_ocean_trade</td><td><input type="text" id="event_ocean_trade" name="event_ocean_trade" value="<?php echo $player['game']['event_ocean_trade']?>"></td></tr>
	</table>

	<p style="text-align: right">
		<input type="submit" value="Save">
	</p>

</form>