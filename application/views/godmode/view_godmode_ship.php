<header title="God Mode: Ship">
	<h3>God mode: Ship</h3>
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Change user parameters" href="godmode/user/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/players_user.png')?>" alt="User" width="32" height="32">User</a>
	<a class="ajaxHTML" title="Change game parameters" href="godmode/index/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/settings_character.png')?>" alt="Game" width="32" height="32">Game</a>
	<a class="ajaxHTML" title="Change ship parameters" href="godmode/ship/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/shipyard_sell.png')?>" alt="Ship" width="32" height="32">Ships</a>
	<a class="ajaxHTML" title="Change crew parameters" href="godmode/crew/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/tavern_sailor.png')?>" alt="Crew" width="32" height="32">Crew</a>
</section>

<section class="action-buttons">
	<form method="post" id="godmode_change_user" action="">
		<select name="godmode_change_user">
			<?php foreach ($players as $this_player): ?>
				<?php if (empty($this_player['name'])): ?>
					<?php if ($player['user']['id'] === $this_player['id']): ?>
						<option value="<?=$this_player['id']?>" selected>TempUser (<?=$this_player['id']?>)</option>
					<?php else: ?>
						<option value="<?=$this_player['id']?>">TempUser (<?=$this_player['id']?>)</option>
					<?php endif; ?>
				<?php else: ?>
					<?php if ($player['user']['id'] === $this_player['id']): ?>
						<option value="<?=$this_player['id']?>" selected><?=$this_player['name']?> (<?=$this_player['id']?>)</option>
					<?php else: ?>
						<option value="<?=$this_player['id']?>"><?=$this_player['name']?> (<?=$this_player['id']?>)</option>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
		
		<a id="godmode_change_user_url" class="ajaxHTML nopic" data-baseurl="<?=base_url('godmode/ship')?>" href="<?=base_url('godmode/ship/' . $user['id'])?>">Change</a>
	</form>
</section>

<p style="text-align: right;"><a class="ajaxJSON" href="<?=base_url('godmode/ship_create/' . $player['user']['id'])?>" title="Create new ship"><img src="<?=base_url('assets/images/icons/add_item.png')?>" alt="Add"></a></p>

<form method="post" class="ajaxJSON" action="<?=base_url('godmode/ship_update')?>">
	<input type="hidden" name="user_id" value="<?=$player['user']['id']?>">

	<table class="godmode" id="ship_table">
		<tr>
			<th>Name</th>
			<th>Type <a class="js-godmode-change-all-in-column" data-change-for="type" href="#" title="Change type for all ships"><img src="<?=base_url('assets/images/icons/change_all.png')?>" alt="Change all"></a></th>
			<th>Age <a class="js-godmode-change-all-in-column" data-change-for="age" href="#" title="Change age for all ships"><img src="<?=base_url('assets/images/icons/change_all.png')?>" alt="Change all"></a></th>
			<th>Health <a class="js-godmode-change-all-in-column" data-change-for="health" href="#" title="Change health for all ships"><img src="<?=base_url('assets/images/icons/change_all.png')?>" alt="Change all"></a></th>
		</tr>
		
		<?php foreach ($player_ships as $current_ship): ?>
			<tr id="<?=$current_ship['id']?>_row">
				<td>
					<a class="ajaxJSON" href="<?=base_url('godmode/ship_delete')?>/<?=$current_ship['id']?>" title="Delete ship"><img src="<?=base_url('assets/images/icons/delete.png')?>" alt="Delete"></a>
				    <input type="text" id="<?=$current_ship['id']?>_name" name="<?=$current_ship['id']?>_name" value="<?=$current_ship['name']?>">
				</td>
				<td><input type="text" id="<?=$current_ship['id']?>_type" name="<?=$current_ship['id']?>_type" value="<?=$current_ship['type']?>"></td>
				<td><input type="number" id="<?=$current_ship['id']?>_age" name="<?=$current_ship['id']?>_age" value="<?=$current_ship['age']?>"></td>
				<td><input type="number" id="<?=$current_ship['id']?>_health" name="<?=$current_ship['id']?>_health" value="<?=$current_ship['health']?>"></td>
			</tr>
		<?php endforeach; ?>
		
	</table>
	
	<p style="text-align: right">
		<input type="submit" value="Save">
	</p>

</form>