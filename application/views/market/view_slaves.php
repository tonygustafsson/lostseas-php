<?php if (! empty($this->data['game']['event_market_slaves']) && $this->data['game']['event_market_slaves'] != 'banned') {
    list($slaves, $health, $cost) = explode('###', $this->data['game']['event_market_slaves']);
} ?>

<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/slaves_' . $game['nation'] . '.png')?>"
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

	<?php if (! empty($this->data['game']['event_market_slaves']) && $this->data['game']['event_market_slaves'] != 'banned'): ?>
	<?php if ($game['doubloons'] < $cost): ?>
	<p>
		You find <?=$slaves?> slaves with a health of <?=$health?>% for <?=$cost?> dbl! You don't have enough money though.
	</p>
	<?php else: ?>
	<div id="offer">
		<p>
			You find <?=$slaves?> slaves with a health of <?=$health?>% for <?=$cost?> dbl! Do you wan't to buy?
		</p>

		<div class="button-area">
			<a class="ajaxJSON button big primary" href="market/slaves_post/yes"
				title="Yes, give me these find looking slaves!">Yes</a>
			<a class="ajaxJSON button big" href="market/slaves_post/no" title="No thank you">No</a>
		</div>
	</div>
	<?php endif; ?>
	<?php endif; ?>
</div>