<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/shop_' . $game['nation'] . '.jpg')?>"
		class="area-header__img" alt="The shop">
</header>

<p>
	<?=$game['greeting']?>
</p>

<form method="post" class="ajaxJSON"
	action="<?=base_url('shop/transfer_post')?>">
	<input type="hidden" name="current_money" id="current_money"
		value="<?=$game['doubloons']?>">
	<input type="hidden" name="load_max" id="load_max"
		value="<?=$game['load_max']?>">
	<input type="hidden" name="needed_food" id="needed_food"
		value="<?=$game['needed_food'] * 5?>">
	<input type="hidden" name="needed_water" id="needed_water"
		value="<?=$game['needed_water'] * 5?>">

	<?php foreach ($prices as $product => $price): ?>
	<input type="hidden" id="<?=$product?>_buy"
		value="<?=$price['buy']?>">
	<input type="hidden" id="<?=$product?>_sell"
		value="<?=$price['sell']?>">
	<?php endforeach; ?>

	<div class="slider-container">
		<div class="slider-wrapper">
			<div id="food-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-left"
				data-tooltip="Needed for traveling at sea. Buy: <?=$prices['food']['buy']?> dbl, Sell: <?=$prices['food']['sell']?> dbl.">
				<svg width="32" height="32" alt="Food">
					<use xlink:href="#food"></use>
				</svg>
				<span>Food</span><br>
				<span id="food_new_quantity_presenter"><?=$game['food']?></span>
				<input type="hidden" name="food_quantity" id="food_quantity"
					value="<?=$game['food']?>">
				<input type="hidden" id="food_new_quantity" name="food_new_quantity"
					value="<?=$game['food']?>">
			</div>
		</div>

		<div class="slider-wrapper">
			<div id="water-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-center"
				data-tooltip="Needed for traveling at sea. Buy: <?=$prices['water']['buy']?> dbl, Sell: <?=$prices['water']['sell']?> dbl.">
				<svg width="32" height="32" alt="Water">
					<use xlink:href="#water"></use>
				</svg>
				<span>Water</span><br>
				<span id="water_new_quantity_presenter"><?=$game['water']?></span>
				<input type="hidden" name="water_quantity" id="water_quantity"
					value="<?=$game['water']?>">
				<input type="hidden" id="water_new_quantity" name="water_new_quantity"
					value="<?=$game['water']?>">
			</div>
		</div>

		<div class="slider-wrapper">
			<div id="porcelain-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-center"
				data-tooltip="For trading. Buy: <?=$prices['porcelain']['buy']?> dbl, Sell: <?=$prices['porcelain']['sell']?> dbl.">
				<svg width="32" height="32" alt="Porclelain">
					<use xlink:href="#porcelain"></use>
				</svg>
				<span>Porcelain</span><br>
				<span id="porcelain_new_quantity_presenter"><?=$game['porcelain']?></span>
				<input type="hidden" name="porcelain_quantity" id="porcelain_quantity"
					value="<?=$game['porcelain']?>">
				<input type="hidden" id="porcelain_new_quantity" name="porcelain_new_quantity"
					value="<?=$game['porcelain']?>">
			</div>
		</div>

		<div class="slider-wrapper">
			<div id="spices-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-right"
				data-tooltip="For trading. Buy: <?=$prices['spices']['buy']?> dbl, Sell: <?=$prices['spices']['sell']?> dbl.">
				<svg width="32" height="32" alt="Spices">
					<use xlink:href="#spices"></use>
				</svg>
				<span>Spices</span><br>
				<span id="spices_new_quantity_presenter"><?=$game['spices']?></span>
				<input type="hidden" name="spices_quantity" id="spices_quantity"
					value="<?=$game['spices']?>">
				<input type="hidden" id="spices_new_quantity" name="spices_new_quantity"
					value="<?=$game['spices']?>">
			</div>
		</div>

		<div class="slider-wrapper">
			<div id="silk-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-left"
				data-tooltip="For trading. Buy: <?=$prices['silk']['buy']?> dbl, Sell: <?=$prices['silk']['sell']?> dbl.">
				<svg width="32" height="32" alt="Silk">
					<use xlink:href="#silk"></use>
				</svg>
				<span>Silk</span><br>
				<span id="silk_new_quantity_presenter"><?=$game['silk']?></span>
				<input type="hidden" name="silk_quantity" id="silk_quantity"
					value="<?=$game['silk']?>">
				<input type="hidden" id="silk_new_quantity" name="silk_new_quantity"
					value="<?=$game['silk']?>">
			</div>
		</div>

		<div class="slider-wrapper">
			<div id="medicine-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-center"
				data-tooltip="Can heal individual crew members. Buy: <?=$prices['medicine']['buy']?> dbl, Sell: <?=$prices['medicine']['sell']?> dbl.">
				<svg width="32" height="32" alt="Medicine">
					<use xlink:href="#medicine"></use>
				</svg>
				<span>Medicine</span><br>
				<span id="medicine_new_quantity_presenter"><?=$game['medicine']?></span>
				<input type="hidden" name="medicine_quantity" id="medicine_quantity"
					value="<?=$game['medicine']?>">
				<input type="hidden" id="medicine_new_quantity" name="medicine_new_quantity"
					value="<?=$game['medicine']?>">
			</div>
		</div>

		<div class="slider-wrapper">
			<div id="tobacco-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-center"
				data-tooltip="Can increase your crew members mood. Buy: <?=$prices['tobacco']['buy']?> dbl, Sell: <?=$prices['tobacco']['sell']?> dbl.">
				<svg width="32" height="32" alt="Tobacco">
					<use xlink:href="#tobacco"></use>
				</svg>
				<span>Tobacco</span><br>
				<span id="tobacco_new_quantity_presenter"><?=$game['tobacco']?></span>
				<input type="hidden" name="tobacco_quantity" id="tobacco_quantity"
					value="<?=$game['tobacco']?>">
				<input type="hidden" id="tobacco_new_quantity" name="tobacco_new_quantity"
					value="<?=$game['tobacco']?>">
			</div>
		</div>

		<div class="slider-wrapper">
			<div id="rum-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-right"
				data-tooltip="Can increase your crew members mood. Buy: <?=$prices['rum']['buy']?> dbl, Sell: <?=$prices['rum']['sell']?> dbl.">
				<svg width="32" height="32" alt="Rum">
					<use xlink:href="#rum"></use>
				</svg>
				<span>Rum</span><br>
				<span id="rum_new_quantity_presenter"><?=$game['rum']?></span>
				<input type="hidden" name="rum_quantity" id="rum_quantity"
					value="<?=$game['rum']?>">
				<input type="hidden" id="rum_new_quantity" name="rum_new_quantity"
					value="<?=$game['rum']?>">
			</div>
		</div>

	</div>

	<fieldset>
		<legend>Overview</legend>

		<table>
			<tr>
				<td><span id="transfer_type">Cost</span></td>
				<td><span id="total_cost">0</span> dbl</td>
			</tr>
			<tr>
				<td>Ship load</td>
				<td><span class="load_total"
						style="color: <?=($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?=$game['load_current']?></span>/<?=$game['load_max']?> cartons</td>
			</tr>
		</table>

		<button type="submit" class="primary">Transfer</button>

		<p id="shop_overview" class="shop__quick-menu">
			<a href="#" class="shop-buy-necessities tooltip-bottom-right"
				data-tooltip="Buy as much food and water you'll need for 5 days at sea">
				<svg width="32" height="32" alt="Buy necessities">
					<use xlink:href="#food"></use>
				</svg>
			</a>

			<a href="#" class="shop-sell-barter-goods tooltip-bottom-right"
				data-tooltip="Sell all items you won't need at sea">
				<svg width="32" height="32" alt="Sell barter goods">
					<use xlink:href="#barrels"></use>
				</svg>
			</a>

			<a href="#" class="shop-reset tooltip-bottom-right" data-tooltip="Start over, reset this form">
				<svg width="32" height="32" alt="Reset">
					<use xlink:href="#broom"></use>
				</svg>
			</a>
		</p>
	</fieldset>
</form>