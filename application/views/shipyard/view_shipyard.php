<?php if (isset($json)): ?>
	<script type="text/javascript">
		$(document).ready(function () {
			gameManipulateDOM(<?php echo $json?>);
		});
	</script>
<?php endif; ?>

<header title="<?php echo $game['town_human'] . ' ' . $game['place']?>">
	<h2><?php echo $game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?php echo base_url('assets/images/places/shipyard_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Buy ships and equipments" href="shipyard"><img src="<?php echo base_url()?>assets/images/icons/shipyard_buy.png" alt="Buy" width="32" height="32">Buy</a>
	<a class="ajaxHTML" title="Sell ships and equipments" href="shipyard/sell"><img src="<?php echo base_url()?>assets/images/icons/shipyard_sell.png" alt="Sell" width="32" height="32">Sell</a>
	<a class="ajaxHTML" title="Repair damaged ships" href="shipyard/repair"><img src="<?php echo base_url()?>assets/images/icons/shipyard_repair.png" alt="Repair" width="32" height="32">Repair</a>
</section>

<div id="msg"></div>

<p><?php echo $game['greeting']?></p>

<h3>Fixings</h3>

<form method="post" class="ajaxJSON" id="buy" action="<?php echo base_url()?>shipyard/fixings_post">
	<input type="hidden" name="current_money" id="current_money" value="<?php echo $game['doubloons']?>">

	<?php foreach ($prices as $product => $price): ?>
		<input type="hidden" id="<?php echo $product?>_buy" value="<?php echo $price['buy']?>">
		<input type="hidden" id="<?php echo $product?>_sell" value="<?php echo $price['sell']?>">
	<?php endforeach; ?>
	
	<fieldset style="margin-bottom: 0;">
		<legend><img src="<?php echo base_url()?>assets/images/icons/shipyard_fixings.png"> Cannons (<?php echo $prices['cannons']['buy']?>/<?php echo floor($prices['cannons']['sell'] * 0.7)?> dbl)</legend>
		<p style="margin: 0 auto; width: 90%">It's your cannons that make you win at sea battles! You need 2 crew members per cannon though, or else it will not be used.</p>
		<div id="cannons-slider" style="width: 90%; margin: 20px;"></div>

		<table style="margin: 0 auto; width: 90%">
			<tr><td>Cannons</td><td><span id="cannons_new_quantity_presenter"><?php echo $game['cannons']?></span> pcs</td></tr>
			<tr><td>Doubloons</td><td><span class="money_left" style="color: <?php echo ($game['doubloons'] < 0) ? '#d52525' : '#000'; ?>;"><?php echo $game['doubloons']?></span> dbl</td></tr>
		</table>

		<input type="hidden" name="cannons_quantity" id="cannons_quantity" value="<?php echo $game['cannons']?>">
		<input type="hidden" name="cannons_new_quantity" id="cannons_new_quantity" value="<?php echo $game['cannons']?>">
	</fieldset>
	
	<fieldset style="margin-bottom: 0;">
		<legend><img src="<?php echo base_url()?>assets/images/icons/raft.png"> Rafts (<?php echo $prices['rafts']['buy']?>/<?php echo floor($prices['rafts']['sell'] * 0.7)?> dbl)</legend>
		<p style="margin: 0 auto; width: 90%">If all your ships are destroyed at sea, you can save 10 crew members per raft.</p>
		<div id="rafts-slider" style="width: 90%; margin: 20px;"></div>

		<table style="margin: 0 auto; width: 90%">
			<tr><td>Rafts</td><td><span id="rafts_new_quantity_presenter"><?php echo $game['rafts']?></span> pcs</td></tr>
			<tr><td>Doubloons</td><td><span class="money_left" style="color: <?php echo ($game['doubloons'] < 0) ? '#d52525' : '#000'; ?>;"><?php echo $game['doubloons']?></span> dbl</td></tr>
		</table>

		<input type="hidden" name="rafts_quantity" id="rafts_quantity" value="<?php echo $game['rafts']?>">
		<input type="hidden" name="rafts_new_quantity" id="rafts_new_quantity" value="<?php echo $game['rafts']?>">
	</fieldset>

	<p style="text-align: right;">
		<button type="button" onclick="return shipyardReset();">Reset</button>
		<input type="submit" value="Transfer">
	</p>
</form>

<h3>Ships</h3>

<p>Buy ships by clicking the images, see their specifications below...</p>

<section class="action-buttons">
	<a class="ajaxJSON largepic" href="<?php echo base_url('shipyard/buy_ship/brig')?>" rel="Do you really want to buy this brig?">
		<img src="<?php echo base_url('assets/images/ships/brig.jpg')?>" title="A standard ship, affordable.">Brig<br>
		<?php echo $prices['brig']['buy']?> dbl
	</a>
	<a class="ajaxJSON largepic" href="<?php echo base_url('shipyard/buy_ship/merchantman')?>" rel="Do you really want to buy this merchantman?">
		<img src="<?php echo base_url('assets/images/ships/merchantman.jpg')?>" title="A ship that is great for loading a lot of cartons.">Merchantman<br>
		<?php echo $prices['merchantman']['buy']?> dbl
	</a>
	<a class="ajaxJSON largepic" href="<?php echo base_url('shipyard/buy_ship/galleon')?>" rel="Do you really want to buy this galleon?">
		<img src="<?php echo base_url('assets/images/ships/galleon.jpg')?>" title="A war ship.">Galleon<br>
		<?php echo $prices['galleon']['buy']?> dbl
	</a>
	<a class="ajaxJSON largepic" href="<?php echo base_url('shipyard/buy_ship/frigate')?>" rel="Do you really want to buy this frigate?">
		<img src="<?php echo base_url('assets/images/ships/frigate.jpg')?>" title="The biggest and strongest war ship.">Frigate<br>
		<?php echo $prices['frigate']['buy']?> dbl
	</a>
</section>

<table>
	<tr>
		<th>Type</th>
		<th>Min crew</th>
		<th>Max crew</th>
		<th>Max cannons</th>
		<th>Max load</th>
	</tr>
	<tr>
		<td>Brig</td>
		<td>2</td>
		<td>20</td>
		<td>10</td>
		<td>500 cartons</td>
	</tr>
	<tr>
		<td>Merchantman</td>
		<td>1</td>
		<td>10</td>
		<td>0</td>
		<td>1000 cartons</td>
	</tr>
	<tr>
		<td>Galleon</td>
		<td>4</td>
		<td>50</td>
		<td>25</td>
		<td>300 cartons</td>
	</tr>
	<tr>
		<td>Frigate</td>
		<td>8</td>
		<td>100</td>
		<td>50</td>
		<td>600 cartons</td>
	</tr>
</table>
