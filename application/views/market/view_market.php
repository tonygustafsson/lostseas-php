<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/market_' . $game['nation'] . '.jpg')?>"
		class="area-header__img">
</header>

<section class="action-buttons">
	<?php if ($game['event_market_goods'] != 'banned'): ?>
	<a class="ajaxHTML" title="Browse goods" id="action_goods" href="market/goods">
		<svg width="32" height="32" alt="Goods">
			<use xlink:href="#barrels"></use>
		</svg>
		Goods
	</a>
	<?php endif; ?>
	<?php if ($game['event_market_slaves'] != 'banned'): ?>
	<a class="ajaxHTML" title="Look for slaves" id="action_slaves" href="market/slaves">
		<svg width="32" height="32" alt="Slaves">
			<use xlink:href="#prisoners"></use>
		</svg>
		Slaves
	</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="Heal your crew" href="market/healer">
		<svg width="32" height="32" alt="Healer">
			<use xlink:href="#healer"></use>
		</svg>
		Healer
	</a>
</section>

<p>
	<?=$game['greeting']?>
</p>