<?php if (isset($json)): ?>
	<script type="text/javascript">
		$(document).ready(function () {
			gameManipulateDOM(<?php echo $json?>);
		});
	</script>
<?php endif; ?>

<?php if ($user['id'] == $player['user']['id']): ?>
	<header title="Inventory: Status">
		<h3>Inventory: History</h3>
	</header>
<?php else: ?>
	<header title="About <?php echo $player['user']['name']?>">
		<h3>About <?php echo $player['user']['name']?>: History</h3>
	</header>
<?php endif; ?>

<section class="actions">
	<a class="ajaxHTML" title="Learn more about <?php echo $player['user']['name']?>" href="inventory/player/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/players_user.png')?>" alt="User" width="32" height="32">Player</a>
	<a class="ajaxHTML" title="See <?php echo $player['game']['character_name']?>s ships" href="inventory/ships/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/coast.png')?>" alt="Character" width="32" height="32">Ships</a>
	<a class="ajaxHTML" title="See <?php echo $player['game']['character_name']?>s crew members" href="inventory/crew/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/tavern_sailor.png')?>" alt="Character" width="32" height="32">Crew</a>
	<?php if ($user['id'] == $player['user']['id'] || $player['user']['show_history'] == 1): ?>
		<a class="ajaxHTML" title="See graphs and data about <?php echo $player['game']['character_name']?>s history" href="inventory/history/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/history.png')?>" alt="Character" width="32" height="32">History</a>
		<a class="ajaxHTML" title="Check out <?php echo $player['game']['character_name']?>s log book" href="inventory/log/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/about_news.png')?>" alt="Log book" width="32" height="32">Log book</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="Say something to <?php echo $player['user']['name']?>" href="inventory/messages/<?php echo $this->uri->segment(3)?>"><img src="<?php echo base_url('assets/images/icons/players_messages.png')?>" alt="Messages" width="32" height="32">Messages</a>
</section>

<div class="divider"></div>

<h4>History</h4>

<p>You can change the history by using the form below.</p>

<?php if (isset($history)): ?>
	<section class="actions">
		<form method="post" class="ajaxJSON" action="<?php echo base_url('inventory/history/' . $this->uri->segment(3))?>">
			<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url('inventory/history/' . $this->uri->segment(3))?>">
		
			Weeks:
			<select name="weeks" id="history_weeks">
				<?php foreach ($history_weeks as $week): ?>
					<?php if ($this->uri->segment(5) != ""): ?>
						<?php if ($week == $this->uri->segment(5)): ?>
							<option value="<?php echo $week?>" selected><?php echo $week?></option>
						<?php else: ?>
							<option value="<?php echo $week?>"><?php echo $week?></option>
						<?php endif; ?>
					<?php else: ?>
						<?php if ($week == 20): ?>
							<option value="<?php echo $week?>" selected><?php echo $week?></option>
						<?php else: ?>
							<option value="<?php echo $week?>"><?php echo $week?></option>
						<?php endif; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
			
			Data:
			<select name="data" id="history_data">
				<?php foreach ($history_data as $key => $val): ?>
					<?php if ($this->uri->segment(4) != ""): ?>
						<?php if ($key == $this->uri->segment(4)): ?>
							<option value="<?php echo $key?>" selected><?php echo $val?></option>
						<?php else: ?>
							<option value="<?php echo $key?>"><?php echo $val?></option>
						<?php endif; ?>
					<?php else: ?>
						<?php if ($key == 'doubloons'): ?>
							<option value="<?php echo $key?>" selected><?php echo $val?></option>
						<?php else: ?>
							<option value="<?php echo $key?>"><?php echo $val?></option>
						<?php endif; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
			
			<a href="<?php echo base_url('inventory/history/' . $this->uri->segment(3))?>" class="ajaxHTML nopic" title="Update graph and table" id="history_update_link">Update</a>
		</form>
	</section>

	<div class="demo-container" style="clear: both; margin: 1em auto; width: 550px; height: 300px">
		<div id="placeholder" class="demo-placeholder" style="width: 100%; height: 100%;"></div>
	</div>

	<?php if ($history !== FALSE): ?>
		<table style="padding-bottom: 2em;">
			<?php foreach ($history as $row): ?>
				<tr>
					<td style="width: 25%">Week <?php echo $row['week']?></td>
					<td><?php echo $row[$data_type]?> <?php echo $data_type_suffix[$data_type]?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php else: ?>
		<p><em>No data available...</em></p>
	<?php endif; ?>

<?php else: ?>
	<p><em>No data available...</em></p>
<?php endif; ?>