<? $prices = array('food' => 16, 'water' => 12) ?>
<? list($trade_worth) = (! empty($game['event_ocean_trade'])) ? explode('###', $game['event_ocean_trade']) : array(NULL); ?>

<? if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?=$json?>);
	</script>
<? endif; ?>

<header title="Ocean Trade">
	<h2>Caribbean Sea</h2>
	<img src="<?echo base_url('assets/images/places/ocean_trade.jpg')?>" class="header">
</header>

<? if (isset($game['info'])): ?>
	<div class="info"><p><?=$game['info']?></p></div>
	<section class="actions">
		<a class="ajaxHTML nopic" href="<?=base_url($game['place'])?>">Okay!</a>
	</section>
<? endif; ?>

<div id="msg"></div>

<? if ($trade_worth !== NULL): ?>
	<p>You will only trade away as much barter goods as needed to give you the desired amount of food and water.
	Porcelain, silk and spices will be traded away first.</p>

	<section class="actions">
		<a class="nopic" href="javascript:tradeNecessities();">Take necessities</a>
		<a class="nopic" href="javascript:tradeAll();">Take all</a><br>
		<a class="ajaxHTML nopic negative" href="<?=base_url('ocean/trade_cancel')?>">No thanks</a>
		<a class="nopic positive" href="javascript:if($('#trade').submit());">Trade</a>
	</section>
	
	<form class="ajaxJSON" method="post" id="trade" action="<?echo base_url('ocean/trade_transfer')?>">
		<input type="hidden" name="trade_worth" id="trade_worth" value="<?=$trade_worth?>">
		<input type="hidden" name="load_max" id="load_max" value="<?=$game['load_max']?>">
		<input type="hidden" name="load_current" id="load_current" value="<?=$game['load_current']?>">
		<input type="hidden" name="needed_food" id="needed_food" value="<?=$game['needed_food'] * 5?>">
		<input type="hidden" name="needed_water" id="needed_water" value="<?=$game['needed_water'] * 5?>">
		<input type="hidden" name="load_barter_goods" id="load_barter_goods" value="<?echo $game['porcelain'] + $game['spices'] + $game['silk'] + $game['medicine'] + $game['tobacco'] + $game['rum']?>">

		<? foreach ($prices as $product => $price): ?>
			<input type="hidden" id="<?=$product?>_price" value="<?=$price?>">
		<? endforeach; ?>

		<fieldset>
			<legend><img src="<?echo base_url('assets/images/icons/market_browse.png')?>" alt="Food" width="32" height="32"> Food</legend>
			<p style="margin: 0 auto; width: 90%">Food is needed for traveling at sea. A half a carton per crew member and week.
			<? if ($game['food'] < ($game['needed_food'] * 5)): ?>
				To last 5 more weeks, you should have at least <strong><? echo ($game['needed_food'] * 5) ?></strong> cartons!
			<? endif; ?>
			</p>
			<div id="food-slider" style="width: 90%; margin: 20px;"></div>
			<table style="margin: 0 auto; width: 90%">
				<tr><td>Food cartons</td><td><span id="food_new_quantity_presenter"><?=$game['food']?></span> pcs</td></tr>
				<tr><td>Trade worth</td><td><span class="trade_worth_left" style="color: <? echo ($trade_worth < 0) ? '#d52525' : '#000'; ?>;"><?=$trade_worth?></span> dbl</td></tr>
				<tr><td>Ship load</td><td><span class="load_total" style="color: <? echo ($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?=$game['load_current']?></span> cartons</td></tr>
			</table>
			
			<input type="hidden" name="food_quantity" id="food_quantity" value="<?=$game['food']?>">
			<input type="hidden" id="food_new_quantity" name="food_new_quantity" value="<?=$game['food']?>">
		</fieldset>

		<fieldset>
			<legend><img src="<?echo base_url('assets/images/icons/water.png')?>" alt="Water" width="32" height="32"> Water</legend>
			<p style="margin: 0 auto; width: 90%">Water is needed for traveling at sea. 1 barrel per crew member and week.
			<? if ($game['water'] < ($game['needed_water'] * 5)): ?>
				To last 5 more weeks, you should have at least <strong><? echo ($game['needed_water'] * 5) ?></strong> barrels!
			<? endif; ?>
			</p>
			<div id="water-slider" style="width: 90%; margin: 20px;"></div>
			<table style="margin: 0 auto; width: 90%">
				<tr><td>Water barrels</td><td><span id="water_new_quantity_presenter"><?=$game['water']?></span> pcs</td></tr>
				<tr><td>Trade worth</td><td><span class="trade_worth_left" style="color: <? echo ($trade_worth < 0) ? '#d52525' : '#000'; ?>;"><?=$trade_worth?></span> dbl</td></tr>
				<tr><td>Ship load</td><td><span class="load_total" style="color: <? echo ($game['load_current'] > $game['load_max']) ? '#d52525' : '#000'; ?>;"><?=$game['load_current']?></span> cartons</td></tr>
			</table>
			
			<input type="hidden" name="water_quantity" id="water_quantity" value="<?=$game['water']?>">
			<input type="hidden" id="water_new_quantity" name="water_new_quantity" value="<?=$game['water']?>">
		</fieldset>

	</form>
<? endif; ?>