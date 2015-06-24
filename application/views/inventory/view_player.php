<? if ($user['id'] == $player['user']['id']): ?>
	<header title="Inventory: You">
		<h3>Inventory: You</h3>
	</header>
<? else: ?>
	<header title="About <?=$player['user']['name']?>">
		<h3>About <?=$player['user']['name']?>: Player</h3>
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

<h4>Player: <?=$player['user']['name']?></h4>

<div style="float: left; width: 10%; padding: 2em;">
	<img style="border-radius: 4px; border: 1px black solid;" src="<?=$player['user']['profile_picture']?>" alt="<?=$player['user']['name']?>">
</div>

<div style="float: left; width: 75%; padding: 1em; clear: right;">
	<table>

		<? if ($player['user']['email'] != "" && $player['user']['show_email'] == 1): ?>
			<tr>
			<td>Email</td>
			<td><a href="mailto:<?=$player['user']['email']?>"><?=$player['user']['email']?></a></td>
			</tr>
		<? endif; ?>

		<? if ($player['user']['gender'] != "" && $player['user']['show_gender'] == 1): ?>
			<tr>
			<td>Gender</td>
			<td><?=ucfirst($player['user']['gender_long'])?></td>
			</tr>
		<? endif; ?>

		<? if (isset($player['user']['age']) && $player['user']['birthday'] != "" && $player['user']['show_age'] == 1): ?>
			<tr>
			<td>Age</td>
			<td><?=$player['user']['age']?> years old</td>
			</tr>
		<? endif; ?>

		<? if (! empty($player['user']['facebook'])): ?>
			<tr>
			<td>Facebook</td>
			<td><a href="<?=$player['user']['facebook']?>"><?=$player['user']['facebook']?></a></td>
			</tr>
		<? endif; ?>

		<tr>
		<td>Last activity</td>
		<td><?=$player['game']['last_activity']?></td>
		</tr>

		<tr>
		<td>Account created</td>
		<td><?=$player['user']['created']?></td>
		</tr>

	</table>
</div>

<? if (! empty($player['user']['presentation'])): ?>
	<h4 style="padding-top: 1em; clear: both;">Presentation</h4>
	<p><?=$player['user']['presentation']?></p>
<? endif; ?>

<div class="divider"></div>

<h4 id="character">Character: <?=$player['game']['character_name']?></h4>

<div style="float: left; width: 10%; padding: 2em;">
	<img style="border-radius: 4px; border: 1px black solid;" src="<?=$player['game']['character_avatar_path']?>" alt="<?=$player['game']['character_name']?>">
</div>

<div style="float: left; width: 75%; padding: 1em; clear: right;">
	<table id="inventory" style="padding-bottom: 2em;">

		<tr>
			<td>Title</td>
			<td><?=ucfirst($player['game']['title'])?> from <?=ucfirst($player['game']['nationality'])?></td>
		</tr>

		<tr>
			<td>Enemy</td>
			<td><?=ucfirst($player['game']['enemy'])?></td>
		</tr>
		
		<tr>
			<td>Gender</td>
			<td><?=ucfirst($player['game']['character_gender_long'])?></td>
		</tr>

		<tr>
			<td>Age</td>
			<td><?=$player['game']['character_real_age']?> years old</td>
		</tr>

		<tr>
		<td>Location</td>
		<? if ($player['game']['place'] == 'ocean'): ?>
			<td>Caribbean Sea</td>
		<? else: ?>
			<td><?echo ucwords($player['game']['town_human']) . ' ' . $player['game']['place']?> (<?=ucfirst($player['game']['nation'])?>)</td>
		<? endif; ?>
		</tr>

		<tr>
			<td>Played for</td>
			<td><?=$player['game']['week']?> weeks</td>
		</tr>

	</table>
</div>

<? if (! empty($player['game']['character_description'])): ?>
	<p><strong>Description:</strong> <?=$player['game']['character_description']?></p>
<? endif; ?>

<h4 id="capital">Capital</h4>

<p>You can transfer doubloons at the bank.</p>

<table id="money" style="padding-bottom: 2em;">

	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/bank.png" alt="Money" width="24" height="24"> Doubloons (Cash)</td>
		<td><?=$player['game']['doubloons']?> dbl</td>
	</tr>

	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/money_bank.png" alt="Money in bank" width="24" height="24"> Bank account</td>
		<td><?=$player['game']['bank_account']?> dbl</td>
	</tr>

	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/money_bank_loan.png" alt="Bank loan" width="24" height="24"> Bank loan</td>
		<td><?=$player['game']['bank_loan']?> dbl</td>
	</tr>

</table>

<h4 id="stock">Stock</h4>

<p>You can buy and sell groceries at the shop.</p>

<table id="stock" style="padding-bottom: 2em;">

	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/market_browse.png" alt="Food" width="24" height="24"> Food</td>
		<td><?=$player['game']['food']?> cartons</td>
	</tr>

	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/water.png" alt="Water" width="24" height="24"> Water</td>
		<td><?=$player['game']['water']?> barrels</td>
	</tr>

	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/porcelain.png" alt="Porcelain" width="24" height="24"> Porcelain</td>
		<td><?=$player['game']['porcelain']?> cartons</td>
	</tr>

	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/spices.png" alt="Spices" width="24" height="24"> Spices</td>
		<td><?=$player['game']['spices']?> cartons</td>
	</tr>

	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/silk.png" alt="Silk" width="24" height="24"> Silk</td>
		<td><?=$player['game']['silk']?> cartons</td>
	</tr>

	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/tobacco.png" alt="Tobacco" width="24" height="24"> Tobacco</td>
		<td><?=$player['game']['tobacco']?> cartons</td>
	</tr>

	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/rum.png" alt="Rum" width="24" height="24"> Rum</td>
		<td><?=$player['game']['rum']?> barrels</td>
	</tr>

	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/medicine.png" alt="Medicine" width="24" height="24"> Medicine</td>
		<td><?=$player['game']['medicine']?> pcs</td>
	</tr>

</table>

<h4>Victories</h4>

<table id="inventory" style="padding-bottom: 2em;">

	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/flag-england.png" alt="Flag" width="24" height="12"> England</td>
		<td><?=$player['game']['victories_england']?> victories</td>
	</tr>
	
	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/flag-france.png" alt="Flag" width="24" height="12"> France</td>
		<td><?=$player['game']['victories_france']?> victories</td>
	</tr>
	
	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/flag-holland.png" alt="Flag" width="24" height="12"> Holland</td>
		<td><?=$player['game']['victories_holland']?> victories</td>
	</tr>
	
	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/flag-spain.png" alt="Flag" width="24" height="12"> Spain</td>
		<td><?=$player['game']['victories_spain']?> victories</td>
	</tr>
	
	<tr>
		<td><img src="<?echo base_url()?>assets/images/icons/flag-pirate.png" alt="Flag" width="24" height="12"> Pirates</td>
		<td><?=$player['game']['victories_pirates']?> victories</td>
	</tr>

	<tr>
		<td></td>
		<td><?echo $player['game']['total_victories']?> victories total</td>
	</tr>

</table>