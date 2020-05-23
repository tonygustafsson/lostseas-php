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

<p>
You can sell your ships here.
</p>

<section class="action-buttons">
	<?php foreach ($ship as $this_ship): ?>
		<a id="ship_<?php echo $this_ship['id']?>" class="ajaxJSON largepic" style="" rel="Do you really want to sell this <?php echo $this_ship['type']?>?" title="Sell this <?php echo $this_ship['type']?>" href="<?php echo base_url('shipyard/sell_ship/' . $this_ship['id'])?>">
			<img src="<?php echo base_url('assets/images/ships/' . $this_ship['type'] . '.jpg')?>?>">
			<?php echo $this_ship['name']?><br>
			(<?php echo $this_ship['type']?>, <?php echo $prices[$this_ship['type']]['sell']?> dbl)
		</a>
	<?php endforeach; ?>
</section>