<?php
    $prices = array('food' => 16, 'water' => 12);
    list($trade_worth) = (! empty($game['event_ocean_trade'])) ? explode('###', $game['event_ocean_trade']) : array(null);
?>

<header title="Ocean Trade">
	<h2>Caribbean Sea</h2>
	<img src="<?php echo base_url('assets/images/places/ocean_trade.jpg')?>" class="header">
</header>

<?php if (isset($game['info'])): ?>
	<div class="info"><p><?php echo $game['info']?></p></div>
	<section class="action-buttons">
		<a class="ajaxHTML nopic" href="<?php echo base_url($game['place'])?>">Okay!</a>
	</section>
<?php endif; ?>

<?php if ($trade_worth !== null): ?>
	<p>You will only trade away as much barter goods as needed to give you the desired amount of food and water.
	Porcelain, silk and spices will be traded away first.</p>

	<section class="action-buttons">
		<a class="nopic js-ocean-trade-take-necessities" href="#">Take necessities</a>
		<a class="nopic js-ocean-trade-take-all" href="#">Take all</a><br>
		<a class="ajaxHTML nopic negative" href="<?php echo base_url('ocean/trade_cancel')?>">No thanks</a>
		<a class="nopic positive" href="javascript:if($('#trade').submit());">Trade</a>
	</section>
	
	<form class="ajaxJSON" method="post" id="trade" action="<?php echo base_url('ocean/trade_transfer')?>">
		<input type="hidden" name="trade_worth" id="trade_worth" value="<?php echo $trade_worth?>">
		<input type="hidden" name="load_max" id="load_max" value="<?php echo $game['load_max']?>">
		<input type="hidden" name="load_current" id="load_current" value="<?php echo $game['load_current']?>">
		<input type="hidden" name="needed_food" id="needed_food" value="<?php echo $game['needed_food'] * 5?>">
		<input type="hidden" name="needed_water" id="needed_water" value="<?php echo $game['needed_water'] * 5?>">
		<input type="hidden" name="load_barter_goods" id="load_barter_goods" value="<?php echo $game['porcelain'] + $game['spices'] + $game['silk'] + $game['medicine'] + $game['tobacco'] + $game['rum']?>">

		<?php foreach ($prices as $product => $price): ?>
			<input type="hidden" id="<?php echo $product?>_price" value="<?php echo $price?>">
		<?php endforeach; ?>

		<fieldset>
			<legend><img src="<?php echo base_url('assets/images/icons/market_browse.png')?>" alt="Food" width="32" height="32"> Food</legend>
			<p style="margin: 0 auto; width: 90%">Food is needed for traveling at sea. A half a carton per crew member and week.
				<?php if ($game['food'] < ($game['needed_food'] * 5)): ?>
					To last 5 more weeks, you should have at least <strong><?php echo($game['needed_food'] * 5) ?></strong> cartons!
				<?php endif; ?>
			</p>

			<div class="slider-container">
				<div id="food-slider" class="slider"></div>

				<table>
					<tr><td>Food cartons</td><td><span id="food_new_quantity_presenter"><?php echo $game['food']?></span> pcs</td></tr>
					<tr><td>Trade worth</td><td><span class="trade_worth_left" style="color: <?php echo ($trade_worth < 0) ? '#d52525' : '#000'; ?>;"><?php echo $trade_worth?></span> dbl</td></tr>
					<tr><td>Ship load</td><td><span class="load_total" style="color: <?php echo ($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?php echo $game['load_current']?></span> cartons</td></tr>
				</table>
			</div>
			
			<input type="hidden" name="food_quantity" id="food_quantity" value="<?php echo $game['food']?>">
			<input type="hidden" id="food_new_quantity" name="food_new_quantity" value="<?php echo $game['food']?>">
		</fieldset>

		<fieldset>
			<legend><img src="<?php echo base_url('assets/images/icons/water.png')?>" alt="Water" width="32" height="32"> Water</legend>
			<p style="margin: 0 auto; width: 90%">Water is needed for traveling at sea. 1 barrel per crew member and week.
				<?php if ($game['water'] < ($game['needed_water'] * 5)): ?>
					To last 5 more weeks, you should have at least <strong><?php echo($game['needed_water'] * 5) ?></strong> barrels!
				<?php endif; ?>
			</p>

			<div class="slider-container">
				<div id="water-slider" class="slider"></div>

				<table>
					<tr><td>Water barrels</td><td><span id="water_new_quantity_presenter"><?php echo $game['water']?></span> pcs</td></tr>
					<tr><td>Trade worth</td><td><span class="trade_worth_left" style="color: <?php echo ($trade_worth < 0) ? '#d52525' : '#000'; ?>;"><?php echo $trade_worth?></span> dbl</td></tr>
					<tr><td>Ship load</td><td><span class="load_total" style="color: <?php echo ($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?php echo $game['load_current']?></span> cartons</td></tr>
				</table>
			</div>
			
			<input type="hidden" name="water_quantity" id="water_quantity" value="<?php echo $game['water']?>">
			<input type="hidden" id="water_new_quantity" name="water_new_quantity" value="<?php echo $game['water']?>">
		</fieldset>

	</form>
<?php endif; ?>