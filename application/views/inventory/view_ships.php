<?php if ($user['id'] == $player['user']['id']): ?>
<header class="area-header" class="area-header" title="Inventory: Ships">
	<h3>Inventory: Ships</h3>
</header>
<?php else: ?>
<header class="area-header"
	title="About <?=$player['user']['name']?>">
	<h3>About <?=$player['user']['name']?>:
		Ships</h3>
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
		<td><?=$current_ship['health']?> %</td>
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

<div class="divider"></div>

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