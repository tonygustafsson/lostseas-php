<header class="area-header" class="area-header" title="God Mode: Game">
	<h3>God mode: Game</h3>
</header>

<div class="button-area">
	<a class="ajaxHTML button big-icon" title="Change user parameters"
		href="godmode/user/<?=$this->uri->segment(3)?>">
		<svg width="32" height="32" alt="User">
			<use xlink:href="#player"></use>
		</svg>
		User
	</a>
	<a class="ajaxHTML button big-icon" title="Change game parameters"
		href="godmode/index/<?=$this->uri->segment(3)?>">
		<svg width="32" height="32" alt="User">
			<use xlink:href="#swords"></use>
		</svg>
		Game
	</a>
	<a class="ajaxHTML button big-icon" title="Change ship parameters"
		href="godmode/ship/<?=$this->uri->segment(3)?>">
		<svg width="32" height="32" alt="Ships">
			<use xlink:href="#ship"></use>
		</svg>
		Ships
	</a>
	<a class="ajaxHTML button big-icon" title="Change crew parameters"
		href="godmode/crew/<?=$this->uri->segment(3)?>">
		<svg width="32" height="32" alt="Crew">
			<use xlink:href="#crew-man"></use>
		</svg>
		Crew
	</a>
	<a class="ajaxHTML button big-icon" title="View design system"
		href="godmode/design/<?=$this->uri->segment(3)?>">
		<svg width="32" height="32" alt="Crew">
			<use xlink:href="#design"></use>
		</svg>
		Design
	</a>
</div>

<section class="action-buttons">
	<form method="post" id="godmode_change_user" action="">
		<select name="godmode_change_user">
			<?php foreach ($players as $this_player): ?>
			<?php if (empty($this_player['name'])): ?>
			<?php if ($player['user']['id'] === $this_player['id']): ?>
			<option
				value="<?=$this_player['id']?>"
				selected>TempUser (<?=$this_player['id']?>)</option>
			<?php else: ?>
			<option
				value="<?=$this_player['id']?>">
				TempUser (<?=$this_player['id']?>)</option>
			<?php endif; ?>
			<?php else: ?>
			<?php if ($player['user']['id'] === $this_player['id']): ?>
			<option
				value="<?=$this_player['id']?>"
				selected><?=$this_player['name']?> (<?=$this_player['id']?>)</option>
			<?php else: ?>
			<option
				value="<?=$this_player['id']?>">
				<?=$this_player['name']?>
				(<?=$this_player['id']?>)
			</option>
			<?php endif; ?>
			<?php endif; ?>
			<?php endforeach; ?>
		</select>

		<a id="godmode_change_user_url" class="ajaxHTML nopic"
			data-baseurl="<?=base_url('godmode/index')?>"
			href="<?=base_url('godmode/index/' . $user['id'])?>">Change</a>
	</form>
</section>

<form method="post" class="ajaxJSON"
	action="<?=base_url('godmode/game_update')?>">
	<input type="hidden" name="user_id"
		value="<?=$player['user']['id']?>">

	<h3>Character</h3>

	<table class="godmode">
		<tr>
			<th>Setting</th>
			<th>Value</th>
		</tr>

		<tr>
			<td>character_name</td>
			<td><input type="text" id="character_name" name="character_name"
					value="<?=$player['game']['character_name']?>">
			</td>
		</tr>
		<tr>
			<td>character_gender</td>
			<td><input type="text" id="character_gender" name="character_gender"
					value="<?=$player['game']['character_gender']?>">
			</td>
		</tr>
		<tr>
			<td>character_avatar</td>
			<td><input type="text" id="character_avatar" name="character_avatar"
					value="<?=$player['game']['character_gender_long']?>###<?=$player['game']['character_avatar']?>">
			</td>
		</tr>
		<tr>
			<td>character_age</td>
			<td><input type="text" id="character_age" name="character_age"
					value="<?=$player['game']['character_age']?>">
			</td>
		</tr>
		<tr>
			<td>character_description</td>
			<td><input type="text" id="character_description" name="character_description"
					value="<?=$player['game']['character_description']?>">
			</td>
		</tr>
		<tr>
			<td>nationality</td>
			<td><input type="text" id="nationality" name="nationality"
					value="<?=$player['game']['nationality']?>">
			</td>
		</tr>
		<tr>
			<td>town</td>
			<td><input type="text" id="town" name="town"
					value="<?=$player['game']['town']?>">
			</td>
		</tr>
		<tr>
			<td>place</td>
			<td><input type="text" id="place" name="place"
					value="<?=$player['game']['place']?>">
			</td>
		</tr>
		<tr>
			<td>week</td>
			<td><input type="number" id="week" name="week"
					value="<?=$player['game']['week']?>">
			</td>
		</tr>
		<tr>
			<td>title</td>
			<td><input type="text" id="title" name="title"
					value="<?=$player['game']['title']?>">
			</td>
		</tr>
	</table>

	<h3>Possessions</h3>

	<table class="godmode">
		<tr>
			<th>Setting</th>
			<th>Value</th>
		</tr>

		<tr>
			<td>doubloons</td>
			<td><input type="number" id="doubloons" name="doubloons"
					value="<?=$player['game']['doubloons']?>">
			</td>
		</tr>
		<tr>
			<td>bank_account</td>
			<td><input type="number" id="bank_account" name="bank_account"
					value="<?=$player['game']['bank_account']?>">
			</td>
		</tr>
		<tr>
			<td>bank_loan</td>
			<td><input type="number" id="bank_loan" name="bank_loan"
					value="<?=$player['game']['bank_loan']?>">
			</td>
		</tr>
		<tr>
			<td>cannons</td>
			<td><input type="number" id="cannons" name="cannons"
					value="<?=$player['game']['cannons']?>">
			</td>
		</tr>
		<tr>
			<td>prisoners</td>
			<td><input type="number" id="prisoners" name="prisoners"
					value="<?=$player['game']['prisoners']?>">
			</td>
		</tr>
		<tr>
			<td>food</td>
			<td><input type="number" id="food" name="food"
					value="<?=$player['game']['food']?>">
			</td>
		</tr>
		<tr>
			<td>water</td>
			<td><input type="number" id="water" name="water"
					value="<?=$player['game']['water']?>">
			</td>
		</tr>
		<tr>
			<td>porcelain</td>
			<td><input type="number" id="porcelain" name="porcelain"
					value="<?=$player['game']['porcelain']?>">
			</td>
		</tr>
		<tr>
			<td>spices</td>
			<td><input type="number" id="spices" name="spices"
					value="<?=$player['game']['spices']?>">
			</td>
		</tr>
		<tr>
			<td>silk</td>
			<td><input type="number" id="silk" name="silk"
					value="<?=$player['game']['silk']?>">
			</td>
		</tr>
		<tr>
			<td>tobacco</td>
			<td><input type="number" id="tobacco" name="tobacco"
					value="<?=$player['game']['tobacco']?>">
			</td>
		</tr>
		<tr>
			<td>rum</td>
			<td><input type="number" id="rum" name="rum"
					value="<?=$player['game']['rum']?>">
			</td>
		</tr>
		<tr>
			<td>medicine</td>
			<td><input type="number" id="medicine" name="medicine"
					value="<?=$player['game']['medicine']?>">
			</td>
		</tr>
		<tr>
			<td>rafts</td>
			<td><input type="number" id="rafts" name="rafts"
					value="<?=$player['game']['rafts']?>">
			</td>
		</tr>
	</table>

	<h3>Victories</h3>

	<table class="godmode">
		<tr>
			<th>Setting</th>
			<th>Value</th>
		</tr>

		<tr>
			<td>victories_england</td>
			<td><input type="number" id="victories_england" name="victories_england"
					value="<?=$player['game']['victories_england']?>">
			</td>
		</tr>
		<tr>
			<td>victories_france</td>
			<td><input type="number" id="victories_france" name="victories_france"
					value="<?=$player['game']['victories_france']?>">
			</td>
		</tr>
		<tr>
			<td>victories_spain</td>
			<td><input type="number" id="victories_spain" name="victories_spain"
					value="<?=$player['game']['victories_spain']?>">
			</td>
		</tr>
		<tr>
			<td>victories_holland</td>
			<td><input type="number" id="victories_holland" name="victories_holland"
					value="<?=$player['game']['victories_holland']?>">
			</td>
		</tr>
		<tr>
			<td>victories_pirates</td>
			<td><input type="number" id="victories_pirates" name="victories_pirates"
					value="<?=$player['game']['victories_pirates']?>">
			</td>
		</tr>
	</table>

	<h3>Events</h3>

	<table class="godmode">
		<tr>
			<th>Setting</th>
			<th>Value</th>
		</tr>

		<tr>
			<td>event_market_goods</td>
			<td><input type="text" id="event_market_goods" name="event_market_goods"
					value="<?=$player['game']['event_market_goods']?>">
			</td>
		</tr>
		<tr>
			<td>event_market_slaves</td>
			<td><input type="text" id="event_market_slaves" name="event_market_slaves"
					value="<?=$player['game']['event_market_slaves']?>">
			</td>
		</tr>
		<tr>
			<td>event_sailors</td>
			<td><input type="text" id="event_sailors" name="event_sailors"
					value="<?=$player['game']['event_sailors']?>">
			</td>
		</tr>
		<tr>
			<td>event_work</td>
			<td><input type="text" id="event_work" name="event_work"
					value="<?=$player['game']['event_work']?>">
			</td>
		</tr>
		<tr>
			<td>event_ship</td>
			<td><input type="text" id="event_ship" name="event_ship"
					value="<?=$player['game']['event_ship']?>">
			</td>
		</tr>
		<tr>
			<td>event_ship_won</td>
			<td><input type="text" id="event_ship_won" name="event_ship_won"
					value="<?=$player['game']['event_ship_won']?>">
			</td>
		</tr>
		<tr>
			<td>event_ocean_trade</td>
			<td><input type="text" id="event_ocean_trade" name="event_ocean_trade"
					value="<?=$player['game']['event_ocean_trade']?>">
			</td>
		</tr>
	</table>

	<p class="text-right">
		<button type="submit">Save</button>
	</p>

</form>