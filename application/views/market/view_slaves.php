<?php if (! empty($this->data['game']['event_market_slaves']) && $this->data['game']['event_market_slaves'] != 'banned') {
    list($slaves, $health, $cost) = explode('###', $this->data['game']['event_market_slaves']);
} ?>

<header title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2><?=$game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?=base_url('assets/images/places/slaves_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<section class="action-buttons">
	<?php if ($game['event_market_goods'] != 'banned'): ?>
		<a class="ajaxHTML" title="Browse goods" id="action_goods" href="market/goods"><img src="<?=base_url()?>assets/images/icons/market_browse.png" alt="Goods" width="32" height="32">Goods</a>
	<?php endif; ?>
	<?php if ($game['event_market_slaves'] != 'banned'): ?>
		<a class="ajaxHTML" title="Look for slaves" id="action_slaves" href="market/slaves"><img src="<?=base_url()?>assets/images/icons/market_slaves.png" alt="Slaves" width="32" height="32">Slaves</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="Heal your crew" href="market/healer"><img src="<?=base_url()?>assets/images/icons/market_healer.png" alt="Healer" width="32" height="32">Healer</a>
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
			
			<a class="ajaxJSON nopic positive" href="market/slaves_post/yes" title="Yes, give me these find looking slaves!">Yes</a>
			<a class="ajaxJSON nopic negative" href="market/slaves_post/no" title="No thank you">No</a>
		</section>
	<?php endif; ?>
<?php endif; ?>