<?php if ($user['id'] == $player['user']['id']): ?>
	<header title="Inventory: You">
		<h3>Inventory: You</h3>
	</header>
<?php else: ?>
	<header title="About <?php echo $player['user']['name']?>">
		<h3>About <?php echo $player['user']['name']?>: Player</h3>
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

<h4>Player: <?php echo $player['user']['name']?></h4>

<div style="float: left; width: 10%; padding: 2em;">
	<img style="border-radius: 4px; border: 1px black solid;" src="<?php echo $player['user']['profile_picture']?>" alt="<?php echo $player['user']['name']?>">
</div>

<div style="float: left; width: 75%; padding: 1em; clear: right;">
	<table>

		<?php if ($player['user']['email'] != "" && $player['user']['show_email'] == 1): ?>
			<tr>
			<td>Email</td>
			<td><a href="mailto:<?php echo $player['user']['email']?>"><?php echo $player['user']['email']?></a></td>
			</tr>
		<?php endif; ?>

		<?php if ($player['user']['gender'] != "" && $player['user']['show_gender'] == 1): ?>
			<tr>
			<td>Gender</td>
			<td><?php echo ucfirst($player['user']['gender_long'])?></td>
			</tr>
		<?php endif; ?>

		<?php if (isset($player['user']['age']) && $player['user']['birthday'] != "" && $player['user']['show_age'] == 1): ?>
			<tr>
			<td>Age</td>
			<td><?php echo $player['user']['age']?> years old</td>
			</tr>
		<?php endif; ?>

		<?php if (! empty($player['user']['facebook'])): ?>
			<tr>
			<td>Facebook</td>
			<td><a href="<?php echo $player['user']['facebook']?>"><?php echo $player['user']['facebook']?></a></td>
			</tr>
		<?php endif; ?>

		<tr>
		<td>Last activity</td>
		<td><?php echo $player['game']['last_activity']?></td>
		</tr>

		<tr>
		<td>Account created</td>
		<td><?php echo $player['user']['created']?></td>
		</tr>

	</table>
</div>

<?php if (! empty($player['user']['presentation'])): ?>
	<h4 style="padding-top: 1em; clear: both;">Presentation</h4>
	<p><?php echo $player['user']['presentation']?></p>
<?php endif; ?>

<div class="divider"></div>

<h4 id="character">Character: <?php echo $player['game']['character_name']?></h4>

<div style="float: left; width: 10%; padding: 2em;">
	<img style="border-radius: 4px; border: 1px black solid;" src="<?php echo $player['game']['character_avatar_path']?>" alt="<?php echo $player['game']['character_name']?>">
</div>

<div style="float: left; width: 75%; padding: 1em; clear: right;">
	<table id="inventory" style="padding-bottom: 2em;">

		<tr>
			<td>Title</td>
			<td><?php echo ucfirst($player['game']['title'])?> from <?php echo ucfirst($player['game']['nationality'])?></td>
		</tr>

		<tr>
			<td>Enemy</td>
			<td><?php echo ucfirst($player['game']['enemy'])?></td>
		</tr>
		
		<tr>
			<td>Gender</td>
			<td><?php echo ucfirst($player['game']['character_gender_long'])?></td>
		</tr>

		<tr>
			<td>Age</td>
			<td><?php echo $player['game']['character_real_age']?> years old</td>
		</tr>

		<tr>
		<td>Location</td>
		<?php if ($player['game']['place'] == 'ocean'): ?>
			<td>Caribbean Sea</td>
		<?php else: ?>
			<td><?php echo ucwords($player['game']['town_human']) . ' ' . $player['game']['place']?> (<?php echo ucfirst($player['game']['nation'])?>)</td>
		<?php endif; ?>
		</tr>

		<tr>
			<td>Played for</td>
			<td><?php echo $player['game']['week']?> weeks</td>
		</tr>

	</table>
</div>

<?php if (! empty($player['game']['character_description'])): ?>
	<p><strong>Description:</strong> <?php echo $player['game']['character_description']?></p>
<?php endif; ?>

<h4 id="capital">Capital</h4>

<p>You can transfer doubloons at the bank.</p>

<table id="money" style="padding-bottom: 2em;">

	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/bank.png" alt="Money" width="24" height="24"> Doubloons (Cash)</td>
		<td><?php echo $player['game']['doubloons']?> dbl</td>
	</tr>

	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/money_bank.png" alt="Money in bank" width="24" height="24"> Bank account</td>
		<td><?php echo $player['game']['bank_account']?> dbl</td>
	</tr>

	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/money_bank_loan.png" alt="Bank loan" width="24" height="24"> Bank loan</td>
		<td><?php echo $player['game']['bank_loan']?> dbl</td>
	</tr>

</table>

<h4 id="stock">Stock</h4>

<p>You can buy and sell groceries at the shop.</p>

<table id="stock" style="padding-bottom: 2em;">

	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/market_browse.png" alt="Food" width="24" height="24"> Food</td>
		<td><?php echo $player['game']['food']?> cartons</td>
	</tr>

	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/water.png" alt="Water" width="24" height="24"> Water</td>
		<td><?php echo $player['game']['water']?> barrels</td>
	</tr>

	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/porcelain.png" alt="Porcelain" width="24" height="24"> Porcelain</td>
		<td><?php echo $player['game']['porcelain']?> cartons</td>
	</tr>

	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/spices.png" alt="Spices" width="24" height="24"> Spices</td>
		<td><?php echo $player['game']['spices']?> cartons</td>
	</tr>

	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/silk.png" alt="Silk" width="24" height="24"> Silk</td>
		<td><?php echo $player['game']['silk']?> cartons</td>
	</tr>

	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/tobacco.png" alt="Tobacco" width="24" height="24"> Tobacco</td>
		<td><?php echo $player['game']['tobacco']?> cartons</td>
	</tr>

	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/rum.png" alt="Rum" width="24" height="24"> Rum</td>
		<td><?php echo $player['game']['rum']?> barrels</td>
	</tr>

	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/medicine.png" alt="Medicine" width="24" height="24"> Medicine</td>
		<td><?php echo $player['game']['medicine']?> pcs</td>
	</tr>

</table>

<h4>Victories</h4>

<table id="inventory" style="padding-bottom: 2em;">

	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/flag-england.png" alt="Flag" width="24" height="12"> England</td>
		<td><?php echo $player['game']['victories_england']?> victories</td>
	</tr>
	
	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/flag-france.png" alt="Flag" width="24" height="12"> France</td>
		<td><?php echo $player['game']['victories_france']?> victories</td>
	</tr>
	
	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/flag-holland.png" alt="Flag" width="24" height="12"> Holland</td>
		<td><?php echo $player['game']['victories_holland']?> victories</td>
	</tr>
	
	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/flag-spain.png" alt="Flag" width="24" height="12"> Spain</td>
		<td><?php echo $player['game']['victories_spain']?> victories</td>
	</tr>
	
	<tr>
		<td><img src="<?php echo base_url()?>assets/images/icons/flag-pirate.png" alt="Flag" width="24" height="12"> Pirates</td>
		<td><?php echo $player['game']['victories_pirates']?> victories</td>
	</tr>

	<tr>
		<td></td>
		<td><?php echo $player['game']['total_victories']?> victories total</td>
	</tr>

</table>