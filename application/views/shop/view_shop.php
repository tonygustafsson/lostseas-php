<header class="area-header">
	<h2 class="area-header__heading">
		<?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/shop_' . $game['nation'] . '.png')?>"
		class="area-header__img" alt="The shop">
</header>

<div class="container">
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

		<div class="slider-container">
			<?php foreach ($viewdata['items'] as $index => $item): ?>
			<input type="hidden"
				id="<?=$item['id']?>_buy"
				value="<?=$item['price_buy']?>" />
			<input type="hidden"
				id="<?=$item['id']?>_sell"
				value="<?=$item['price_sell']?>" />
			<input type="hidden"
				name="<?=$item['id']?>_quantity"
				id="<?=$item['id']?>_quantity"
				value="<?=$item['value']?>">
			<input type="hidden"
				id="<?=$item['id']?>_new_quantity"
				name="<?=$item['id']?>_new_quantity"
				value="<?=$item['value']?>">

			<div class="slider-wrapper">
				<div id="<?=$item['id']?>-slider"
					class="slider slider-vertical"></div>

				<div class="tooltip-multiline <?=$index % 4 === 0 ? 'tooltip-bottom-left' : 'tooltip-bottom-right'?>"
					data-tooltip="<?=$item['description']?> Buy: <?=$item['price_buy']?> dbl, Sell: <?=$item['price_sell']?> dbl.">
					<svg width="32" height="32"
						alt="<?=$item['name']?>">
						<use
							xlink:href="<?=$item['icon']?>">
						</use>
					</svg>
					<span><?=$item['name']?></span><br>
					<span
						id="<?=$item['id']?>_new_quantity_presenter">
						<?=$item['value']?>
					</span>
				</div>
			</div>
			<?php endforeach; ?>
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
					<td>
						<span class="load_total"
							style="color: <?=($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;">
							<?=$game['load_current']?>
						</span>/<?=$game['load_max']?> cartons
					</td>
				</tr>
			</table>

			<button type="submit" class="primary">
				<svg width="32" height="32" alt="Doubloons">
					<use xlink:href="#doubloons"></use>
				</svg>
				Transfer
			</button>

			<p id="shop_overview" class="text-right">
				<a href="#" class="button shop-buy-necessities tooltip-bottom-right"
					data-tooltip="Buy as much food and water you'll need for 5 days at sea">
					<svg width="32" height="32" alt="Buy necessities">
						<use xlink:href="#food"></use>
					</svg>
					Buy necessities
				</a>

				<a href="#" class="button shop-sell-barter-goods tooltip-bottom-right"
					data-tooltip="Sell all items you won't need at sea">
					<svg width="32" height="32" alt="Sell barter goods">
						<use xlink:href="#barrels"></use>
					</svg>
					Sell barter goods
				</a>

				<a href="#" class="button shop-reset tooltip-bottom-right" data-tooltip="Start over, reset this form">
					<svg width="32" height="32" alt="Reset">
						<use xlink:href="#broom"></use>
					</svg>
					Reset
				</a>
			</p>
		</fieldset>
	</form>
</div>