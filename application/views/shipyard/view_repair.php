<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/shipyard_' . $game['nation'] . '.png')?>"
		class="area-header__img">
</header>

<div class="container">
	<div class="button-area">
		<a class="ajaxHTML button big-icon" title="Buy ships and equipments"
			href="<?=base_url('shipyard')?>">
			<svg width="32" height="32" alt="Buy">
				<use xlink:href="#ship"></use>
			</svg>
			Buy
		</a>
		<a class="ajaxHTML button big-icon" title="Sell ships and equipments"
			href="<?=base_url('shipyard/sell')?>">
			<svg width="32" height="32" alt="Buy">
				<use xlink:href="#ship"></use>
			</svg>
			Sell
		</a>
		<a class="ajaxHTML button big-icon" title="Repair damaged ships"
			href="<?=base_url('shipyard/repair')?>">
			<svg width="32" height="32" alt="Buy">
				<use xlink:href="#wrench"></use>
			</svg>
			Repair
		</a>
	</div>

	<p>
		You can repair your ships here. You will only see your damaged ships.
	</p>

	<div class="button-area">
		<?php foreach ($ship as $this_ship): ?>
		<?php if ($this_ship['health'] < 100): ?>
		<a id="ship_<?=$this_ship['id']?>"
			class="ajaxJSON button big-image" rel="Do you really want to repair this ship?"
			title="Repair this <?=$this_ship['type']?>. Damaged by <?php echo(100 - $this_ship['health'])?> %"
			href="<?=base_url('shipyard/repair_ship/' . $this_ship['id'])?>">
			<img
				src="<?=base_url('assets/images/ships/' . $this_ship['type'] . '.jpg')?>">
			<?=$this_ship['name']?><br>(<?php echo(100 - $this_ship['health']) * $prices['ship_repair']['buy']?>
			dbl)
		</a>
		<?php endif; ?>
		<?php endforeach; ?>
	</div>

	<?php if ($game['ship_health_lowest'] > 99): ?>
	<div class="info">
		<p>Your ships seems to be in perfect health!</p>
	</div>
	<?php endif; ?>
</div>