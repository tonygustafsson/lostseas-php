<div class="container">
	<?php if ($user['id'] == $player['user']['id']): ?>
	<h3>Inventory: Ships</h3>
	<?php else: ?>
	<h3>About <?=$player['user']['name']?>:
		Ships</h3>
	<?php endif; ?>

	<div class="button-area">
		<a class="ajaxHTML button big-icon"
			title="Learn more about <?=$player['user']['name']?>"
			href="<?=base_url('inventory/player/' . $this->uri->segment(3))?>">
			<svg width="16" height="16" alt="Player">
				<use xlink:href="#icon-player"></use>
			</svg>
			Player
		</a>
		<a class="ajaxHTML button big-icon"
			title="See <?=$player['game']['character_name']?>s ships"
			href="<?=base_url('inventory/ships/' . $this->uri->segment(3))?>">
			<svg width="16" height="16" alt="Ships">
				<use xlink:href="#icon-ship"></use>
			</svg>
			Ships
		</a>
		<a class="ajaxHTML button big-icon"
			title="See <?=$player['game']['character_name']?>s crew members"
			href="<?=base_url('inventory/crew/' . $this->uri->segment(3))?>">
			<svg width="16" height="16" alt="Crew members">
				<use xlink:href="#icon-crew-man"></use>
			</svg>
			Crew
		</a>
		<a class="ajaxHTML button big-icon"
			title="See graphs and data about <?=$player['game']['character_name']?>s history"
			href="<?=base_url('inventory/history/' . $this->uri->segment(3))?>">
			<svg width="16" height="16" alt="History">
				<use xlink:href="#icon-clock"></use>
			</svg>
			History
		</a>
		<a class="ajaxHTML button big-icon"
			title="Check out <?=$player['game']['character_name']?>s log book"
			href="<?=base_url('inventory/log/' . $this->uri->segment(3))?>">
			<svg width="16" height="16" alt="Log book">
				<use xlink:href="#icon-logbook"></use>
			</svg>
			Log book
		</a>
	</div>

	<h4>Ships</h4>

	<p>You can buy and sell ships and fixings at the shipyard.</p>

	<?php if (count($player['ship']) > 0): ?>

	<div class="table-responsive">
		<table>
			<tr>
				<th>Name</th>
				<th>Type</th>
				<th>Health</th>
				<th>Max load</th>
				<th>Crew</th>
				<th>Max cannons</th>
			</tr>

			<?php foreach ($player['ship'] as $current_ship): ?>
			<tr>
				<td>
					<a href="#"
						id="js-ship-info-trigger-<?=$current_ship['id']?>"
						class="js-trigger-ship-info"
						data-ship-id="<?=$current_ship['id']?>">
						<span
							id="js-ship-name-<?=$current_ship['id']?>">
							<?=$current_ship['name']?>
						</span>
					</a>
				</td>
				<td><?=ucfirst($current_ship['type'])?>
				</td>
				<td><?=$current_ship['health']?>
					%
				</td>
				<td><?=$ship_specs[$current_ship['type']]['load_capacity']?>
				</td>
				<td><?=$ship_specs[$current_ship['type']]['min_crew']?>
					- <?=$ship_specs[$current_ship['type']]['max_crew']?>
				</td>
				<td><?=$ship_specs[$current_ship['type']]['max_cannons']?>
				</td>
			</tr>
			<?php endforeach; ?>

			<?php if ($player['game']['ships'] > 1): ?>
			<tr>
				<td colspan=" 3">Total</td>
				<td><?=$player['game']['load_max']?>
				</td>
				<td><?=$player['game']['min_crew']?>
					- <?=$player['game']['max_crew']?>
				</td>
				<td><?=$player['game']['max_cannons']?>
				</td>
			</tr>
			<?php endif; ?>
		</table>
	</div>

	<?php foreach ($player['ship'] as $current_ship): ?>
	<div id="js-ship-info-<?=$current_ship['id']?>"
		class="dialog" tabindex="-1" role="dialog">
		<h3 class="dialog-title"><?=$current_ship['name']?>
		</h3>

		<div class="flex pt-1">
			<div style="flex: 1 0 25%">
				<img width="100" class="w-100"
					src="<?=base_url('assets/images/ships/' . $current_ship['type'] .'.jpg')?>" />
			</div>
			<div>
				<p class="mt-0"><?=$ship_specs[$current_ship['type']]['description']?>
				</p>
			</div>
		</div>

		<label for="ship_name" class="mb-0">Name</label>

		<form method="post" class="ajaxJSON"
			action="<?=base_url('inventory/change_ship_name/' . $player['user']['id'])?>">
			<div class="flex">
				<input type="hidden" name="ship_id" id="ship_id"
					value="<?=$current_ship['id']?>" />
				<input type="text"
					value="<?=$current_ship['name']?>"
					name="ship_name" id="ship_name" required maxlength="50" minlength="3" />
				<button type="submit" class="ml-1 ml-mobile-0">Change</button>
			</div>
		</form>

		<table>
			<tr>
				<td>Type</td>
				<td><?=ucfirst($current_ship['type'])?>
				</td>
			</tr>

			<tr>
				<td>Health</td>
				<td><?=$current_ship['health']?>%
				</td>
			</tr>

			<tr>
				<td>Load capacity</td>
				<td><?=$ship_specs[$current_ship['type']]['load_capacity']?>
					cartons
				</td>
			</tr>

			<tr>
				<td>Crew</td>
				<td><?=$ship_specs[$current_ship['type']]['min_crew']?>
					- <?=$ship_specs[$current_ship['type']]['max_crew']?>
				</td>
			</tr>

			<tr>
				<td>Max cannons</td>
				<td><?=$player['game']['max_cannons']?>
				</td>
			</tr>
		</table>
	</div>
	<?php endforeach; ?>

	<?php else: ?>
	<p>You don't own any ships...</p>
	<?php endif; ?>

	<hr />

	<h4>Fixings</h4>

	<table>

		<tr>
			<td>
				<svg width="24" height="24" alt="Cannons">
					<use xlink:href="#icon-cannons"></use>
				</svg>
				Total cannons
			</td>
			<td><?=$player['game']['cannons']?>
				pcs</td>
		</tr>

		<tr>
			<td>
				<svg width="24" height="24" alt="Cannons">
					<use xlink:href="#icon-cannons"></use>
				</svg>
				Manned cannons
			</td>
			<td><?=$player['game']['manned_cannons']?>
				pcs</td>
		</tr>

		<tr>
			<td>
				<svg width="24" height="24" alt="Raft">
					<use xlink:href="#icon-raft"></use>
				</svg>
				Rafts
			</td>
			<td><?=$player['game']['rafts']?>
				pcs</td>
		</tr>

		<tr>
			<td>
				<svg width="24" height="24" alt="Prisoners">
					<use xlink:href="#icon-prisoners"></use>
				</svg>
				Prisoners
			</td>
			<td><?=$player['game']['prisoners']?>
				pcs</td>
		</tr>
	</table>
</div>