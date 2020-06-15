<?php
    $prices = array('food' => 16, 'water' => 12);
    list($trade_worth) = (! empty($game['event_ocean_trade'])) ? explode('###', $game['event_ocean_trade']) : array(null);
?>

<header class="area-header" class="area-header" title="Ocean Trade">
	<h2 class="area-header__heading">Caribbean Sea</h2>
	<img src="<?=base_url('assets/images/places/ocean_trade.png')?>"
		class="area-header__img">
</header>

<div class="container">
	<?php if (isset($game['info'])): ?>
	<div class="info">
		<p><?=$game['info']?>
		</p>
	</div>
	<section class="button-area">
		<a class="ajaxHTML button big"
			href="<?=base_url($game['place'])?>">Okay!</a>
	</section>
	<?php endif; ?>

	<?php if ($trade_worth !== null): ?>
	<p>You will only trade away as much barter goods as needed to give you the desired amount of food and water.
		Porcelain, silk and spices will be traded away first.</p>

	<form class="ajaxJSON" method="POST" id="trade"
		action="<?=base_url('ocean/trade_transfer')?>">
		<div class="button-area">
			<a class="button js-ocean-trade-take-necessities" href="#">Take necessities</a>
			<a class="button js-ocean-trade-take-all" href="#">Take all</a><br>
			<a class="ajaxHTML button"
				href="<?=base_url('ocean/trade_cancel')?>">
				No thanks
			</a>
			<button type="submit" class="button primary">Trade</a>
		</div>

		<input type="hidden" name="trade_worth" id="trade_worth"
			value="<?=$trade_worth?>">
		<input type="hidden" name="load_max" id="load_max"
			value="<?=$game['load_max']?>">
		<input type="hidden" name="load_current" id="load_current"
			value="<?=$game['load_current']?>">
		<input type="hidden" name="needed_food" id="needed_food"
			value="<?=$game['needed_food'] * 5?>">
		<input type="hidden" name="needed_water" id="needed_water"
			value="<?=$game['needed_water'] * 5?>">
		<input type="hidden" name="load_barter_goods" id="load_barter_goods"
			value="<?=$game['porcelain'] + $game['spices'] + $game['silk'] + $game['medicine'] + $game['tobacco'] + $game['rum']?>">

		<?php foreach ($prices as $product => $price): ?>
		<input type="hidden" id="<?=$product?>_price"
			value="<?=$price?>">
		<?php endforeach; ?>

		<fieldset>
			<legend>
				<svg width="32" height="32" alt="Food">
					<use xlink:href="#food"></use>
				</svg>
				Food
			</legend>

			<p style="margin: 0 auto; width: 90%">Food is needed for traveling at sea. A half a carton per crew member
				and
				week.
				<?php if ($game['food'] < ($game['needed_food'] * 5)): ?>
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
						<td>Trade worth</td>
						<td><span class="trade_worth_left"
								style="color: <?=($trade_worth < 0) ? '#d52525' : '#000'; ?>;"><?=$trade_worth?></span> dbl</td>
					</tr>
					<tr>
						<td>Ship load</td>
						<td><span class="load_total"
								style="color: <?=($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?=$game['load_current']?></span>
							cartons</td>
					</tr>
				</table>
			</div>

			<input type="hidden" name="food_quantity" id="food_quantity"
				value="<?=$game['food']?>">
			<input type="hidden" id="food_new_quantity" name="food_new_quantity"
				value="<?=$game['food']?>">
		</fieldset>

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
						<td>Trade worth</td>
						<td><span class="trade_worth_left"
								style="color: <?=($trade_worth < 0) ? '#d52525' : '#000'; ?>;"><?=$trade_worth?></span> dbl</td>
					</tr>
					<tr>
						<td>Ship load</td>
						<td><span class="load_total"
								style="color: <?=($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?=$game['load_current']?></span>
							cartons</td>
					</tr>
				</table>
			</div>

			<input type="hidden" name="water_quantity" id="water_quantity"
				value="<?=$game['water']?>">
			<input type="hidden" id="water_new_quantity" name="water_new_quantity"
				value="<?=$game['water']?>">
		</fieldset>

	</form>
	<?php endif; ?>
</div>