<div class="container">
	<h3>Players</h3>

	<p>Here you can check out other players and contact them. They are sorted after activity.</p>

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
		<tr id="player_<?=$this_player['id']?>">
			<td width="40">
				<?php if (file_exists(APPPATH . '../assets/images/profile_pictures/' . $this_player['id'] . '_thumb.jpg')): ?>
				<img width="40" height="40"
					src="<?='assets/images/profile_pictures/' . $this_player['id'] . '_thumb.jpg'?>"
					alt="<?=$this_player['name']?>">
				<?php else: ?>
				<img width="40" height="40"
					src="<?='assets/images/profile_pictures/nopic_thumb.jpg'?>"
					alt="<?=$this_player['name']?>">
				<?php endif; ?>
			</td>

			<td>
				<a class="ajaxJSON"
					href="<?=base_url('inventory/user_remove/' . $user['id'] . '/' . $this_player['id'])?>"
					title="Erase this user" rel="Are you sure?">
					<svg width="16" height="16" alt="Remove">
						<use xlink:href="#trashcan"></use>
					</svg>
				</a>

				<a class="ajaxHTML"
					href="inventory/player/<?=$this_player['id']?>"><?=$this_player['name']?></a>
			</td>
			<td width="40"><img width="40" height="40"
					alt="Avatar of <?=$this_player['character_name']?>"
					src="<?=base_url('assets/images/avatars/' . (($this_player['character_gender'] == 'M') ? 'male_thumb' : 'female_thumb') . '/avatar_' . $this_player['character_avatar'] . '.jpg')?>">
			</td>
			<td>
				<?=$this_player['character_name']?>
			</td>
			<td>
				<?=$this_player['week']?>
			</td>
			<td>
				<?php
                $activity_color = $this_player['last_activity_unix'] > (time() - 500) ? '#3bb120"' : '#000';
            ?>

				<span style="color: <?=$activity_color?>">
					<?=substr($this_player['last_activity'], 0, -3)?>
				</span>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>

	<hr />

	<?php if ($user['admin'] == 1): ?>
	<h3>Temporary players</h3>

	<p class="text-right"><a class="ajaxJSON"
			href="<?=base_url('account/erase_temp_users')?>">Delete
			tempusers older than 24 hours</a></p>

	<table>
		<tr>
			<th>Character</th>
			<th>Week</th>
			<th>Created</th>
			<th>Active</th>
		</tr>

		<?php foreach ($temp_players as $this_player): ?>
		<tr id="player-<?=$this_player['id']?>">
			<td><a class="ajaxJSON"
					href="<?=base_url('inventory/user_remove/' . $user['id'] . '/' . $this_player['id'])?>"
					title="Erase this user" rel="Are you sure?">
					<svg width="16" height="16" alt="Remove">
						<use xlink:href="#trashcan"></use>
					</svg>
				</a>
				<a class="ajaxHTML"
					href="inventory/player/<?=$this_player['id']?>"><?=$this_player['character_name']?></a>
			</td>
			<td><?=$this_player['week']?>
			</td>
			<td><?=substr($this_player['created'], 0, -3)?>
			</td>
			<td><?=substr($this_player['last_activity'], 0, -3)?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php endif; ?>
</div>