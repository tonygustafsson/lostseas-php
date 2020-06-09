<?php if (! empty($this->data['game']['event_market_goods']) && $this->data['game']['event_market_goods'] != 'banned') {
    list($item, $quantity, $cost, $total_cost) = explode('###', $this->data['game']['event_market_goods']);
} ?>

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

<?php if (! empty($this->data['game']['event_market_goods']) && $this->data['game']['event_market_goods'] != 'banned'): ?>
<?php if ($game['doubloons'] < $total_cost): ?>
<p id="offer">
	You find <?=$quantity?> cartons of <?=$item?> for <?=$total_cost?> dbl! (<?=$cost?> dbl/pcs) You don't have enough money though.
</p>
<?php else: ?>
<section id="offer" class="action-buttons">
	<p>
		You find <?=$quantity?> cartons of <?=$item?> for <?=$total_cost?> dbl! (<?=$cost?> dbl/pcs) Do you wan't to buy?
	</p>

	<a class="ajaxJSON nopic positive" href="market/goods_post/yes" title="Yes please!">Yes</a>
	<a class="ajaxJSON nopic negative" href="market/goods_post/no" title="I don't want your junk">No</a>
</section>
<?php endif; ?>
<?php endif;
