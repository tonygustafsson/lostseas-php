<header title="<?php echo $game['town_human'] . ' ' . $game['place']?>" place="<?php echo $game['place']?>">
	<h2><?php echo $game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?php echo base_url('assets/images/places/shop_' . $game['nation'] . '.jpg')?>" class="header" alt="The shop">
</header>

<p>
	<?php echo $game['greeting']?>
</p>

<div id="msg"></div>

<form method="post" class="ajaxJSON" action="<?php echo base_url('shop/transfer_post')?>">
	<input type="hidden" name="current_money" id="current_money" value="<?php echo $game['doubloons']?>">
	<input type="hidden" name="load_max" id="load_max" value="<?php echo $game['load_max']?>">
	<input type="hidden" name="needed_food" id="needed_food" value="<?php echo $game['needed_food'] * 5?>">
	<input type="hidden" name="needed_water" id="needed_water" value="<?php echo $game['needed_water'] * 5?>">
	
	<?php foreach ($prices as $product => $price): ?>
		<input type="hidden" id="<?php echo $product?>_buy" value="<?php echo $price['buy']?>">
		<input type="hidden" id="<?php echo $product?>_sell" value="<?php echo $price['sell']?>">
	<?php endforeach; ?>
	
	<div class="slider-container">
		<div class="slider-wrapper">
			<div id="food-slider" class="slider slider-vertical"></div>
			
			<div class="tooltip-multiline tooltip-bottom-left" data-tooltip="Needed for traveling at sea. Buy: <?php echo $prices['food']['buy']?> dbl, Sell: <?php echo $prices['food']['sell']?> dbl.">
				<img src="<?php echo base_url('assets/images/icons/market_browse.png')?>" alt="Food" width="32" height="32">
				<span>Food</span><br>
				<span id="food_new_quantity_presenter"><?php echo $game['food']?></span>
				<input type="hidden" name="food_quantity" id="food_quantity" value="<?php echo $game['food']?>">
				<input type="hidden" id="food_new_quantity" name="food_new_quantity" value="<?php echo $game['food']?>">
			</div>
		</div>
		
		<div class="slider-wrapper">
			<div id="water-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-center" data-tooltip="Needed for traveling at sea. Buy: <?php echo $prices['water']['buy']?> dbl, Sell: <?php echo $prices['water']['sell']?> dbl.">
				<img src="<?php echo base_url('assets/images/icons/water.png')?>" alt="Water" width="32" height="32">
				<span>Water</span><br>
				<span id="water_new_quantity_presenter"><?php echo $game['water']?></span>
				<input type="hidden" name="water_quantity" id="water_quantity" value="<?php echo $game['water']?>">
				<input type="hidden" id="water_new_quantity" name="water_new_quantity" value="<?php echo $game['water']?>">
			</div>
		</div>
		
		<div class="slider-wrapper">
			<div id="porcelain-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-center" data-tooltip="For trading. Buy: <?php echo $prices['porcelain']['buy']?> dbl, Sell: <?php echo $prices['porcelain']['sell']?> dbl.">
				<img src="<?php echo base_url('assets/images/icons/porcelain.png')?>" alt="Porcelain" width="32" height="32">
				<span>Porcelain</span><br>
				<span id="porcelain_new_quantity_presenter"><?php echo $game['porcelain']?></span>
				<input type="hidden" name="porcelain_quantity" id="porcelain_quantity" value="<?php echo $game['porcelain']?>">
				<input type="hidden" id="porcelain_new_quantity" name="porcelain_new_quantity" value="<?php echo $game['porcelain']?>">
			</div>
		</div>
		
		<div class="slider-wrapper">
			<div id="spices-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-right" data-tooltip="For trading. Buy: <?php echo $prices['spices']['buy']?> dbl, Sell: <?php echo $prices['spices']['sell']?> dbl.">
				<img src="<?php echo base_url('assets/images/icons/spices.png')?>" alt="Spices" width="32" height="32">
				<span>Spices</span><br>
				<span id="spices_new_quantity_presenter"><?php echo $game['spices']?></span>
				<input type="hidden" name="spices_quantity" id="spices_quantity" value="<?php echo $game['spices']?>">
				<input type="hidden" id="spices_new_quantity" name="spices_new_quantity" value="<?php echo $game['spices']?>">
			</div>
		</div>
		
		<div class="slider-wrapper">
			<div id="silk-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-left" data-tooltip="For trading. Buy: <?php echo $prices['silk']['buy']?> dbl, Sell: <?php echo $prices['silk']['sell']?> dbl.">
				<img src="<?php echo base_url('assets/images/icons/silk.png')?>" alt="Silk" width="32" height="32">
				<span>Silk</span><br>
				<span id="silk_new_quantity_presenter"><?php echo $game['silk']?></span>
				<input type="hidden" name="silk_quantity" id="silk_quantity" value="<?php echo $game['silk']?>">
				<input type="hidden" id="silk_new_quantity" name="silk_new_quantity" value="<?php echo $game['silk']?>">
			</div>
		</div>
		
		<div class="slider-wrapper">
			<div id="medicine-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-center" data-tooltip="Can heal individual crew members. Buy: <?php echo $prices['medicine']['buy']?> dbl, Sell: <?php echo $prices['medicine']['sell']?> dbl.">
				<img src="<?php echo base_url('assets/images/icons/medicine.png')?>" alt="Medicine" width="32" height="32">
				<span>Medicine</span><br>
				<span id="medicine_new_quantity_presenter"><?php echo $game['medicine']?></span>
				<input type="hidden" name="medicine_quantity" id="medicine_quantity" value="<?php echo $game['medicine']?>">
				<input type="hidden" id="medicine_new_quantity" name="medicine_new_quantity" value="<?php echo $game['medicine']?>">
			</div>
		</div>
		
		<div class="slider-wrapper">
			<div id="tobacco-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-center" data-tooltip="Can increase your crew members mood. Buy: <?php echo $prices['tobacco']['buy']?> dbl, Sell: <?php echo $prices['tobacco']['sell']?> dbl.">
				<img src="<?php echo base_url('assets/images/icons/tobacco.png')?>" alt="Tobacco" width="32" height="32">
				<span>Tobacco</span><br>
				<span id="tobacco_new_quantity_presenter"><?php echo $game['tobacco']?></span>
				<input type="hidden" name="tobacco_quantity" id="tobacco_quantity" value="<?php echo $game['tobacco']?>">
				<input type="hidden" id="tobacco_new_quantity" name="tobacco_new_quantity" value="<?php echo $game['tobacco']?>">
			</div>
		</div>
		
		<div class="slider-wrapper">
			<div id="rum-slider" class="slider slider-vertical"></div>

			<div class="tooltip-multiline tooltip-bottom-right" data-tooltip="Can increase your crew members mood. Buy: <?php echo $prices['rum']['buy']?> dbl, Sell: <?php echo $prices['rum']['sell']?> dbl.">
				<img src="<?php echo base_url('assets/images/icons/rum.png')?>" alt="Rum" width="32" height="32">
				<span>Rum</span><br>
				<span id="rum_new_quantity_presenter"><?php echo $game['rum']?></span>
				<input type="hidden" name="rum_quantity" id="rum_quantity" value="<?php echo $game['rum']?>">
				<input type="hidden" id="rum_new_quantity" name="rum_new_quantity" value="<?php echo $game['rum']?>">
			</div>
		</div>
		
	</div>
	
	<fieldset>
		<legend>Overview</legend>
		
		<table style="margin: 0 auto; width: 90%">
			<tr><td><span id="transfer_type">Cost</span></td><td><span id="total_cost">0</span> dbl</td></tr>
			<tr><td>Ship load</td><td><span class="load_total" style="color: <?php echo ($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?php echo $game['load_current']?></span>/<?php echo $game['load_max']?> cartons</td></tr>
		</table>

		<p id="shop_overview" style="text-align: right;">
			<a href="#" class="shop-buy-necessities" title="Buy as much food and water you'll need for 5 days at sea"><img src="<?php echo base_url('assets/images/icons/buy_necessities.png')?>" alt="Buy necessities"></a>
			<a href="#" class="shop-sell-barter-goods" title="Sell all items you won't need at sea"><img src="<?php echo base_url('assets/images/icons/sell_barter_goods.png')?>" alt="Sell barter goods"></a>
			<a href="#" class="shop-reset" title="Start over, reset this form"><img src="<?php echo base_url('assets/images/icons/reset.png')?>" alt="Reset"></a>
			
			<input title="Make the deal" type="submit" value="Transfer" style="display: block; margin-top: -35px;">
		</p>
	</fieldset>
</form>
