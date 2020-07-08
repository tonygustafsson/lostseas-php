<header class="area-header" class="area-header" title="Ship victory">
	<h2 class="area-header__heading">Caribbean Sea</h2>
	<img src="<?=base_url('assets/images/places/ocean_trade.png')?>"
		class="area-header__img">
</header>

<div class="container">
	<p>
		<?=$game['event']['ship_won_results']['msg']?>
	</p>

	<ul class="ocean-event-results">
		<?php if ($game['event']['ship_won_results']['doubloons'] > 0): ?>
		<li class="positive">
			<svg width="32" height="32" alt="Doubloons">
				<use xlink:href="#doubloons"></use>
			</svg>
			You looted <?=$game['event']['ship_won_results']['doubloons']?>
			doubloons.</li>
		<?php endif; ?>

		<?php if ($game['event']['ship_won_results']['prisoners'] > 0): ?>
		<li class="positive">
			<svg width="32" height="32" alt="Prisoners">
				<use xlink:href="#prisoners"></use>
			</svg>
			<?=$game['event']['ship_won_results']['prisoners']?>
			of the crew were known troublemakers, you
			take them in as prisoners.</li>
		<?php endif; ?>

		<?php if ($game['event']['ship_won_results']['sunken_ships'] > 0): ?>
		<li class="negative">
			<svg width="32" height="32" alt="Ship">
				<use xlink:href="#ship"></use>
			</svg>
			<?=$game['event']['ship_won_results']['sunken_ships']?>
			of your ships sunk because of ship
			damages.</li>
		<?php endif; ?>

		<?php if ($game['event']['ship_won_results']['crew_deaths'] > 0): ?>
		<li class="negative">
			<svg width="32" height="32" alt="Crew">
				<use xlink:href="#crew-man"></use>
			</svg>
			<?=$game['event']['ship_won_results']['crew_deaths']?>
			of your crew members died in battle.
		</li>
		<?php endif; ?>
	</ul>

	<form method="post" class="ajaxJSON" id="won_form"
		action="<?=base_url('ocean/ship_won_transfer')?>">
		<div class="button-area">
			<a class="ajaxHTML button"
				href="<?=base_url('ocean/ship_won_cancel')?>">No
				thanks</a>
			<a class="button js-ocean-loot-take-all" href="#">Take All</a>
			<button type="submit" class="button primary">Transfer</button>
		</div>

		<?php if (isset($game['error'])): ?>
		<div class="error">
			<p><?=$game['error']?>
			</p>
		</div>
		<?php endif; ?>

		<input type="hidden" name="load_max" id="load_max"
			value="<?=$game['load_max']?>">
		<input type="hidden" name="load_current" id="load_current"
			value="<?=$game['load_current']?>">
		<input type="hidden" name="needed_food" id="needed_food"
			value="<?=$game['needed_food'] * 5?>">
		<input type="hidden" name="needed_water" id="needed_water"
			value="<?=$game['needed_water'] * 5?>">

		<?php if ($game['event']['ship_won_results']['crew'] > 0): ?>
		<fieldset>
			<legend>
				<svg width="32" height="32" alt="Crew members">
					<use xlink:href="#crew-man"></use>
				</svg>
				Crew recruits
			</legend>

			<p style="margin: 0 auto; width: 90%"><?=$game['event']['ship_won_results']['crew']?>
				sailors
				want's to join your crew. How many would you like to take in?
			</p>

			<div class="slider-container">
				<div id="crew-slider" class="slider"></div>

				<table>
					<tr>
						<td>Crew members</td>
						<td><span id="crew_new_quantity_presenter"
								style="color: <?=($game['crew_members'] > $game['max_crew']) ? '#d52525' : '#000'; ?>;"><?=$game['crew_members']?></span>
							members</td>
					</tr>
					<tr>
						<td>Max crew</td>
						<td><span class="max_crew"><?=$game['max_crew']?></span>
							members</td>
					</tr>
				</table>
			</div>

			<input type="hidden" name="new_crew" id="new_crew"
				value="<?=$game['event']['ship_won_results']['crew']?>">
			<input type="hidden" name="crew_max" id="crew_max"
				value="<?=$game['max_crew'] + $game['event']['ship_won_results']['crew']?>">
			<input type="hidden" name="crew_quantity" id="crew_quantity"
				value="<?=$game['crew_members']?>">
			<input type="hidden" id="crew_new_quantity" name="crew_new_quantity"
				value="<?=$game['crew_members']?>">
		</fieldset>
		<?php endif; ?>

		<?php if ($game['event']['ship_won_results']['items']['food'] > 0): ?>
		<fieldset>
			<legend>
				<svg width="32" height="32" alt="Food">
					<use xlink:href="#food"></use>
				</svg>
				Food
			</legend>

			<p style="margin: 0 auto; width: 90%">
				Food is needed for traveling at sea.
				A half a carton per crew member and week.
				<?php if ($game['event']['ship_won_results']['items']['food'] < ($game['needed_food'] * 5)): ?>
				To last 5 more weeks, you should have at least <strong><?php echo($game['needed_food'] * 5) ?></strong>
				cartons!
				<?php endif; ?>
			</p>

			<div class="slider-container">
				<div id="food-slider" class="slider"></div>

				<table>
					<tr>
						<td>Food cartons</td>
						<td><span id="food_new_quantity_presenter"><?=$game['food']?></span>
							pcs</td>
					</tr>
					<tr>
						<td>Ship load</td>
						<td><span class="load_total"
								style="color: <?=($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?=$game['load_current']?></span>
							cartons</td>
					</tr>
				</table>
			</div>

			<input type="hidden" name="food_max" id="food_max"
				value="<?=$game['food'] + $game['event']['ship_won_results']['items']['food']?>">
			<input type="hidden" name="food_quantity" id="food_quantity"
				value="<?=$game['food']?>">
			<input type="hidden" id="food_new_quantity" name="food_new_quantity"
				value="<?=$game['food']?>">
		</fieldset>
		<?php endif; ?>

		<?php if ($game['event']['ship_won_results']['items']['water'] > 0): ?>
		<fieldset>
			<legend>
				<svg width="32" height="32" alt="Water">
					<use xlink:href="#water"></use>
				</svg>
				Water
			</legend>

			<p style="margin: 0 auto; width: 90%">Water is needed for traveling at sea. 1 barrel per crew member and
				week.
				<?php if ($game['water'] < ($game['needed_water'] * 5)): ?>
				To last 5 more weeks, you should have at least <strong><?php echo($game['needed_water'] * 5) ?></strong>
				barrels!
				<?php endif; ?>
			</p>

			<div class="slider-container">
				<div id="water-slider" class="slider"></div>

				<table>
					<tr>
						<td>Water barrels</td>
						<td><span id="water_new_quantity_presenter"><?=$game['water']?></span>
							pcs</td>
					</tr>
					<tr>
						<td>Ship load</td>
						<td><span class="load_total"
								style="color: <?=($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?=$game['load_current']?></span>
							cartons</td>
					</tr>
				</table>
			</div>

			<input type="hidden" name="water_max" id="water_max"
				value="<?=$game['water'] + $game['event']['ship_won_results']['items']['water']?>">
			<input type="hidden" name="water_quantity" id="water_quantity"
				value="<?=$game['water']?>">
			<input type="hidden" id="water_new_quantity" name="water_new_quantity"
				value="<?=$game['water']?>">
		</fieldset>
		<?php endif; ?>

		<?php if ($game['event']['ship_won_results']['items']['porcelain'] > 0): ?>
		<fieldset>
			<legend>
				<svg width="32" height="32" alt="Porcelain">
					<use xlink:href="#porcelain"></use>
				</svg>
				Porcelain
			</legend>

			<div class="slider-container">
				<div id="porcelain-slider" class="slider"></div>

				<table>
					<tr>
						<td>Porcelain barrels</td>
						<td><span id="porcelain_new_quantity_presenter"><?=$game['porcelain']?></span>
							pcs</td>
					</tr>
					<tr>
						<td>Ship load</td>
						<td><span class="load_total"
								style="color: <?=($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?=$game['load_current']?></span>
							cartons</td>
					</tr>
				</table>
			</div>

			<input type="hidden" name="porcelain_max" id="porcelain_max"
				value="<?=$game['porcelain'] + $game['event']['ship_won_results']['items']['porcelain']?>">
			<input type="hidden" name="porcelain_quantity" id="porcelain_quantity"
				value="<?=$game['porcelain']?>">
			<input type="hidden" id="porcelain_new_quantity" name="porcelain_new_quantity"
				value="<?=$game['porcelain']?>">
		</fieldset>
		<?php endif; ?>

		<?php if ($game['event']['ship_won_results']['items']['spices'] > 0): ?>
		<fieldset>
			<legend>
				<svg width="32" height="32" alt="Spices">
					<use xlink:href="#spices"></use>
				</svg>
				Spices
			</legend>

			<div class="slider-container">
				<div id="spices-slider" class="slider"></div>

				<table>
					<tr>
						<td>Spices barrels</td>
						<td><span id="spices_new_quantity_presenter"><?=$game['spices']?></span>
							pcs</td>
					</tr>
					<tr>
						<td>Ship load</td>
						<td><span class="load_total"
								style="color: <?=($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?=$game['load_current']?></span>
							cartons</td>
					</tr>
				</table>
			</div>

			<input type="hidden" name="spices_max" id="spices_max"
				value="<?=$game['spices'] + $game['event']['ship_won_results']['items']['spices']?>">
			<input type="hidden" name="spices_quantity" id="spices_quantity"
				value="<?=$game['spices']?>">
			<input type="hidden" id="spices_new_quantity" name="spices_new_quantity"
				value="<?=$game['spices']?>">
		</fieldset>
		<?php endif; ?>

		<?php if ($game['event']['ship_won_results']['items']['silk'] > 0): ?>
		<fieldset>
			<legend>
				<svg width="32" height="32" alt="Silk">
					<use xlink:href="#silk"></use>
				</svg>
				Silk
			</legend>

			<div class="slider-container">
				<div id="silk-slider" class="slider"></div>

				<table>
					<tr>
						<td>Silk barrels</td>
						<td><span id="silk_new_quantity_presenter"><?=$game['silk']?></span>
							pcs</td>
					</tr>
					<tr>
						<td>Ship load</td>
						<td><span class="load_total"
								style="color: <?=($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?=$game['load_current']?></span>
							cartons</td>
					</tr>
				</table>
			</div>

			<input type="hidden" name="silk_max" id="silk_max"
				value="<?=$game['silk'] + $game['event']['ship_won_results']['items']['silk']?>">
			<input type="hidden" name="silk_quantity" id="silk_quantity"
				value="<?=$game['silk']?>">
			<input type="hidden" id="silk_new_quantity" name="silk_new_quantity"
				value="<?=$game['silk']?>">
		</fieldset>
		<?php endif; ?>

		<?php if ($game['event']['ship_won_results']['items']['medicine'] > 0): ?>
		<fieldset>
			<legend>
				<svg width="32" height="32" alt="Medicine">
					<use xlink:href="#medicine"></use>
				</svg>
				Medicine
			</legend>

			<div class="slider-container">
				<div id="medicine-slider" class="slider"></div>

				<table>
					<tr>
						<td>Medicine barrels</td>
						<td><span id="medicine_new_quantity_presenter"><?=$game['medicine']?></span>
							pcs</td>
					</tr>
					<tr>
						<td>Ship load</td>
						<td><span class="load_total"
								style="color: <?=($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?=$game['load_current']?></span>
							cartons</td>
					</tr>
				</table>
			</div>

			<input type="hidden" name="medicine_max" id="medicine_max"
				value="<?=$game['medicine'] + $game['event']['ship_won_results']['items']['medicine']?>">
			<input type="hidden" name="medicine_quantity" id="medicine_quantity"
				value="<?=$game['medicine']?>">
			<input type="hidden" id="medicine_new_quantity" name="medicine_new_quantity"
				value="<?=$game['medicine']?>">
		</fieldset>
		<?php endif; ?>

		<?php if ($game['event']['ship_won_results']['items']['tobacco'] > 0): ?>
		<fieldset>
			<legend>
				<svg width="32" height="32" alt="Tobacco">
					<use xlink:href="#tobacco"></use>
				</svg>
				Tobacco
			</legend>

			<div class="slider-container">
				<div id="tobacco-slider" class="slider"></div>

				<table>
					<tr>
						<td>Tobacco barrels</td>
						<td><span id="tobacco_new_quantity_presenter"><?=$game['tobacco']?></span>
							pcs</td>
					</tr>
					<tr>
						<td>Ship load</td>
						<td><span class="load_total"
								style="color: <?=($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?=$game['load_current']?></span>
							cartons</td>
					</tr>
				</table>
			</div>

			<input type="hidden" name="tobacco_max" id="tobacco_max"
				value="<?=$game['tobacco'] + $game['event']['ship_won_results']['items']['tobacco']?>">
			<input type="hidden" name="tobacco_quantity" id="tobacco_quantity"
				value="<?=$game['tobacco']?>">
			<input type="hidden" id="tobacco_new_quantity" name="tobacco_new_quantity"
				value="<?=$game['tobacco']?>">
		</fieldset>
		<?php endif; ?>

		<?php if ($game['event']['ship_won_results']['items']['rum'] > 0): ?>
		<fieldset>
			<legend>
				<svg width="32" height="32" alt="Rum">
					<use xlink:href="#rum"></use>
				</svg>
				Rum
			</legend>

			<div class="slider-container">
				<div id="rum-slider" class="slider"></div>

				<table>
					<tr>
						<td>Rum barrels</td>
						<td><span id="rum_new_quantity_presenter"><?=$game['rum']?></span>
							pcs
						</td>
					</tr>
					<tr>
						<td>Ship load</td>
						<td><span class="load_total"
								style="color: <?=($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?=$game['load_current']?></span>
							cartons</td>
					</tr>
				</table>
			</div>

			<input type="hidden" name="rum_max" id="rum_max"
				value="<?=$game['rum'] + $game['event']['ship_won_results']['items']['rum']?>">
			<input type="hidden" name="rum_quantity" id="rum_quantity"
				value="<?=$game['rum']?>">
			<input type="hidden" id="rum_new_quantity" name="rum_new_quantity"
				value="<?=$game['rum']?>">
		</fieldset>
		<?php endif; ?>
	</form>
</div>