<?php if (! empty($this->data['game']['event_market_goods']) && $this->data['game']['event_market_goods'] != 'banned') {
    list($item, $quantity, $cost, $total_cost) = explode('###', $this->data['game']['event_market_goods']);
} ?>

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
		<a class="ajaxHTML button big-icon" title="Browse goods" id="action_goods"
			href="<?=base_url('market/goods')?>">
			<svg width="32" height="32" alt="Goods">
				<use xlink:href="#barrels"></use>
			</svg>
			Goods
		</a>
		<?php endif; ?>
		<?php if ($game['event_market_slaves'] != 'banned'): ?>
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

	<?php if (! empty($this->data['game']['event_market_goods']) && $this->data['game']['event_market_goods'] != 'banned'): ?>
	<?php if ($game['doubloons'] < $total_cost): ?>
	<p id="offer">
		You find <?=$quantity?> cartons of <?=$item?> for <?=$total_cost?> dbl! (<?=$cost?> dbl/pcs) You don't have enough money though.
	</p>
	<?php else: ?>
	<div id="offer">
		<p>
			You find <?=$quantity?> cartons of <?=$item?> for <?=$total_cost?> dbl! (<?=$cost?> dbl/pcs) Do you wan't to buy?
		</p>

		<div class="button-area">
			<a class="ajaxJSON button big primary" href="market/goods_post/yes" title="Yes please!">Yes</a>
			<a class="ajaxJSON button big" href="market/goods_post/no" title="I don't want your junk">No</a>
		</div>
	</div>
	<?php endif; ?>
	<?php endif; ?>
</div>