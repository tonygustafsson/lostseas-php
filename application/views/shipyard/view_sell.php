<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/shipyard_' . $game['nation'] . '.png')?>"
		class="area-header__img">
</header>

<div class="container">
	<div class="button-area">
		<a class="ajaxHTML button big-icon" title="Buy ships and equipments" href="shipyard">
			<svg width="32" height="32" alt="Buy">
				<use xlink:href="#ship"></use>
			</svg>
			Buy
		</a>
		<a class="ajaxHTML button big-icon" title="Sell ships and equipments" href="shipyard/sell">
			<svg width="32" height="32" alt="Buy">
				<use xlink:href="#ship"></use>
			</svg>
			Sell
		</a>
		<a class="ajaxHTML button big-icon" title="Repair damaged ships" href="shipyard/repair">
			<svg width="32" height="32" alt="Buy">
				<use xlink:href="#wrench"></use>
			</svg>
			Repair
		</a>
	</div>

	<p>
		You can sell your ships here.
	</p>

	<div class="button-area">
		<?php foreach ($ship as $this_ship): ?>
		<a id="ship_<?=$this_ship['id']?>"
			class="ajaxJSON button big-image" style=""
			rel="Do you really want to sell this <?=$this_ship['type']?>?"
			title="Sell this <?=$this_ship['type']?>"
			href="<?=base_url('shipyard/sell_ship/' . $this_ship['id'])?>">
			<img
				src="<?=base_url('assets/images/ships/' . $this_ship['type'] . '.jpg')?>?>">
			<?=$this_ship['name']?><br>
			(<?=$this_ship['type']?>, <?=$prices[$this_ship['type']]['sell']?>
			dbl)
		</a>
		<?php endforeach; ?>
	</div>
</div>