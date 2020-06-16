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
			href="inventory/player/<?=$this->uri->segment(3)?>">
			<svg width="16" height="16" alt="Player">
				<use xlink:href="#player"></use>
			</svg>
			Player
		</a>
		<a class="ajaxHTML button big-icon"
			title="See <?=$player['game']['character_name']?>s ships"
			href="inventory/ships/<?=$this->uri->segment(3)?>">
			<svg width="16" height="16" alt="Ships">
				<use xlink:href="#ship"></use>
			</svg>
			Ships
		</a>
		<a class="ajaxHTML button big-icon"
			title="See <?=$player['game']['character_name']?>s crew members"
			href="inventory/crew/<?=$this->uri->segment(3)?>">
			<svg width="16" height="16" alt="Crew members">
				<use xlink:href="#crew-man"></use>
			</svg>
			Crew
		</a>
		<a class="ajaxHTML button big-icon"
			title="See graphs and data about <?=$player['game']['character_name']?>s history"
			href="inventory/history/<?=$this->uri->segment(3)?>">
			<svg width="16" height="16" alt="History">
				<use xlink:href="#clock"></use>
			</svg>
			History
		</a>
		<a class="ajaxHTML button big-icon"
			title="Check out <?=$player['game']['character_name']?>s log book"
			href="inventory/log/<?=$this->uri->segment(3)?>">
			<svg width="16" height="16" alt="Log book">
				<use xlink:href="#logbook"></use>
			</svg>
			Log book
		</a>
	</div>

	<h4>Ships</h4>

	<p>You can buy and sell ships and fixings at the shipyard.</p>

	<?php if (count($player['ship']) > 0): ?>

	<table>

		<tr>
			<th>Name</th>
			<th>Type</th>
			<th>Health</th>
			<th>Max load</th>
			<th>Min crew</th>
			<th>Max crew</th>
			<th>Max cannons</th>
		</tr>

		<?php foreach ($player['ship'] as $current_ship): ?>
		<tr>
			<td><?=$current_ship['name']?>
			</td>
			<td><?=ucfirst($current_ship['type'])?>
			</td>
			<td><?=$current_ship['health']?> %
			</td>
			<td><?=$ship_specs[$current_ship['type']]['load_capacity']?>
			</td>
			<td><?=$ship_specs[$current_ship['type']]['min_crew']?>
			</td>
			<td><?=$ship_specs[$current_ship['type']]['max_crew']?>
			</td>
			<td><?=$ship_specs[$current_ship['type']]['max_cannons']?>
			</td>
		</tr>
		<?php endforeach; ?>

		<?php if ($player['game']['ships'] > 1): ?>
		<tr>
			<td colspan="3">Total</td>
			<td><?=$player['game']['load_max']?>
			</td>
			<td><?=$player['game']['min_crew']?>
			</td>
			<td><?=$player['game']['max_crew']?>
			</td>
			<td><?=$player['game']['max_cannons']?>
			</td>
		</tr>
		<?php endif; ?>

	</table>

	<?php else: ?>
	<p>You don't own any ships...</p>
	<?php endif; ?>

	<hr />

	<h4>Fixings</h4>

	<table>

		<tr>
			<td>
				<svg width="24" height="24" alt="Cannons">
					<use xlink:href="#cannon"></use>
				</svg>
				Total cannons
			</td>
			<td><?=$player['game']['cannons']?>
				pcs</td>
		</tr>

		<tr>
			<td>
				<svg width="24" height="24" alt="Cannons">
					<use xlink:href="#cannon"></use>
				</svg>
				Manned cannons
			</td>
			<td><?=$player['game']['manned_cannons']?>
				pcs</td>
		</tr>

		<tr>
			<td>
				<svg width="24" height="24" alt="Raft">
					<use xlink:href="#raft"></use>
				</svg>
				Rafts
			</td>
			<td><?=$player['game']['rafts']?>
				pcs</td>
		</tr>

		<tr>
			<td>
				<svg width="24" height="24" alt="Prisoners">
					<use xlink:href="#prisoners"></use>
				</svg>
				Prisoners
			</td>
			<td><?=$player['game']['prisoners']?>
				pcs</td>
		</tr>
	</table>
</div>