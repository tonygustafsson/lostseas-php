<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/slaves_' . $game['nation'] . '.png')?>"
		class="area-header__img">
</header>

<div class="container">
	<div class="button-area">
		<?php if (!isset($game['event']['market_goods']['banned'])): ?>
		<a class="ajaxHTML button big-icon" title="Browse goods" id="action_goods"
			href="<?=base_url('market/goods')?>">
			<svg width="32" height="32" alt="Goods">
				<use xlink:href="#barrels"></use>
			</svg>
			Goods
		</a>
		<?php endif; ?>
		<?php if (!isset($game['event']['market_slaves']['banned'])): ?>
		<a class="ajaxHTML button big-icon" title="Look for slaves" id="action_slaves"
			href="<?=base_url('market/slaves')?>">
			<svg width="32" height="32" alt="Slaves">
				<use xlink:href="#prisoners"></use>
			</svg>
			Slaves
		</a>
		<?php endif; ?>
		<a class="ajaxHTML button big-icon" title="Heal your crew"
			href="<?=base_url('market/healer')?>">
			<svg width="32" height="32" alt="Healer">
				<use xlink:href="#healer"></use>
			</svg>
			Healer
		</a>
	</div>

	<?php if ($game['doubloons'] < $game['event']['market_slaves']['cost']): ?>
	<p>
		You find <?=$game['event']['market_slaves']['slaves']?>
		slaves with a health of <?=$game['event']['market_slaves']['health']?>%
		for <?=$game['event']['market_slaves']['cost']?>
		dbl! You don't have enough money though.
	</p>
	<?php else: ?>
	<div id="offer">
		<p>
			You find <?=$game['event']['market_slaves']['slaves']?>
			slaves with a health of <?=$game['event']['market_slaves']['health']?>%
			for <?=$game['event']['market_slaves']['cost']?>
			dbl! Do you wan't to buy?
		</p>

		<div class="button-area">
			<a class="ajaxJSON button big primary"
				href="<?=base_url('market/slaves_post/yes')?>"
				title="Yes, give me these find looking slaves!">Yes</a>
			<a class="ajaxJSON button big"
				href="<?=base_url('market/slaves_post/no')?>"
				title="No thank you">No</a>
		</div>
	</div>
	<?php endif; ?>
</div>