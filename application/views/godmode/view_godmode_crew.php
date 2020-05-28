<header title="God Mode: Crew">
	<h3>God mode: Crew</h3>
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Change user parameters" href="godmode/user/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/players_user.png')?>" alt="User" width="32" height="32">User</a>
	<a class="ajaxHTML" title="Change game parameters" href="godmode/index/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/settings_character.png')?>" alt="Game" width="32" height="32">Game</a>
	<a class="ajaxHTML" title="Change ship parameters" href="godmode/ship/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/shipyard_sell.png')?>" alt="Ship" width="32" height="32">Ships</a>
	<a class="ajaxHTML" title="Change crew parameters" href="godmode/crew/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/tavern_sailor.png')?>" alt="Crew" width="32" height="32">Crew</a>
</section>

<section class="action-buttons">
	<form method="post" id="godmode_change_user" action="">
		<select name="godmode_change_user">
			<?php foreach ($players as $this_player): ?>
				<?php if (empty($this_player['name'])): ?>
					<?php if ($player['user']['id'] === $this_player['id']): ?>
						<option value="<?php echo $this_player['id']?>" selected>TempUser (<?php echo $this_player['id']?>)</option>
					<?php else: ?>
						<option value="<?php echo $this_player['id']?>">TempUser (<?php echo $this_player['id']?>)</option>
					<?php endif; ?>
				<?php else: ?>
					<?php if ($player['user']['id'] === $this_player['id']): ?>
						<option value="<?php echo $this_player['id']?>" selected><?php echo $this_player['name']?> (<?php echo $this_player['id']?>)</option>
					<?php else: ?>
						<option value="<?php echo $this_player['id']?>"><?php echo $this_player['name']?> (<?php echo $this_player['id']?>)</option>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
		
		<a id="godmode_change_user_url" class="ajaxHTML nopic" data-baseurl="<?php echo base_url('godmode/crew')?>" href="<?php echo base_url('godmode/crew/' . $user['id'])?>">Change</a>
	</form>
</section>

<p style="text-align: right;"><a class="ajaxJSON" href="<?php echo base_url('godmode/crew_create/' . $player['user']['id'])?>" title="Create new crew member"><img src="<?php echo base_url('assets/images/icons/add_item.png')?>" alt="Add user"></a></p>

<form method="post" class="ajaxJSON" action="<?php echo base_url('godmode/crew_update')?>">
	<input type="hidden" name="user_id" value="<?php echo $player['user']['id']?>">
	
	<table id="crew_table" class="godmode">
		<tr>
			<th>Name</th>
			<th>Mood <a href="javascript:godmodeChangeAll('mood')" title="Change mood for all crew members"><img src="<?php echo base_url('assets/images/icons/change_all.png')?>" alt="Change all"></a></th>
			<th>Health <a href="javascript:godmodeChangeAll('health')" title="Change health for all crew members"><img src="<?php echo base_url('assets/images/icons/change_all.png')?>" alt="Change all"></a></th>
			<th>Doubloons <a href="javascript:godmodeChangeAll('doubloons')" title="Change doubloons for all crew members"><img src="<?php echo base_url('assets/images/icons/change_all.png')?>" alt="Change all"></a></th>
		</tr>
		
		<?php foreach ($crew as $current_crew): ?>
			<tr id="<?php echo $current_crew['id']?>_row">
				<td>
					<a class="ajaxJSON" href="<?php echo base_url('godmode/crew_delete')?>/<?php echo $current_crew['id']?>" title="Delete crew member"><img src="<?php echo base_url('assets/images/icons/delete.png')?>" alt="Delete"></a>
				    <input type="text" id="<?php echo $current_crew['id']?>_name" name="<?php echo $current_crew['id']?>_name" value="<?php echo $current_crew['name']?>">
				</td>
				<td><input type="number" id="<?php echo $current_crew['id']?>_mood" name="<?php echo $current_crew['id']?>_mood" value="<?php echo $current_crew['mood']?>"></td>
				<td><input type="number" id="<?php echo $current_crew['id']?>_health" name="<?php echo $current_crew['id']?>_health" value="<?php echo $current_crew['health']?>"></td>
				<td><input type="number" id="<?php echo $current_crew['id']?>_doubloons" name="<?php echo $current_crew['id']?>_doubloons" value="<?php echo $current_crew['doubloons']?>"></td>
			</tr>
		<?php endforeach; ?>
		
	</table>
	
	<p style="text-align: right">
		<input type="submit" value="Save">
	</p>
	
</form>