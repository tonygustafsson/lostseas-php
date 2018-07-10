<header title="Players">
	<h3>Players</h3>
</header>

<p>Here you can check out other players and contact them. They are sorted after activity.</p>

<div id="msg"></div>

<table style="padding-bottom: 2em;">
	<tr>
		<th></th>
		<th>Name</th>
		<th></th>
		<th>Character</th>
		<th>Week</th>
		<th>Active</th>
	</tr>

	<?php foreach ($players as $this_player): ?>
		<tr id="player_<?php echo $this_player['id']?>">
			<td width="40">
				<?php if (file_exists(APPPATH . '../assets/images/profile_pictures/' . $this_player['id'] . '_thumb.jpg')): ?>
					<img width="40" height="40" src="<?php echo 'assets/images/profile_pictures/' . $this_player['id'] . '_thumb.jpg'?>" alt="<?php echo $this_player['name']?>">
				<?php else: ?>
					<img width="40" height="40" src="<?php echo 'assets/images/profile_pictures/nopic_thumb.jpg'?>" alt="<?php echo $this_player['name']?>">
				<?php endif; ?>
			</td>
			
			<td><a class="ajaxJSON" href="<?php echo base_url('inventory/user_remove/' . $user['id'] . '/' . $this_player['id'])?>" title="Erase this user" rel="Are you sure?"><img src="<?php echo base_url('assets/images/icons/erase.png')?>" width="16" height="16" alt="Erase"></a>
			    <a class="ajaxHTML" href="inventory/player/<?php echo $this_player['id']?>"><?php echo $this_player['name']?></a></td>
			<td width="40"><img width="40" height="40" alt="Avatar of <?php echo $this_player['character_name']?>" src="<?php echo base_url('assets/images/avatars/' . (($this_player['character_gender'] == 'M') ? 'male_thumb' : 'female_thumb') . '/avatar_' . $this_player['character_avatar'] . '.jpg')?>"></td>
			<td><?php echo $this_player['character_name']?></td>
			<td><?php echo $this_player['week']?></td>
			<td><span<?php echo (($this_player['last_activity_unix'] > (time() - 500)) ? ' style="color: #0FB308"' : '')?>><?php echo substr($this_player['last_activity'], 0, -3)?></span></td>
		</tr>
	<?php endforeach; ?>
</table>

<div class="divider"></div>

<?php if ($user['admin'] == 1): ?>
	<h3>Temporary players</h3>
	
	<p class="right"><a class="ajaxJSON" href="<?php echo base_url('account/erase_temp_users')?>">Delete tempusers older than 24 hours</a></p>
	
	<table>
		<tr>
			<th>Character</th>
			<th>Week</th>
			<th>Created</th>
			<th>Active</th>
		</tr>
	
		<?php foreach ($temp_players as $this_player): ?>
			<tr id="player-<?php echo $this_player['id']?>">
				<td><a class="ajaxJSON" href="<?php echo base_url('inventory/user_remove/' . $user['id'] . '/' . $this_player['id'])?>" title="Erase this user" rel="Are you sure?"><img src="<?php echo base_url('assets/images/icons/erase.png')?>" width="16" height="16" alt="Erase"></a>
				    <a class="ajaxHTML" href="inventory/player/<?php echo $this_player['id']?>"><?php echo $this_player['character_name']?></a></td>
				<td><?php echo $this_player['week']?></td>
				<td><?php echo substr($this_player['created'], 0, -3)?></td>
				<td><?php echo substr($this_player['last_activity'], 0, -3)?></td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php endif; ?>