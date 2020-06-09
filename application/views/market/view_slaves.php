<?php if (! empty($this->data['game']['event_market_slaves']) && $this->data['game']['event_market_slaves'] != 'banned') {
    list($slaves, $health, $cost) = explode('###', $this->data['game']['event_market_slaves']);
} ?>

<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/slaves_' . $game['nation'] . '.jpg')?>"
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

<?php if (! empty($this->data['game']['event_market_slaves']) && $this->data['game']['event_market_slaves'] != 'banned'): ?>
<?php if ($game['doubloons'] < $cost): ?>
<p>
	You find <?=$slaves?> slaves with a health of <?=$health?>% for <?=$cost?> dbl! You don't have enough money though.
</p>
<?php else: ?>
<section id="offer" class="action-buttons">
	<p>
		You find <?=$slaves?> slaves with a health of <?=$health?>% for <?=$cost?> dbl! Do you wan't to buy?
	</p>

	<a class="ajaxJSON nopic positive" href="market/slaves_post/yes"
		title="Yes, give me these find looking slaves!">Yes</a>
	<a class="ajaxJSON nopic negative" href="market/slaves_post/no" title="No thank you">No</a>
</section>
<?php endif; ?>
<?php endif;
