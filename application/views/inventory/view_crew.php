<?php if (isset($json)): ?>
	<script type="text/javascript">
		$(document).ready(function () {
			gameManipulateDOM(<?php echo $json?>);
		});
	</script>
<?php endif; ?>

<?php if ($user['id'] == $player['user']['id']): ?>
	<header title="Inventory: Crew">
		<h3>Inventory: Crew</h3>
	</header>
<?php else: ?>
	<header title="About <?php echo $player['user']['name']?>">
		<h3>About <?php echo $player['user']['name']?>: Crew</h3>
	</header>
<?php endif; ?>

<section class="action-buttons">
	<a class="ajaxHTML" title="Learn more about <?php echo $player['user']['name']?>" href="inventory/player/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/players_user.png')?>" alt="User" width="32" height="32">Player</a>
	<a class="ajaxHTML" title="See <?php echo $player['game']['character_name']?>s ships" href="inventory/ships/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/coast.png')?>" alt="Character" width="32" height="32">Ships</a>
	<a class="ajaxHTML" title="See <?php echo $player['game']['character_name']?>s crew members" href="inventory/crew/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/tavern_sailor.png')?>" alt="Character" width="32" height="32">Crew</a>
	<?php if ($user['id'] == $player['user']['id'] || $player['user']['show_history'] == 1): ?>
		<a class="ajaxHTML" title="See graphs and data about <?php echo $player['game']['character_name']?>s history" href="inventory/history/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/history.png')?>" alt="Character" width="32" height="32">History</a>
		<a class="ajaxHTML" title="Check out <?php echo $player['game']['character_name']?>s log book" href="inventory/log/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/about_news.png')?>" alt="Log book" width="32" height="32">Log book</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="Say something to <?php echo $player['user']['name']?>" href="inventory/messages/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/players_messages.png')?>" alt="Messages" width="32" height="32">Messages</a>
</section>

<h4>Crew members</h4>

<p>You get more info about your crew members by holding your mouse over their names.</p>

<div id="msg"></div>

<?php if ($this->uri->segment(4) != ""): ?>
	<?php list($order, $direction) = explode("_", $this->uri->segment(4)); ?>
<?php endif; ?>

<?php if ($game['crew_members'] > 0): ?>

	<form id="crew_form" class="ajaxJSON" method="post" action="<?php echo base_url('inventory/crew_post/' . $user['id'])?>">

		<table style="padding-bottom: 30px;">
			<tr>
				<?php if ($this->user['user']['id'] == $this->user['player']['user']['id']): ?>
					<th><input type="checkbox" name="check_all" onchange="checkAll('crew')"></th>
				<?php endif; ?>
				<th><a class="ajaxHTML" href="<?php echo base_url('inventory/crew/' . $player['user']['id']) . '/name_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Name</a></th>
				<th><a class="ajaxHTML" href="<?php echo base_url('inventory/crew/' . $player['user']['id']) . '/nationality_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Nationality</a></th>
				<th><a class="ajaxHTML" href="<?php echo base_url('inventory/crew/' . $player['user']['id']) . '/created_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Created</a></th>
				<th><a class="ajaxHTML" href="<?php echo base_url('inventory/crew/' . $player['user']['id']) . '/doubloons_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Doubloons</a></th>
				<th><a class="ajaxHTML" href="<?php echo base_url('inventory/crew/' . $player['user']['id']) . '/mood_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Mood</a></th>
				<th><a class="ajaxHTML" href="<?php echo base_url('inventory/crew/' . $player['user']['id']) . '/health_' . ((isset($direction) && $direction == 'asc') ? 'desc' : 'asc')?>">Health</a></th>
			</tr>

			<?php foreach ($player['crew'] as $man): ?>
				<?php $man['gender'] = ($man['gender'] == 'M') ? 'man' : 'woman'?>
				<tr id="crew_<?php echo $man['id']?>">
					<?php if ($this->user['user']['id'] == $this->user['player']['user']['id']): ?>
						<td><input type="checkbox" id="box_<?php echo $man['id']?>" name="crew[]" value="<?php echo $man['id']?>"></td>
					<?php endif; ?>
					<td title="<?php echo $man['description']?>"><span class="crew_info"><img src="<?php echo base_url('assets/images/icons/crew_' . $man['gender'] . '.png')?>" alt="Crew member" width="16" height="17" title="<?php echo ucfirst($man['gender'])?>"> <?php echo $man['name']?></span></td>
					<td><?php echo ucfirst($man['nationality'])?></td>
					<td>Week <?php echo $man['created']?></td>
					<td><span id="crew_doubloons_<?php echo $man['id']?>"><?php echo $man['doubloons']?></span> dbl</td>
					<td><span id="crew_friendly_mood_<?php echo $man['id']?>"><?php echo ucfirst($man['friendly_mood'])?></span> (<span id="crew_mood_<?php echo $man['id']?>"><?php echo $man['mood']?></span>)</td>
					<td><span id="crew_health_<?php echo $man['id']?>"><?php echo $man['health']?></span> %</td>
					<td id="crew_info" style="display: none">
						<div style="width: 30%; float: left;">
							<img style="width: 100%;" src="<?php echo base_url('assets/images/icons/crew_member_' . $man['gender'] . '.png')?>" alt="Crew member">
						</div>
						<div style="padding-left: 5%; width: 65%; float: left;">
							<p><strong><?php echo $man['name']?></strong></p>
							<p style="font-size: 80%;"><?php echo $man['description']?></p>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>

		</table>

		<?php if ($this->user['user']['id'] == $this->user['player']['user']['id']): ?>
			<p style="text-align: right;">
				<select name="action[]">
					<?php foreach ($actions as $current_action => $description): ?>
						<?php if ((isset($player['game'][$current_action]) && $player['game'][$current_action] > 0) || $current_action == 'discard'): ?>
							<option value="<?php echo $current_action?>" <?php echo(($action == $current_action) ? 'selected="selected"' : '') ?>><?php echo $description?></option>
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