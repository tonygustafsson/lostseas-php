<div class="container">
	<h3>God mode: Game</h3>

	<div class="button-area">
		<a class="ajaxHTML button big-icon" title="Change user parameters"
			href="<?=base_url('godmode/user/' . $this->uri->segment(3))?>">
			<svg width="32" height="32" alt="User">
				<use xlink:href="#icon-player"></use>
			</svg>
			User
		</a>
		<a class="ajaxHTML button big-icon" title="Change game parameters"
			href="<?=base_url('godmode/index/' . $this->uri->segment(3))?>">
			<svg width="32" height="32" alt="User">
				<use xlink:href="#icon-swords"></use>
			</svg>
			Game
		</a>
		<a class="ajaxHTML button big-icon" title="Change ship parameters"
			href="<?=base_url('godmode/ship/' . $this->uri->segment(3))?>">
			<svg width="32" height="32" alt="Ships">
				<use xlink:href="#icon-ship"></use>
			</svg>
			Ships
		</a>
		<a class="ajaxHTML button big-icon" title="Change crew parameters"
			href="<?=base_url('godmode/crew/' . $this->uri->segment(3))?>">
			<svg width="32" height="32" alt="Crew">
				<use xlink:href="#icon-crew-man"></use>
			</svg>
			Crew
		</a>
		<a class="ajaxHTML button big-icon" title="View design system"
			href="<?=base_url('godmode/design/' . $this->uri->segment(3))?>">
			<svg width="32" height="32" alt="Crew">
				<use xlink:href="#icon-design"></use>
			</svg>
			Design
		</a>
	</div>

	<div class="text-center mt-4 mb-4">
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
					TempUser (<?=$this_player['id']?>)
				</option>
				<?php endif; ?>
				<?php else: ?>
				<?php if ($player['user']['id'] === $this_player['id']): ?>
				<option
					value="<?=$this_player['id']?>"
					selected><?=$this_player['name']?>
					(<?=$this_player['id']?>)
				</option>
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

			<a id="godmode_change_user_url" class="ajaxHTML"
				data-baseurl="<?=base_url('godmode/index')?>"
				href="<?=base_url('godmode/index/' . $user['id'])?>">Change</a>
		</form>
	</div>

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
				<td>Name</td>
				<td><input type="text" id="character_name" name="character_name"
						value="<?=$player['game']['character_name']?>">
				</td>
			</tr>
			<tr>
				<td>Gender</td>
				<td><input type="text" id="character_gender" name="character_gender"
						value="<?=$player['game']['character_gender']?>">
				</td>
			</tr>
			<tr>
				<td>Avatar</td>
				<td><input type="text" id="character_avatar" name="character_avatar"
						value="<?=$player['game']['character_avatar']?>">
				</td>
			</tr>
			<tr>
				<td>Age</td>
				<td><input type="text" id="character_age" name="character_age"
						value="<?=$player['game']['character_age']?>">
				</td>
			</tr>
			<tr>
				<td>Description</td>
				<td><input type="text" id="character_description" name="character_description"
						value="<?=$player['game']['character_description']?>">
				</td>
			</tr>
			<tr>
				<td>Nationality</td>
				<td><input type="text" id="nationality" name="nationality"
						value="<?=$player['game']['nationality']?>">
				</td>
			</tr>
			<tr>
				<td>Town</td>
				<td><input type="text" id="town" name="town"
						value="<?=$player['game']['town']?>">
				</td>
			</tr>
			<tr>
				<td>Place</td>
				<td><input type="text" id="place" name="place"
						value="<?=$player['game']['place']?>">
				</td>
			</tr>
			<tr>
				<td>Week</td>
				<td><input type="number" id="week" name="week"
						value="<?=$player['game']['week']?>">
				</td>
			</tr>
			<tr>
				<td>Title</td>
				<td><input type="text" id="title" name="title"
						value="<?=$player['game']['title']?>">
				</td>
			</tr>
			<tr>
				<td>Level</td>
				<td><input type="text" id="level" name="level"
						value="<?=$player['game']['level']?>">
				</td>
			</tr>
		</table>

		<hr />

		<h3>Possessions</h3>

		<table class="godmode">
			<tr>
				<th>Setting</th>
				<th>Value</th>
			</tr>

			<tr>
				<td>Doubloons</td>
				<td><input type="number" id="doubloons" name="doubloons"
						value="<?=$player['game']['doubloons']?>">
				</td>
			</tr>
			<tr>
				<td>Bank account</td>
				<td><input type="number" id="bank_account" name="bank_account"
						value="<?=$player['game']['bank_account']?>">
				</td>
			</tr>
			<tr>
				<td>Bank loan</td>
				<td><input type="number" id="bank_loan" name="bank_loan"
						value="<?=$player['game']['bank_loan']?>">
				</td>
			</tr>
			<tr>
				<td>Cannons</td>
				<td><input type="number" id="cannons" name="cannons"
						value="<?=$player['game']['cannons']?>">
				</td>
			</tr>
			<tr>
				<td>Prisoners</td>
				<td><input type="number" id="prisoners" name="prisoners"
						value="<?=$player['game']['prisoners']?>">
				</td>
			</tr>
			<tr>
				<td>Food</td>
				<td><input type="number" id="food" name="food"
						value="<?=$player['game']['food']?>">
				</td>
			</tr>
			<tr>
				<td>Water</td>
				<td><input type="number" id="water" name="water"
						value="<?=$player['game']['water']?>">
				</td>
			</tr>
			<tr>
				<td>Porcelain</td>
				<td><input type="number" id="porcelain" name="porcelain"
						value="<?=$player['game']['porcelain']?>">
				</td>
			</tr>
			<tr>
				<td>Spices</td>
				<td><input type="number" id="spices" name="spices"
						value="<?=$player['game']['spices']?>">
				</td>
			</tr>
			<tr>
				<td>Silk</td>
				<td><input type="number" id="silk" name="silk"
						value="<?=$player['game']['silk']?>">
				</td>
			</tr>
			<tr>
				<td>Tobacco</td>
				<td><input type="number" id="tobacco" name="tobacco"
						value="<?=$player['game']['tobacco']?>">
				</td>
			</tr>
			<tr>
				<td>Rum</td>
				<td><input type="number" id="rum" name="rum"
						value="<?=$player['game']['rum']?>">
				</td>
			</tr>
			<tr>
				<td>Medicine</td>
				<td><input type="number" id="medicine" name="medicine"
						value="<?=$player['game']['medicine']?>">
				</td>
			</tr>
			<tr>
				<td>Rafts</td>
				<td><input type="number" id="rafts" name="rafts"
						value="<?=$player['game']['rafts']?>">
				</td>
			</tr>
		</table>

		<hr />

		<h3>Stocks</h3>

		<table class="godmode">
			<tr>
				<th>Setting</th>
				<th>Value</th>
			</tr>

			<tr>
				<td>Stocks</td>
				<td>
					<textarea id="stocks"
						name="stocks"><?=json_encode($player['game']['stocks'])?></textarea>
				</td>
			</tr>
		</table>

		<hr />

		<h3>Victories</h3>

		<table class="godmode">
			<tr>
				<th>Setting</th>
				<th>Value</th>
			</tr>

			<tr>
				<td>Victories</td>
				<td>
					<textarea id="victories"
						name="victories"><?=json_encode($player['game']['victories'])?></textarea>
				</td>
			</tr>
		</table>

		<hr />

		<h3>Events</h3>

		<table class="godmode">
			<tr>
				<th>Setting</th>
				<th>Value</th>
			</tr>
			<tr>
				<td>Event</td>
				<td>
					<textarea id="event"
						name="event"><?=json_encode($player['game']['event'])?></textarea>
				</td>
			</tr>
			<tr>
				<td>Reset events</td>
				<td>
					<a class="ajaxJSON button small"
						href="<?=base_url('godmode/reset_event/tavern_blackjack/' . $player['user']['id'])?>">Tavern
						Black
						Jack</a>

					<a class="ajaxJSON button small"
						href="<?=base_url('godmode/reset_event/tavern_sailors/' . $player['user']['id'])?>">Tavern
						Sailors</a>

					<a class="ajaxJSON button small"
						href="<?=base_url('godmode/reset_event/market/' . $player['user']['id'])?>">Market</a>

					<a class="ajaxJSON button small"
						href="<?=base_url('godmode/reset_event/cityhall_work/' . $player['user']['id'])?>">Cityhall
						Work</a>

					<a class="ajaxJSON button small"
						href="<?=base_url('godmode/reset_event/ship_meeting/' . $player['user']['id'])?>">Ship
						meeting</a>

					<a class="ajaxJSON button small"
						href="<?=base_url('godmode/reset_event/ship_won_results/' . $player['user']['id'])?>">Ship
						won results</a>

					<a class="ajaxJSON button small"
						href="<?=base_url('godmode/reset_event/ship_trade/' . $player['user']['id'])?>">Ship
						trade</a>
				</td>
			</tr>
		</table>

		<p class="text-right">
			<button type="submit">Save</button>
		</p>
	</form>
</div>