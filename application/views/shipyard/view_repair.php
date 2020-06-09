<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/shipyard_' . $game['nation'] . '.jpg')?>"
		class="area-header__img">
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Buy ships and equipments" href="shipyard">
		<svg width="32" height="32" alt="Buy">
			<use xlink:href="#ship"></use>
		</svg>
		Buy
	</a>
	<a class="ajaxHTML" title="Sell ships and equipments" href="shipyard/sell">
		<svg width="32" height="32" alt="Buy">
			<use xlink:href="#ship"></use>
		</svg>
		Sell
	</a>
	<a class="ajaxHTML" title="Repair damaged ships" href="shipyard/repair">
		<svg width="32" height="32" alt="Buy">
			<use xlink:href="#wrench"></use>
		</svg>
		Repair
	</a>
</section>

<p>
	You can repair your ships here. You will only see your damaged ships.
</p>

<section class="action-buttons">
	<?php foreach ($ship as $this_ship): ?>
	<?php if ($this_ship['health'] < 100): ?>
	<a id="ship_<?=$this_ship['id']?>"
		class="ajaxJSON largepic" rel="Do you really want to repair this ship?"
		title="Repair this <?=$this_ship['type']?>. Damaged by <?php echo(100 - $this_ship['health'])?> %"
		href="<?=base_url('shipyard/repair_ship/' . $this_ship['id'])?>">
		<img
			src="<?=base_url('assets/images/ships/' . $this_ship['type'] . '.jpg')?>">
		<?=$this_ship['name']?><br>(<?php echo(100 - $this_ship['health']) * $prices['ship_repair']['buy']?>
		dbl)
	</a>
	<?php endif; ?>
	<?php endforeach; ?>
</section>

<?php if ($game['ship_health_lowest'] > 99): ?>
<div class="info">
	<p>Your ships seems to be in perfect health!</p>
</div>
<?php endif;
