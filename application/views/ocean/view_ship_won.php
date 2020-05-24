<?php list($msg, $looted_money, $food, $water, $porcelain, $spices, $silk, $medicine, $tobacco, $rum, $new_crew, $prisoners, $sunken_ships, $killed_crew) = (! empty($this->user['game']['event_ship_won'])) ? explode('###', $this->user['game']['event_ship_won']) : array(null, null, null, null, null, null, null, null, null, null, null, null, null, null); ?>

<?php if (isset($json)): ?>
	<script type="text/javascript">
		$(document).ready(function () {
			gameManipulateDOM(<?php echo $json?>);
		});
	</script>
<?php endif; ?>

<header title="Ship victory">
	<h2>Caribbean Sea</h2>
	<img src="<?php echo base_url('assets/images/places/ocean_trade.jpg')?>" class="header">
</header>

<div id="msg"></div>

<?php if (isset($msg) && $looted_money !== null && $food !== null && $water !== null && $porcelain !== null && $spices !== null && $silk !== null && $medicine !== null && $tobacco !== null && $rum !== null && $new_crew !== null && $prisoners !== null && $sunken_ships !== null && $killed_crew !== null): ?>

	<p><?php echo $msg?></p>

	<ul>
		<?php if ($looted_money > 0): ?>
			<li class="attack_good" style="list-style-image: url('<?php echo base_url()?>assets/images/icons/bank.png');">You looted <?php echo $looted_money?> doubloons.</li>
		<?php endif; ?>

		<?php if ($prisoners > 0): ?>
			<li class="attack_good" style="list-style-image: url('<?php echo base_url()?>assets/images/icons/cityhall_prisoners.png');"><?php echo $prisoners?> of the crew were known troublemakers, you take them in as prisoners.</li>
		<?php endif; ?>
	</ul>

	<ul>
		<?php if ($sunken_ships > 0): ?>
			<li class="attack_good" style="list-style-image: url('<?php echo base_url()?>assets/images/icons/coast.png');"><?php echo $sunken_ships?> of your ships sunk because of ship damages.</li>
		<?php endif; ?>

		<?php if ($killed_crew > 0): ?>
			<li class="attack_good" style="list-style-image: url('<?php echo base_url()?>assets/images/icons/tavern_sailor.png');"><?php echo $killed_crew?> of your crew members died in battle.</li>
		<?php endif; ?>
	</ul>

	<section class="action-buttons">
		<?php if ($food > 0 || $water > 0 || $porcelain > 0 || $spices > 0 || $silk > 0 || $medicine > 0 || $tobacco > 0 || $rum > 0 || $new_crew > 0): ?>
			<a class="ajaxHTML nopic negative" href="<?php echo base_url('ocean/ship_won_cancel')?>">No thanks</a>
			<a class="nopic js-ocean-loot-take-all" href="#">Take All</a>
			<a class="nopic positive" href="javascript:if($('#won_form').submit());">Transfer</a>
		<?php else: ?>
			<a class="ajaxHTML nopic positive" href="<?php echo base_url('ocean/ship_won_cancel')?>">Sail away</a>
		<?php endif; ?>
	</section>

	<?php if (isset($game['error'])): ?>
		<div class="error"><p><?php echo $game['error']?></p></div>
	<?php endif; ?>

	<form method="post" class="ajaxJSON" id="won_form" action="<?php echo base_url('ocean/ship_won_transfer')?>">
		<input type="hidden" name="load_max" id="load_max" value="<?php echo $game['load_max']?>">
		<input type="hidden" name="load_current" id="load_current" value="<?php echo $game['load_current']?>">
		<input type="hidden" name="needed_food" id="needed_food" value="<?php echo $game['needed_food'] * 5?>">
		<input type="hidden" name="needed_water" id="needed_water" value="<?php echo $game['needed_water'] * 5?>">

		<?php if ($new_crew > 0): ?>
			<fieldset>
				<legend><img src="<?php echo base_url()?>assets/images/icons/tavern_sailor.png" alt="Food" width="32" height="32"> Crew recruits</legend>
				<p style="margin: 0 auto; width: 90%"><?php echo $new_crew?> sailors want's to join your crew. How many would you like to take in?
				</p>

				<div class="slider-container">
					<div id="crew-slider" class="slider"></div>

					<table>
						<tr><td>Crew members</td><td><span id="crew_new_quantity_presenter" style="color: <?php echo ($game['crew_members'] > $game['max_crew']) ? '#d52525' : '#000'; ?>;"><?php echo $game['crew_members']?></span> members</td></tr>
						<tr><td>Max crew</td><td><span class="max_crew"><?php echo $game['max_crew']?></span> members</td></tr>
					</table>
				</div>
				
				<input type="hidden" name="new_crew" id="new_crew" value="<?php echo $new_crew?>">
				<input type="hidden" name="crew_max" id="crew_max" value="<?php echo $game['max_crew'] + $new_crew?>">
				<input type="hidden" name="crew_quantity" id="crew_quantity" value="<?php echo $game['crew_members']?>">
				<input type="hidden" id="crew_new_quantity" name="crew_new_quantity" value="<?php echo $game['crew_members']?>">
			</fieldset>
		<?php endif; ?>

		<?php if ($food > 0): ?>
			<fieldset>
				<legend><img src="<?php echo base_url()?>assets/images/icons/market_browse.png" alt="Food" width="32" height="32"> Food</legend>
				<p style="margin: 0 auto; width: 90%">Food is needed for traveling at sea. A half a carton per crew member and week.
				<?php if ($game['food'] < ($game['needed_food'] * 5)): ?>
					To last 5 more weeks, you should have at least <strong><?php echo($game['needed_food'] * 5) ?></strong> cartons!
				<?php endif; ?>
				</p>

				<div class="slider-container">
					<div id="food-slider" class="slider"></div>

					<table>
						<tr><td>Food cartons</td><td><span id="food_new_quantity_presenter"><?php echo $game['food']?></span> pcs</td></tr>
						<tr><td>Ship load</td><td><span class="load_total" style="color: <?php echo ($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?php echo $game['load_current']?></span> cartons</td></tr>
					</table>
				</div>
				
				<input type="hidden" name="food_max" id="food_max" value="<?php echo $game['food'] + $food?>">
				<input type="hidden" name="food_quantity" id="food_quantity" value="<?php echo $game['food']?>">
				<input type="hidden" id="food_new_quantity" name="food_new_quantity" value="<?php echo $game['food']?>">
			</fieldset>
		<?php endif; ?>

		<?php if ($water > 0): ?>
			<fieldset>
				<legend><img src="<?php echo base_url()?>assets/images/icons/water.png" alt="Water" width="32" height="32"> Water</legend>
				<p style="margin: 0 auto; width: 90%">Water is needed for traveling at sea. 1 barrel per crew member and week.
				<?php if ($game['water'] < ($game['needed_water'] * 5)): ?>
					To last 5 more weeks, you should have at least <strong><?php echo($game['needed_water'] * 5) ?></strong> barrels!
				<?php endif; ?>
				</p>

				<div class="slider-container">
					<div id="water-slider" class="slider"></div>

					<table>
						<tr><td>Water barrels</td><td><span id="water_new_quantity_presenter"><?php echo $game['water']?></span> pcs</td></tr>
						<tr><td>Ship load</td><td><span class="load_total" style="color: <?php echo ($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?php echo $game['load_current']?></span> cartons</td></tr>
					</table>
				</div>

				<input type="hidden" name="water_max" id="water_max" value="<?php echo $game['water'] + $water?>">
				<input type="hidden" name="water_quantity" id="water_quantity" value="<?php echo $game['water']?>">
				<input type="hidden" id="water_new_quantity" name="water_new_quantity" value="<?php echo $game['water']?>">
			</fieldset>
		<?php endif; ?>

		<?php if ($porcelain > 0): ?>
			<fieldset>
				<legend><img src="<?php echo base_url()?>assets/images/icons/porcelain.png" alt="porcelain" width="32" height="32"> Porcelain</legend>

				<div class="slider-container">
					<div id="porcelain-slider" class="slider"></div>

					<table>
						<tr><td>Porcelain barrels</td><td><span id="porcelain_new_quantity_presenter"><?php echo $game['porcelain']?></span> pcs</td></tr>
						<tr><td>Ship load</td><td><span class="load_total" style="color: <?php echo ($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?php echo $game['load_current']?></span> cartons</td></tr>
					</table>
				</div>

				<input type="hidden" name="porcelain_max" id="porcelain_max" value="<?php echo $game['porcelain'] + $porcelain?>">
				<input type="hidden" name="porcelain_quantity" id="porcelain_quantity" value="<?php echo $game['porcelain']?>">
				<input type="hidden" id="porcelain_new_quantity" name="porcelain_new_quantity" value="<?php echo $game['porcelain']?>">
			</fieldset>
		<?php endif; ?>

		<?php if ($spices > 0): ?>
			<fieldset>
				<legend><img src="<?php echo base_url()?>assets/images/icons/spices.png" alt="spices" width="32" height="32"> Spices</legend>

				<div class="slider-container">
					<div id="spices-slider" class="slider"></div>

					<table>
						<tr><td>Spices barrels</td><td><span id="spices_new_quantity_presenter"><?php echo $game['spices']?></span> pcs</td></tr>
						<tr><td>Ship load</td><td><span class="load_total" style="color: <?php echo ($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?php echo $game['load_current']?></span> cartons</td></tr>
					</table>
				</div>

				<input type="hidden" name="spices_max" id="spices_max" value="<?php echo $game['spices'] + $spices?>">
				<input type="hidden" name="spices_quantity" id="spices_quantity" value="<?php echo $game['spices']?>">
				<input type="hidden" id="spices_new_quantity" name="spices_new_quantity" value="<?php echo $game['spices']?>">
			</fieldset>
		<?php endif; ?>

		<?php if ($silk > 0): ?>
			<fieldset>
				<legend><img src="<?php echo base_url()?>assets/images/icons/silk.png" alt="silk" width="32" height="32"> Silk</legend>

				<div class="slider-container">
					<div id="silk-slider" class="slider"></div>

					<table>
						<tr><td>Silk barrels</td><td><span id="silk_new_quantity_presenter"><?php echo $game['silk']?></span> pcs</td></tr>
						<tr><td>Ship load</td><td><span class="load_total" style="color: <?php echo ($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?php echo $game['load_current']?></span> cartons</td></tr>
					</table>
				</div>

				<input type="hidden" name="silk_max" id="silk_max" value="<?php echo $game['silk'] + $silk?>">
				<input type="hidden" name="silk_quantity" id="silk_quantity" value="<?php echo $game['silk']?>">
				<input type="hidden" id="silk_new_quantity" name="silk_new_quantity" value="<?php echo $game['silk']?>">
			</fieldset>
		<?php endif; ?>

		<?php if ($medicine > 0): ?>
			<fieldset>
				<legend><img src="<?php echo base_url()?>assets/images/icons/medicine.png" alt="medicine" width="32" height="32"> Medicine</legend>

				<div class="slider-container">
					<div id="medicine-slider" class="slider"></div>

					<table>
						<tr><td>Medicine barrels</td><td><span id="medicine_new_quantity_presenter"><?php echo $game['medicine']?></span> pcs</td></tr>
						<tr><td>Ship load</td><td><span class="load_total" style="color: <?php echo ($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?php echo $game['load_current']?></span> cartons</td></tr>
					</table>
				</div>

				<input type="hidden" name="medicine_max" id="medicine_max" value="<?php echo $game['medicine'] + $medicine?>">
				<input type="hidden" name="medicine_quantity" id="medicine_quantity" value="<?php echo $game['medicine']?>">
				<input type="hidden" id="medicine_new_quantity" name="medicine_new_quantity" value="<?php echo $game['medicine']?>">
			</fieldset>
		<?php endif; ?>

		<?php if ($tobacco > 0): ?>
			<fieldset>
				<legend><img src="<?php echo base_url()?>assets/images/icons/tobacco.png" alt="tobacco" width="32" height="32"> Tobacco</legend>

				<div class="slider-container">
					<div id="tobacco-slider" class="slider"></div>

					<table>
						<tr><td>Tobacco barrels</td><td><span id="tobacco_new_quantity_presenter"><?php echo $game['tobacco']?></span> pcs</td></tr>
						<tr><td>Ship load</td><td><span class="load_total" style="color: <?php echo ($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?php echo $game['load_current']?></span> cartons</td></tr>
					</table>
				</div>

				<input type="hidden" name="tobacco_max" id="tobacco_max" value="<?php echo $game['tobacco'] + $tobacco?>">
				<input type="hidden" name="tobacco_quantity" id="tobacco_quantity" value="<?php echo $game['tobacco']?>">
				<input type="hidden" id="tobacco_new_quantity" name="tobacco_new_quantity" value="<?php echo $game['tobacco']?>">
			</fieldset>
		<?php endif; ?>

		<?php if ($rum > 0): ?>
			<fieldset>
				<legend><img src="<?php echo base_url()?>assets/images/icons/rum.png" alt="rum" width="32" height="32"> Rum</legend>

				<div class="slider-container">
					<div id="rum-slider" class="slider"></div>

					<table>
						<tr><td>Rum barrels</td><td><span id="rum_new_quantity_presenter"><?php echo $game['rum']?></span> pcs</td></tr>
						<tr><td>Ship load</td><td><span class="load_total" style="color: <?php echo ($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?php echo $game['load_current']?></span> cartons</td></tr>
					</table>
				</div>

				<input type="hidden" name="rum_max" id="rum_max" value="<?php echo $game['rum'] + $rum?>">
				<input type="hidden" name="rum_quantity" id="rum_quantity" value="<?php echo $game['rum']?>">
				<input type="hidden" id="rum_new_quantity" name="rum_new_quantity" value="<?php echo $game['rum']?>">
			</fieldset>
		<?php endif; ?>

	</form>
<?php endif; ?>
