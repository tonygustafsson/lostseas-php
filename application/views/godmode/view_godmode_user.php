<header title="God Mode: User">
	<h3>God mode: User</h3>
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Change user parameters" href="godmode/user/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/players_user.png')?>" alt="User" width="32" height="32">User</a>
	<a class="ajaxHTML" title="Change game parameters" href="godmode/index/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/settings_character.png')?>" alt="Game" width="32" height="32">Game</a>
	<a class="ajaxHTML" title="Change ship parameters" href="godmode/ship/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/shipyard_sell.png')?>" alt="Ship" width="32" height="32">Ships</a>
	<a class="ajaxHTML" title="Change crew parameters" href="godmode/crew/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/tavern_sailor.png')?>" alt="Crew" width="32" height="32">Crew</a>
</section>

<div id="msg"></div>

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
		
		<a id="godmode_change_user_url" class="ajaxHTML nopic" data-baseurl="<?php echo base_url('godmode/user')?>" href="<?php echo base_url('godmode/user/' . $user['id'])?>">Change</a>
	</form>
</section>

<form method="post" class="ajaxJSON" action="<?php echo base_url('godmode/user_update')?>">
	<input type="hidden" name="id" value="<?php echo $player['user']['id']?>">

	<h3>User</h3>
	
	<table class="godmode">
		<tr>
			<th>Setting</th>
			<th>Value</th>
		</tr>
		
		<tr><td>name</td><td><input type="text" id="name" name="name" value="<?php echo $player['user']['name']?>"></td></tr>
		<tr><td>gender</td><td><input type="text" id="gender" name="gender" value="<?php echo $player['user']['gender']?>"></td></tr>
		<tr><td>birthday</td><td><input type="text" id="birthday" name="birthday" value="<?php echo $player['user']['birthday']?>"></td></tr>
		<tr><td>email</td><td><input type="text" id="email" name="email" value="<?php echo $player['user']['email']?>"></td></tr>
	</table>
	
	<h3>Settings</h3>
	
	<table class="godmode">
		<tr>
			<th>Setting</th>
			<th>Value</th>
		</tr>
		
		<tr><td>admin</td><td><input type="number" id="admin" name="admin" value="<?php echo $player['user']['admin']?>"></td></tr>
		<tr><td>music_play</td><td><input type="number" id="music_play" name="music_play" value="<?php echo $player['user']['music_play']?>"></td></tr>
		<tr><td>music_volume</td><td><input type="number" id="music_volume" name="music_volume" value="<?php echo $player['user']['music_volume']?>"></td></tr>
		<tr><td>sound_effects_play</td><td><input type="number" id="sound_effects_play" name="sound_effects_play" value="<?php echo $player['user']['sound_effects_play']?>"></td></tr>
		<tr><td>show_gender</td><td><input type="number" id="show_gender" name="show_gender" value="<?php echo $player['user']['show_gender']?>"></td></tr>
		<tr><td>show_age</td><td><input type="number" id="show_age" name="show_age" value="<?php echo $player['user']['show_age']?>"></td></tr>
		<tr><td>show_email</td><td><input type="number" id="show_email" name="show_email" value="<?php echo $player['user']['show_email']?>"></td></tr>
		<tr><td>show_history</td><td><input type="number" id="show_history" name="show_history" value="<?php echo $player['user']['show_history']?>"></td></tr>
		<tr><td>notify_new_messages</td><td><input type="number" id="notify_new_messages" name="notify_new_messages" value="<?php echo $player['user']['notify_new_messages']?>"></td></tr>
	</table>

	<h3>Presentation</h3>
	
	<table class="godmode">
		<tr><td style="padding-top: 1em;"><textarea name="presentation"><?php echo $player['user']['presentation']?></textarea></td></tr>
	</table>

	<p style="text-align: right">
		<input type="submit" value="Save">
	</p>

</form>