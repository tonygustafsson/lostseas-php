<header class="area-header" class="area-header" title="God Mode: User">
	<h3>God mode: User</h3>
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Change user parameters"
		href="godmode/user/<?=$this->uri->segment(3)?>">
		<svg width="32" height="32" alt="User">
			<use xlink:href="#player"></use>
		</svg>
		User
	</a>
	<a class="ajaxHTML" title="Change game parameters"
		href="godmode/index/<?=$this->uri->segment(3)?>">
		<svg width="32" height="32" alt="User">
			<use xlink:href="#swords"></use>
		</svg>
		Game
	</a>
	<a class="ajaxHTML" title="Change ship parameters"
		href="godmode/ship/<?=$this->uri->segment(3)?>">
		<svg width="32" height="32" alt="Ships">
			<use xlink:href="#ship"></use>
		</svg>
		Ships
	</a>
	<a class="ajaxHTML" title="Change crew parameters"
		href="godmode/crew/<?=$this->uri->segment(3)?>">
		<svg width="32" height="32" alt="Crew">
			<use xlink:href="#crew-man"></use>
		</svg>
		Crew
	</a>
</section>

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
			data-baseurl="<?=base_url('godmode/user')?>"
			href="<?=base_url('godmode/user/' . $user['id'])?>">Change</a>
	</form>
</section>

<form method="post" class="ajaxJSON"
	action="<?=base_url('godmode/user_update')?>">
	<input type="hidden" name="id"
		value="<?=$player['user']['id']?>">

	<h3>User</h3>

	<table class="godmode">
		<tr>
			<th>Setting</th>
			<th>Value</th>
		</tr>

		<tr>
			<td>name</td>
			<td><input type="text" id="name" name="name"
					value="<?=$player['user']['name']?>">
			</td>
		</tr>
		<tr>
			<td>gender</td>
			<td><input type="text" id="gender" name="gender"
					value="<?=$player['user']['gender']?>">
			</td>
		</tr>
		<tr>
			<td>birthday</td>
			<td><input type="text" id="birthday" name="birthday"
					value="<?=$player['user']['birthday']?>">
			</td>
		</tr>
		<tr>
			<td>email</td>
			<td><input type="text" id="email" name="email"
					value="<?=$player['user']['email']?>">
			</td>
		</tr>
	</table>

	<h3>Settings</h3>

	<table class="godmode">
		<tr>
			<th>Setting</th>
			<th>Value</th>
		</tr>

		<tr>
			<td>Verified</td>
			<td><input type="number" id="verified" name="verified"
					value="<?=$player['user']['verified']?>">
			</td>
		</tr>
		<tr>
			<td>admin</td>
			<td><input type="number" id="admin" name="admin"
					value="<?=$player['user']['admin']?>">
			</td>
		</tr>
		<tr>
			<td>music_play</td>
			<td><input type="number" id="music_play" name="music_play"
					value="<?=$player['user']['music_play']?>">
			</td>
		</tr>
		<tr>
			<td>music_volume</td>
			<td><input type="number" id="music_volume" name="music_volume"
					value="<?=$player['user']['music_volume']?>">
			</td>
		</tr>
		<tr>
			<td>sound_effects_play</td>
			<td><input type="number" id="sound_effects_play" name="sound_effects_play"
					value="<?=$player['user']['sound_effects_play']?>">
			</td>
		</tr>
		<tr>
			<td>show_gender</td>
			<td><input type="number" id="show_gender" name="show_gender"
					value="<?=$player['user']['show_gender']?>">
			</td>
		</tr>
		<tr>
			<td>show_age</td>
			<td><input type="number" id="show_age" name="show_age"
					value="<?=$player['user']['show_age']?>">
			</td>
		</tr>
		<tr>
			<td>show_email</td>
			<td><input type="number" id="show_email" name="show_email"
					value="<?=$player['user']['show_email']?>">
			</td>
		</tr>
		<tr>
			<td>show_history</td>
			<td><input type="number" id="show_history" name="show_history"
					value="<?=$player['user']['show_history']?>">
			</td>
		</tr>
		<tr>
			<td>notify_new_messages</td>
			<td><input type="number" id="notify_new_messages" name="notify_new_messages"
					value="<?=$player['user']['notify_new_messages']?>">
			</td>
		</tr>
	</table>

	<h3>Presentation</h3>

	<table class="godmode">
		<tr>
			<td style="padding-top: 1em;"><textarea
					name="presentation"><?=$player['user']['presentation']?></textarea>
			</td>
		</tr>
	</table>

	<p class="text-right">
		<button type="submit">Save</button>
	</p>

</form>