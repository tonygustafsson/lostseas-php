<header title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2><?=$game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?=base_url('assets/images/places/shop_' . $game['nation'] . '.jpg')?>" class="header" alt="The shop">
</header>

<p>
	<?=$game['greeting']?>
</p>

<form method="post" class="ajaxJSON" action="<?=base_url('shop/transfer_post')?>">
	<input type="hidden" name="current_money" id="current_money" value="<?=$game['doubloons']?>">
	<input type="hidden" name="load_max" id="load_max" value="<?=$game['load_max']?>">
	<input type="hidden" name="needed_food" id="needed_food" value="<?=$game['needed_food'] * 5?>">
	<input type="hidden" name="needed_water" id="needed_water" value="<?=$game['needed_water'] * 5?>">
	
	<?php foreach ($prices as $product => $price): ?>
		<input type="hidden" id="<?=$product?>_buy" value="<?=$price['buy']?>">
		<input type="hidden" id="<?=$product?>_sell" value="<?=$price['sell']?>">
	<?php endforeach; ?>
	
	<div class="slider-container">
		<div class="slider-wrapper">
			<div id="food-slider" class="slider slider-vertical"></div>
			
			<div class="tooltip-multiline tooltip-bottom-left" data-tooltip="Needed for traveling at sea. Buy: <?=$prices['food']['buy']?> dbl, Sell: <?=$prices['food']['sell']?> dbl.">
				<img src="<?=base_url('assets/images/icons/market_browse.png')?>" alt="Food" width="32" height="32">
				<span>Food</span><br>
				<span id="food_new_quantity_presenter"><?=$game['food']?></span>
				<input type="hidden" name="food_quantity" id="food_quantity" value="<?=$game['food']?>">
				<input type="hidden" id="food_new_quantity" name="food_new_quantity" value="<?=$game['food']?>">
			</div>
		</div>
		
		<div class="slider-wrapper">
			<div id="water-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-center" data-tooltip="Needed for traveling at sea. Buy: <?=$prices['water']['buy']?> dbl, Sell: <?=$prices['water']['sell']?> dbl.">
				<img src="<?=base_url('assets/images/icons/water.png')?>" alt="Water" width="32" height="32">
				<span>Water</span><br>
				<span id="water_new_quantity_presenter"><?=$game['water']?></span>
				<input type="hidden" name="water_quantity" id="water_quantity" value="<?=$game['water']?>">
				<input type="hidden" id="water_new_quantity" name="water_new_quantity" value="<?=$game['water']?>">
			</div>
		</div>
		
		<div class="slider-wrapper">
			<div id="porcelain-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-center" data-tooltip="For trading. Buy: <?=$prices['porcelain']['buy']?> dbl, Sell: <?=$prices['porcelain']['sell']?> dbl.">
				<img src="<?=base_url('assets/images/icons/porcelain.png')?>" alt="Porcelain" width="32" height="32">
				<span>Porcelain</span><br>
				<span id="porcelain_new_quantity_presenter"><?=$game['porcelain']?></span>
				<input type="hidden" name="porcelain_quantity" id="porcelain_quantity" value="<?=$game['porcelain']?>">
				<input type="hidden" id="porcelain_new_quantity" name="porcelain_new_quantity" value="<?=$game['porcelain']?>">
			</div>
		</div>
		
		<div class="slider-wrapper">
			<div id="spices-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-right" data-tooltip="For trading. Buy: <?=$prices['spices']['buy']?> dbl, Sell: <?=$prices['spices']['sell']?> dbl.">
				<img src="<?=base_url('assets/images/icons/spices.png')?>" alt="Spices" width="32" height="32">
				<span>Spices</span><br>
				<span id="spices_new_quantity_presenter"><?=$game['spices']?></span>
				<input type="hidden" name="spices_quantity" id="spices_quantity" value="<?=$game['spices']?>">
				<input type="hidden" id="spices_new_quantity" name="spices_new_quantity" value="<?=$game['spices']?>">
			</div>
		</div>
		
		<div class="slider-wrapper">
			<div id="silk-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-left" data-tooltip="For trading. Buy: <?=$prices['silk']['buy']?> dbl, Sell: <?=$prices['silk']['sell']?> dbl.">
				<img src="<?=base_url('assets/images/icons/silk.png')?>" alt="Silk" width="32" height="32">
				<span>Silk</span><br>
				<span id="silk_new_quantity_presenter"><?=$game['silk']?></span>
				<input type="hidden" name="silk_quantity" id="silk_quantity" value="<?=$game['silk']?>">
				<input type="hidden" id="silk_new_quantity" name="silk_new_quantity" value="<?=$game['silk']?>">
			</div>
		</div>
		
		<div class="slider-wrapper">
			<div id="medicine-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-center" data-tooltip="Can heal individual crew members. Buy: <?=$prices['medicine']['buy']?> dbl, Sell: <?=$prices['medicine']['sell']?> dbl.">
				<img src="<?=base_url('assets/images/icons/medicine.png')?>" alt="Medicine" width="32" height="32">
				<span>Medicine</span><br>
				<span id="medicine_new_quantity_presenter"><?=$game['medicine']?></span>
				<input type="hidden" name="medicine_quantity" id="medicine_quantity" value="<?=$game['medicine']?>">
				<input type="hidden" id="medicine_new_quantity" name="medicine_new_quantity" value="<?=$game['medicine']?>">
			</div>
		</div>
		
		<div class="slider-wrapper">
			<div id="tobacco-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-center" data-tooltip="Can increase your crew members mood. Buy: <?=$prices['tobacco']['buy']?> dbl, Sell: <?=$prices['tobacco']['sell']?> dbl.">
				<img src="<?=base_url('assets/images/icons/tobacco.png')?>" alt="Tobacco" width="32" height="32">
				<span>Tobacco</span><br>
				<span id="tobacco_new_quantity_presenter"><?=$game['tobacco']?></span>
				<input type="hidden" name="tobacco_quantity" id="tobacco_quantity" value="<?=$game['tobacco']?>">
				<input type="hidden" id="tobacco_new_quantity" name="tobacco_new_quantity" value="<?=$game['tobacco']?>">
			</div>
		</div>
		
		<div class="slider-wrapper">
			<div id="rum-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-right" data-tooltip="Can increase your crew members mood. Buy: <?=$prices['rum']['buy']?> dbl, Sell: <?=$prices['rum']['sell']?> dbl.">
				<img src="<?=base_url('assets/images/icons/rum.png')?>" alt="Rum" width="32" height="32">
				<span>Rum</span><br>
				<span id="rum_new_quantity_presenter"><?=$game['rum']?></span>
				<input type="hidden" name="rum_quantity" id="rum_quantity" value="<?=$game['rum']?>">
				<input type="hidden" id="rum_new_quantity" name="rum_new_quantity" value="<?=$game['rum']?>">
			</div>
		</div>
		
	</div>
	
	<fieldset>
		<legend>Overview</legend>
		
		<table style="margin: 0 auto; width: 90%">
			<tr><td><span id="transfer_type">Cost</span></td><td><span id="total_cost">0</span> dbl</td></tr>
			<tr><td>Ship load</td><td><span class="load_total" style="color: <?=($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?=$game['load_current']?></span>/<?=$game['load_max']?> cartons</td></tr>
		</table>

		<p id="shop_overview" style="text-align: right;">
			<a href="#" class="shop-buy-necessities" title="Buy as much food and water you'll need for 5 days at sea"><img src="<?=base_url('assets/images/icons/buy_necessities.png')?>" alt="Buy necessities"></a>
			<a href="#" class="shop-sell-barter-goods" title="Sell all items you won't need at sea"><img src="<?=base_url('assets/images/icons/sell_barter_goods.png')?>" alt="Sell barter goods"></a>
			<a href="#" class="shop-reset" title="Start over, reset this form"><img src="<?=base_url('assets/images/icons/reset.png')?>" alt="Reset"></a>
			
			<input title="Make the deal" type="submit" value="Transfer" style="display: block; margin-top: -35px;">
		</p>
	</fieldset>
</form>
