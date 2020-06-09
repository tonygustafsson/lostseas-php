<?php if ($user['id'] == $player['user']['id']): ?>
<header class="area-header" class="area-header" title="Inventory: Status">
	<h3>Inventory: History</h3>
</header>
<?php else: ?>
<header class="area-header"
	title="About <?=$player['user']['name']?>">
	<h3>About <?=$player['user']['name']?>:
		History</h3>
</header>
<?php endif; ?>

<section class="action-buttons">
	<a class="ajaxHTML"
		title="Learn more about <?=$player['user']['name']?>"
		href="inventory/player/<?=$this->uri->segment(3)?>">
		<svg width="16" height="16" alt="Player">
			<use xlink:href="#player"></use>
		</svg>
		Player
	</a>
	<a class="ajaxHTML"
		title="See <?=$player['game']['character_name']?>s ships"
		href="inventory/ships/<?=$this->uri->segment(3)?>">
		<svg width="16" height="16" alt="Ships">
			<use xlink:href="#ship"></use>
		</svg>
		Ships
	</a>
	<a class="ajaxHTML"
		title="See <?=$player['game']['character_name']?>s crew members"
		href="inventory/crew/<?=$this->uri->segment(3)?>">
		<svg width="16" height="16" alt="Crew members">
			<use xlink:href="#crew-man"></use>
		</svg>
		Crew
	</a>
	<?php if ($user['id'] == $player['user']['id'] || $player['user']['show_history'] == 1): ?>
	<a class="ajaxHTML"
		title="See graphs and data about <?=$player['game']['character_name']?>s history"
		href="inventory/history/<?=$this->uri->segment(3)?>">
		<svg width="16" height="16" alt="History">
			<use xlink:href="#clock"></use>
		</svg>
		History
	</a>
	<a class="ajaxHTML"
		title="Check out <?=$player['game']['character_name']?>s log book"
		href="inventory/log/<?=$this->uri->segment(3)?>">
		<svg width="16" height="16" alt="Log book">
			<use xlink:href="#logbook"></use>
		</svg>
		Log book
	</a>
	<?php endif; ?>
	<a class="ajaxHTML"
		title="Say something to <?=$player['user']['name']?>"
		href="inventory/messages/<?=$this->uri->segment(3)?>">
		<svg width="16" height="16" alt="Messages">
			<use xlink:href="#message"></use>
		</svg>
		Messages
	</a>
</section>

<div class="divider"></div>

<h4>History</h4>

<p>You can change the history by using the form below.</p>

<?php if (isset($history)): ?>
<section class="action-buttons">
	<form method="post" class="ajaxJSON"
		action="<?=base_url('inventory/history/' . $this->uri->segment(3))?>">
		<input type="hidden" name="base_url" id="base_url"
			value="<?=base_url('inventory/history/' . $this->uri->segment(3))?>">

		Weeks:
		<select name="weeks" id="history_weeks">
			<?php foreach ($history_weeks as $week): ?>
			<?php if ($this->uri->segment(5) != ""): ?>
			<?php if ($week == $this->uri->segment(5)): ?>
			<option value="<?=$week?>" selected><?=$week?>
			</option>
			<?php else: ?>
			<option value="<?=$week?>"><?=$week?>
			</option>
			<?php endif; ?>
			<?php else: ?>
			<?php if ($week == 20): ?>
			<option value="<?=$week?>" selected><?=$week?>
			</option>
			<?php else: ?>
			<option value="<?=$week?>"><?=$week?>
			</option>
			<?php endif; ?>
			<?php endif; ?>
			<?php endforeach; ?>
		</select>

		Data:
		<select name="data" id="history_data">
			<?php foreach ($history_data as $key => $val): ?>
			<?php if ($this->uri->segment(4) != ""): ?>
			<?php if ($key == $this->uri->segment(4)): ?>
			<option value="<?=$key?>" selected><?=$val?>
			</option>
			<?php else: ?>
			<option value="<?=$key?>"><?=$val?>
			</option>
			<?php endif; ?>
			<?php else: ?>
			<?php if ($key == 'doubloons'): ?>
			<option value="<?=$key?>" selected><?=$val?>
			</option>
			<?php else: ?>
			<option value="<?=$key?>"><?=$val?>
			</option>
			<?php endif; ?>
			<?php endif; ?>
			<?php endforeach; ?>
		</select>

		<a href="<?=base_url('inventory/history/' . $this->uri->segment(3))?>"
			class="ajaxHTML nopic" title="Update graph and table" id="history_update_link">Update</a>
	</form>
</section>

<div class="js-chartist-history" width="750" height="400"
	data-chart-labels="<?=$chart_labels?>"
	data-chart-data="<?=$chart_data?>"></div>

<?php if ($history !== false): ?>
<table style="padding-bottom: 2em;">
	<?php foreach ($history as $row): ?>
	<tr>
		<td style="width: 25%">Week <?=$row['week']?>
		</td>
		<td><?=$row[$data_type]?> <?=$data_type_suffix[$data_type]?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
<?php else: ?>
<p><em>No data available...</em></p>
<?php endif; ?>

<?php else: ?>
<p><em>No data available...</em></p>
<?php endif;
