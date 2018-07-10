<?php if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?php echo $json?>);
	</script>
<?php endif; ?>

<header title="<?php echo $game['town_human'] . ' ' . $game['place']?>">
	<h2><?php echo $game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?php echo base_url('assets/images/places/shipyard_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<section class="actions">
	<a class="ajaxHTML" title="Buy ships and equipments" href="shipyard"><img src="<?php echo base_url()?>assets/images/icons/shipyard_buy.png" alt="Buy" width="32" height="32">Buy</a>
	<a class="ajaxHTML" title="Sell ships and equipments" href="shipyard/sell"><img src="<?php echo base_url()?>assets/images/icons/shipyard_sell.png" alt="Sell" width="32" height="32">Sell</a>
	<a class="ajaxHTML" title="Repair damaged ships" href="shipyard/repair"><img src="<?php echo base_url()?>assets/images/icons/shipyard_repair.png" alt="Repair" width="32" height="32">Repair</a>
</section>

<p>
	You can repair your ships here. You will only see your damaged ships.
</p>

<div id="msg"></div>

<section class="actions">
	<?php foreach($ship as $this_ship): ?>
		<?php if ($this_ship['health'] < 100): ?>
			<a id="ship_<?php echo $this_ship['id']?>" class="ajaxJSON largepic" rel="Do you really want to repair this ship?" title="Repair this <?php echo $this_ship['type']?>. Damaged by <?php echo (100 - $this_ship['health'])?> %" href="<?php echo base_url('shipyard/repair_ship/' . $this_ship['id'])?>">
				<img src="<?php echo base_url('assets/images/ships/' . $this_ship['type'] . '.jpg')?>">
				<?php echo $this_ship['name']?><br>(<?php echo (100 - $this_ship['health']) * $prices['ship_repair']['buy']?> dbl)
			</a>
		<?php endif; ?>
	<?php endforeach; ?>
</section>

<?php if ($game['ship_health_lowest'] > 99): ?>
	<div class="info">
		<p>Your ships seems to be in perfect health!</p>
	</div>
<?php endif; ?>