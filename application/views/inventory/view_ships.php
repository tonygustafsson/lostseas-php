<? if ($user['id'] == $player['user']['id']): ?>
	<header title="Inventory: Ships">
		<h3>Inventory: Ships</h3>
	</header>
<? else: ?>
	<header title="About <?=$player['user']['name']?>">
		<h3>About <?=$player['user']['name']?>: Ships</h3>
	</header>
<? endif; ?>

<section class="actions">
	<a class="ajaxHTML" title="Learn more about <?=$player['user']['name']?>" href="inventory/player/<?=$this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/players_user.png')?>" alt="User" width="32" height="32">Player</a>
	<a class="ajaxHTML" title="See <?=$player['game']['character_name']?>s ships" href="inventory/ships/<?=$this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/coast.png')?>" alt="Character" width="32" height="32">Ships</a>
	<a class="ajaxHTML" title="See <?=$player['game']['character_name']?>s crew members" href="inventory/crew/<?=$this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/tavern_sailor.png')?>" alt="Character" width="32" height="32">Crew</a>
	<? if ($user['id'] == $player['user']['id'] || $player['user']['show_history'] == 1): ?>
		<a class="ajaxHTML" title="See graphs and data about <?=$player['game']['character_name']?>s history" href="inventory/history/<?=$this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/history.png')?>" alt="Character" width="32" height="32">History</a>
		<a class="ajaxHTML" title="Check out <?=$player['game']['character_name']?>s log book" href="inventory/log/<?=$this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/about_news.png')?>" alt="Log book" width="32" height="32">Log book</a>
	<? endif; ?>
	<a class="ajaxHTML" title="Say something to <?=$player['user']['name']?>" href="inventory/messages/<?=$this->uri->segment(3)?>"><img src="<?echo base_url('assets/images/icons/players_messages.png')?>" alt="Messages" width="32" height="32">Messages</a>
</section>

<h4>Ships</h4>

<p>You can buy and sell ships and fixings at the shipyard.</p>

<? if (count($player['ship']) > 0): ?>

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

	<? foreach ($player['ship'] as $current_ship): ?>
		<tr>
			<td><?=$current_ship['name']?></td>
			<td><?=ucfirst($current_ship['type'])?></td>
			<td><?=$current_ship['health']?> %</td>
			<td><?=$ship_specs[$current_ship['type']]['load_capacity']?></td>
			<td><?=$ship_specs[$current_ship['type']]['min_crew']?></td>
			<td><?=$ship_specs[$current_ship['type']]['max_crew']?></td>
			<td><?=$ship_specs[$current_ship['type']]['max_cannons']?></td>
		</tr>
	<? endforeach; ?>
	
	<? if ($player['game']['ships'] > 1): ?>
		<tr>
			<td colspan="3">Total</td>
			<td><?=$player['game']['load_max']?></td>
			<td><?=$player['game']['min_crew']?></td>
			<td><?=$player['game']['max_crew']?></td>
			<td><?=$player['game']['max_cannons']?></td>
		</tr>
	<? endif; ?>
	
	</table>
	
<? else: ?>
	<p>You don't own any ships...</p>
<? endif; ?>

<div class="divider"></div>

<h4>Fixings</h4>

<table>

	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/shipyard_fixings.png" alt="Cannons" width="24" height="24"> Total cannons</td>
		<td><?=$player['game']['cannons']?> pcs</td>
	</tr>
	
	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/shipyard_fixings.png" alt="Cannons" width="24" height="24"> Manned cannons</td>
		<td><?=$player['game']['manned_cannons']?> pcs</td>
	</tr>

	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/raft.png" alt="Cannons" width="24" height="24"> Rafts</td>
		<td><?=$player['game']['rafts']?> pcs</td>
	</tr>
	
	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/cityhall_prisoners.png" alt="Prisoners" width="24" height="24"> Prisoners</td>
		<td><?=$player['game']['prisoners']?> pcs</td>
	</tr>

</table>