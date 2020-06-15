<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/market_' . $game['nation'] . '.png')?>"
		class="area-header__img">
</header>

<div class="container">
	<div class="button-area">
		<?php if ($game['event_market_goods'] != 'banned'): ?>
		<a class="ajaxHTML button big-icon" title="Browse goods" id="action_goods" href="market/goods">
			<svg width="32" height="32" alt="Goods">
				<use xlink:href="#barrels"></use>
			</svg>
			Goods
		</a>
		<?php endif; ?>
		<?php if ($game['event_market_slaves'] != 'banned'): ?>
		<a class="ajaxHTML button big-icon" title="Look for slaves" id="action_slaves" href="market/slaves">
			<svg width="32" height="32" alt="Slaves">
				<use xlink:href="#prisoners"></use>
			</svg>
			Slaves
		</a>
		<?php endif; ?>
		<a class="ajaxHTML button big-icon" title="Heal your crew" href="market/healer">
			<svg width="32" height="32" alt="Healer">
				<use xlink:href="#healer"></use>
			</svg>
			Healer
		</a>
	</div>

	<p>
		<?=$game['greeting']?>
	</p>
</div>