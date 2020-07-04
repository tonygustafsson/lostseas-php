<div class="container">
	<h3>God mode: Ship</h3>

	<div class="button-area">
		<a class="ajaxHTML button big-icon" title="Change user parameters"
			href="<?=base_url('godmode/user/' . $this->uri->segment(3))?>">
			<svg width="32" height="32" alt="User">
				<use xlink:href="#player"></use>
			</svg>
			User
		</a>
		<a class="ajaxHTML button big-icon" title="Change game parameters"
			href="<?=base_url('godmode/index/' . $this->uri->segment(3))?>">
			<svg width="32" height="32" alt="User">
				<use xlink:href="#swords"></use>
			</svg>
			Game
		</a>
		<a class="ajaxHTML button big-icon" title="Change ship parameters"
			href="<?=base_url('godmode/ship/' . $this->uri->segment(3))?>">
			<svg width="32" height="32" alt="Ships">
				<use xlink:href="#ship"></use>
			</svg>
			Ships
		</a>
		<a class="ajaxHTML button big-icon" title="Change crew parameters"
			href="<?=base_url('godmode/crew/' . $this->uri->segment(3))?>">
			<svg width="32" height="32" alt="Crew">
				<use xlink:href="#crew-man"></use>
			</svg>
			Crew
		</a>
		<a class="ajaxHTML button big-icon" title="View design system"
			href="<?=base_url('godmode/design/' . $this->uri->segment(3))?>">
			<svg width="32" height="32" alt="Crew">
				<use xlink:href="#design"></use>
			</svg>
			Design
		</a>
	</div>

	<div class="text-center">
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

	<p style="text-align: right;"><a class="ajaxJSON"
			href="<?=base_url('godmode/ship_create/' . $player['user']['id'])?>"
			title="Create new ship">
			<svg width="32" height="32" alt="Add new">
				<use xlink:href="#add"></use>
			</svg>
		</a>
	</p>

	<form method="post" class="ajaxJSON"
		action="<?=base_url('godmode/ship_update')?>">
		<input type="hidden" name="user_id"
			value="<?=$player['user']['id']?>">

		<table class="godmode" id="ship_table">
			<tr>
				<th>Name</th>
				<th>Type <a class="js-godmode-change-all-in-column" data-change-for="type" href="#"
						title="Change type for all ships">
						<svg width="16" height="16" alt="Change all">
							<use xlink:href="#pencil"></use>
						</svg>
					</a>
				</th>
				<th>Age <a class="js-godmode-change-all-in-column" data-change-for="age" href="#"
						title="Change age for all ships">
						<svg width="16" height="16" alt="Change all">
							<use xlink:href="#pencil"></use>
						</svg>
					</a>
				</th>
				<th>Health <a class="js-godmode-change-all-in-column" data-change-for="health" href="#"
						title="Change health for all ships">
						<svg width="16" height="16" alt="Change all">
							<use xlink:href="#pencil"></use>
						</svg>
					</a>
				</th>
			</tr>

			<?php foreach ($player_ships as $current_ship): ?>
			<tr
				id="<?=$current_ship['id']?>_row">
				<td>
					<div class="flex flex-align-center">
						<a class="ajaxJSON"
							href="<?=base_url('godmode/ship_delete')?>/<?=$current_ship['id']?>"
							title="Delete ship">
							<svg width="16" height="16" alt="Delete">
								<use xlink:href="#broom"></use>
							</svg>
						</a>
						<input type="text"
							id="<?=$current_ship['id']?>_name"
							name="<?=$current_ship['id']?>_name"
							value="<?=$current_ship['name']?>">
					</div>
				</td>
				<td><input type="text"
						id="<?=$current_ship['id']?>_type"
						name="<?=$current_ship['id']?>_type"
						value="<?=$current_ship['type']?>">
				</td>
				<td><input type="number"
						id="<?=$current_ship['id']?>_age"
						name="<?=$current_ship['id']?>_age"
						value="<?=$current_ship['age']?>">
				</td>
				<td><input type="number"
						id="<?=$current_ship['id']?>_health"
						name="<?=$current_ship['id']?>_health"
						value="<?=$current_ship['health']?>">
				</td>
			</tr>
			<?php endforeach; ?>

		</table>

		<p class="text-right">
			<button type="submit">Save</button>
		</p>
	</form>
</div>