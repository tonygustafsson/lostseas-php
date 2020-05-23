<?php if ($user['id'] == $player['user']['id']): ?>
	<header title="Inventory: Ships">
		<h3>Inventory: Ships</h3>
	</header>
<?php else: ?>
	<header title="About <?php echo $player['user']['name']?>">
		<h3>About <?php echo $player['user']['name']?>: Ships</h3>
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
			<td><?php echo $current_ship['name']?></td>
			<td><?php echo ucfirst($current_ship['type'])?></td>
			<td><?php echo $current_ship['health']?> %</td>
			<td><?php echo $ship_specs[$current_ship['type']]['load_capacity']?></td>
			<td><?php echo $ship_specs[$current_ship['type']]['min_crew']?></td>
			<td><?php echo $ship_specs[$current_ship['type']]['max_crew']?></td>
			<td><?php echo $ship_specs[$current_ship['type']]['max_cannons']?></td>
		</tr>
	<?php endforeach; ?>
	
	<?php if ($player['game']['ships'] > 1): ?>
		<tr>
			<td colspan="3">Total</td>
			<td><?php echo $player['game']['load_max']?></td>
			<td><?php echo $player['game']['min_crew']?></td>
			<td><?php echo $player['game']['max_crew']?></td>
			<td><?php echo $player['game']['max_cannons']?></td>
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
		<td><img src="<?php echo base_url()?>assets/images/icons/shipyard_fixings.png" alt="Cannons" width="24" height="24"> Total cannons</td>
		<td><?php echo $player['game']['cannons']?> pcs</td>
	</tr>
	
	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/shipyard_fixings.png" alt="Cannons" width="24" height="24"> Manned cannons</td>
		<td><?php echo $player['game']['manned_cannons']?> pcs</td>
	</tr>

	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/raft.png" alt="Cannons" width="24" height="24"> Rafts</td>
		<td><?php echo $player['game']['rafts']?> pcs</td>
	</tr>
	
	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/cityhall_prisoners.png" alt="Prisoners" width="24" height="24"> Prisoners</td>
		<td><?php echo $player['game']['prisoners']?> pcs</td>
	</tr>

</table>