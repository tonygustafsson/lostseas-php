<div class="container">
	<?php if ($user['id'] == $player['user']['id']): ?>
	<h3>Inventory: History</h3>
	<?php else: ?>
	<h3>About <?=$player['user']['name']?>:
		History</h3>
	<?php endif; ?>

	<div class="button-area">
		<a class="ajaxHTML button big-icon"
			title="Learn more about <?=$player['user']['name']?>"
			href="<?=base_url('inventory/player/' . $this->uri->segment(3))?>">
			<svg width="16" height="16" alt="Player">
				<use xlink:href="#player"></use>
			</svg>
			Player
		</a>
		<a class="ajaxHTML button big-icon"
			title="See <?=$player['game']['character_name']?>s ships"
			href="<?=base_url('inventory/ships/' . $this->uri->segment(3))?>">
			<svg width="16" height="16" alt="Ships">
				<use xlink:href="#ship"></use>
			</svg>
			Ships
		</a>
		<a class="ajaxHTML button big-icon"
			title="See <?=$player['game']['character_name']?>s crew members"
			href="<?=base_url('inventory/crew/' . $this->uri->segment(3))?>">
			<svg width="16" height="16" alt="Crew members">
				<use xlink:href="#crew-man"></use>
			</svg>
			Crew
		</a>
		<a class="ajaxHTML button big-icon"
			title="See graphs and data about <?=$player['game']['character_name']?>s history"
			href="<?=base_url('inventory/history/' . $this->uri->segment(3))?>">
			<svg width="16" height="16" alt="History">
				<use xlink:href="#clock"></use>
			</svg>
			History
		</a>
		<a class="ajaxHTML button big-icon"
			title="Check out <?=$player['game']['character_name']?>s log book"
			href="<?=base_url('inventory/log/' . $this->uri->segment(3))?>">
			<svg width="16" height="16" alt="Log book">
				<use xlink:href="#logbook"></use>
			</svg>
			Log book
		</a>
	</div>

	<?php if (isset($chart_data)): ?>
	<div class="text-center">
		<form method="post" class="ajaxJSON"
			action="<?=base_url('inventory/history/' . $this->uri->segment(3))?>">
			<input type="hidden" name="base_url" id="base_url"
				value="<?=base_url('inventory/history/' . $this->uri->segment(3))?>">

			Weeks:
			<select name="weeks" id="history_weeks">
				<?php foreach ($history_weeks as $week): ?>
				<?php if (($this->uri->segment(4) != "" && $week == $this->uri->segment(4)) || $this->uri->segment(4) == "" && $week == 50): ?>
				<option value="<?=$week?>" selected><?=$week?>
				</option>
				<?php else: ?>
				<option value="<?=$week?>"><?=$week?>
				</option>
				<?php endif; ?>
				<?php endforeach; ?>
			</select>

			<a href="<?=base_url('inventory/history/' . $this->uri->segment(3))?>"
				class="ajaxHTML" title="Update graph and table" id="history_update_link">Update</a>
		</form>
	</div>

	<div class="inventory-charts">
		<div class="inventory-charts__item">
			<h4>Victories</h4>

			<?php if ($chart_data['victories']): ?>
			<div class="js-chartist-history" width="750" height="400"
				data-chart-labels="<?=$chart_data['labels']?>"
				data-chart-data="<?=$chart_data['victories']?>">
			</div>
			<?php else: ?>
			<p><em>No data available...</em></p>
			<?php endif; ?>
		</div>

		<div class="inventory-charts__item">
			<h4>Level</h4>

			<?php if ($chart_data['level']): ?>
			<div class="js-chartist-history" width="750" height="400"
				data-chart-labels="<?=$chart_data['labels']?>"
				data-chart-data="<?=$chart_data['level']?>">
			</div>
			<?php else: ?>
			<p><em>No data available...</em></p>
			<?php endif; ?>
		</div>

		<div class="inventory-charts__item">
			<h4>Stock value</h4>

			<?php if ($chart_data['stock_value']): ?>
			<div class="js-chartist-history" width="750" height="400"
				data-chart-labels="<?=$chart_data['labels']?>"
				data-chart-data="<?=$chart_data['stock_value']?>">
			</div>
			<?php else: ?>
			<p><em>No data available...</em></p>
			<?php endif; ?>
		</div>

		<div class="inventory-charts__item">
			<h4>Ships</h4>

			<?php if ($chart_data['ships']): ?>
			<div class="js-chartist-history" width="750" height="400"
				data-chart-labels="<?=$chart_data['labels']?>"
				data-chart-data="<?=$chart_data['ships']?>">
			</div>
			<?php else: ?>
			<p><em>No data available...</em></p>
			<?php endif; ?>
		</div>

		<div class="inventory-charts__item">
			<h4>Doubloons</h4>

			<?php if ($chart_data['doubloons']): ?>
			<div class="js-chartist-history" width="750" height="400"
				data-chart-labels="<?=$chart_data['labels']?>"
				data-chart-data="<?=$chart_data['doubloons']?>">
			</div>

			<?php else: ?>
			<p><em>No data available...</em></p>
			<?php endif; ?>
		</div>

		<div class="inventory-charts__item">
			<h4>Crew members</h4>

			<?php if ($chart_data['crew_members']): ?>
			<div class="js-chartist-history" width="750" height="400"
				data-chart-labels="<?=$chart_data['labels']?>"
				data-chart-data="<?=$chart_data['crew_members']?>">
			</div>
			<?php else: ?>
			<p><em>No data available...</em></p>
			<?php endif; ?>
		</div>

		<div class="inventory-charts__item">
			<h4>Crew health</h4>

			<?php if ($chart_data['crew_health']): ?>
			<div class="js-chartist-history" width="750" height="400"
				data-chart-labels="<?=$chart_data['labels']?>"
				data-chart-data="<?=$chart_data['crew_health']?>">
			</div>
			<?php else: ?>
			<p><em>No data available...</em></p>
			<?php endif; ?>
		</div>

		<div class="inventory-charts__item">
			<h4>Crew mood</h4>

			<?php if ($chart_data['crew_mood']): ?>
			<div class="js-chartist-history" width="750" height="400"
				data-chart-labels="<?=$chart_data['labels']?>"
				data-chart-data="<?=$chart_data['crew_mood']?>">
			</div>
			<?php else: ?>
			<p><em>No data available...</em></p>
			<?php endif; ?>
		</div>
	</div>
	<?php else: ?>
	<p><em>No data to show yet.</em></p>
	<?php endif; ?>
</div>