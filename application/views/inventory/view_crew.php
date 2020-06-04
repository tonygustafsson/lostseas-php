<?php if ($user['id'] == $player['user']['id']): ?>
	<header title="Inventory: Crew">
		<h3>Inventory: Crew</h3>
	</header>
<?php else: ?>
	<header title="About <?=$player['user']['name']?>">
		<h3>About <?=$player['user']['name']?>: Crew</h3>
	</header>
<?php endif; ?>

<section class="action-buttons">
	<a class="ajaxHTML" title="Learn more about <?=$player['user']['name']?>" href="inventory/player/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/players_user.png')?>" alt="User" width="32" height="32">Player</a>
	<a class="ajaxHTML" title="See <?=$player['game']['character_name']?>s ships" href="inventory/ships/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/coast.png')?>" alt="Character" width="32" height="32">Ships</a>
	<a class="ajaxHTML" title="See <?=$player['game']['character_name']?>s crew members" href="inventory/crew/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/tavern_sailor.png')?>" alt="Character" width="32" height="32">Crew</a>
	<?php if ($user['id'] == $player['user']['id'] || $player['user']['show_history'] == 1): ?>
		<a class="ajaxHTML" title="See graphs and data about <?=$player['game']['character_name']?>s history" href="inventory/history/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/history.png')?>" alt="Character" width="32" height="32">History</a>
		<a class="ajaxHTML" title="Check out <?=$player['game']['character_name']?>s log book" href="inventory/log/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/about_news.png')?>" alt="Log book" width="32" height="32">Log book</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="Say something to <?=$player['user']['name']?>" href="inventory/messages/<?=$this->uri->segment(3)?>"><img src="<?=base_url('assets/images/icons/players_messages.png')?>" alt="Messages" width="32" height="32">Messages</a>
</section>

<h4>Crew members</h4>

<p>You get more info about your crew members by holding your mouse over their names.</p>

<?php if ($this->uri->segment(4) != ""): ?>
	<?php list($order, $direction) = explode("_", $this->uri->segment(4)); ?>
<?php endif; ?>

<?php if ($game['crew_members'] > 0): ?>

	<form id="crew_form" class="ajaxJSON" method="post" action="<?=base_url('inventory/crew_post/' . $user['id'])?>">

		<table style="padding-bottom: 30px;">
			<tr>
				<?php if ($this->data['user']['id'] == $this->data['player']['user']['id']): ?>
					<th><input class="js-inventory-check-all" data-select="crew" type="checkbox" name="check_all" /></th>
				<?php endif; ?>
				<th><a class="ajaxHTML" href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/name_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Name</a></th>
				<th><a class="ajaxHTML" href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/nationality_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Nationality</a></th>
				<th><a class="ajaxHTML" href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/created_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Created</a></th>
				<th><a class="ajaxHTML" href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/doubloons_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Doubloons</a></th>
				<th><a class="ajaxHTML" href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/mood_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Mood</a></th>
				<th><a class="ajaxHTML" href="<?=base_url('inventory/crew/' . $player['user']['id']) . '/health_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Health</a></th>
			</tr>

			<?php foreach ($player['crew'] as $man): ?>
				<?php $man['gender'] = ($man['gender'] == 'M') ? 'man' : 'woman'?>
				<tr id="crew_<?=$man['id']?>">
					<?php if ($this->data['user']['id'] == $this->data['player']['user']['id']): ?>
						<td><input type="checkbox" id="crew-checkbox-<?=$man['id']?>" name="crew[]" value="<?=$man['id']?>"></td>
					<?php endif; ?>
					<td>
						<span class="tooltip-multiline tooltip-bottom-left" data-tooltip="<?=$man['description']?>">
							<img src="<?=base_url('assets/images/icons/crew_' . $man['gender'] . '.png')?>" alt="Crew member" width="16" height="17">
							<?=$man['name']?>
						</span>
					</td>
					<td><?=ucfirst($man['nationality'])?></td>
					<td>Week <?=$man['created']?></td>
					<td><span id="crew_doubloons_<?=$man['id']?>"><?=$man['doubloons']?></span> dbl</td>
					<td><span id="crew_friendly_mood_<?=$man['id']?>"><?=ucfirst($man['friendly_mood'])?></span> (<span id="crew_mood_<?=$man['id']?>"><?=$man['mood']?></span>)</td>
					<td><span id="crew_health_<?=$man['id']?>"><?=$man['health']?></span> %</td>
				</tr>
			<?php endforeach; ?>

		</table>

		<?php if ($this->data['user']['id'] == $this->data['player']['user']['id']): ?>
			<p style="text-align: right;">
				<select name="action[]">
					<?php foreach ($actions as $current_action => $description): ?>
						<?php if ((isset($player['game'][$current_action]) && $player['game'][$current_action] > 0) || $current_action == 'discard'): ?>
							<option value="<?=$current_action?>" <?php echo(($action == $current_action) ? 'selected="selected"' : '') ?>><?=$description?></option>
						<?php endif; ?>
					<?php endforeach; ?>
				</select>

				<input type="submit" value="Do it">
			</p>
		<?php endif; ?>
	
	</form>

<?php else: ?>
	<p><em>You are not companied any crew members...</em></p>
<?php endif; ?>