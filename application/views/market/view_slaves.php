<? if (! empty($this->user['game']['event_market_slaves']) && $this->user['game']['event_market_slaves'] != 'banned') { list($slaves, $health, $cost) = explode('###', $this->user['game']['event_market_slaves']); } ?>

<header title="<?php echo $game['town_human'] . ' ' . $game['place']?>">
	<h2><?php echo $game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?php echo base_url('assets/images/places/slaves_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<section class="actions">
	<? if ($game['event_market_goods'] != 'banned'): ?>
		<a class="ajaxHTML" title="Browse goods" id="action_goods" href="market/goods"><img src="<?echo base_url()?>assets/images/icons/market_browse.png" alt="Goods" width="32" height="32">Goods</a>
	<? endif; ?>
	<? if ($game['event_market_slaves'] != 'banned'): ?>
		<a class="ajaxHTML" title="Look for slaves" id="action_slaves" href="market/slaves"><img src="<?echo base_url()?>assets/images/icons/market_slaves.png" alt="Slaves" width="32" height="32">Slaves</a>
	<? endif; ?>
	<a class="ajaxHTML" title="Heal your crew" href="market/healer"><img src="<?echo base_url()?>assets/images/icons/market_healer.png" alt="Healer" width="32" height="32">Healer</a>
</section>

<div id="msg"></div>

<? if (! empty($this->user['game']['event_market_slaves']) && $this->user['game']['event_market_slaves'] != 'banned'): ?>
	<? if ($game['doubloons'] < $cost): ?>
		<p>
			You find <?php echo $slaves?> slaves with a health of <?php echo $health?>% for <?php echo $cost?> dbl! You don't have enough money though.
		</p>
	<? else: ?>
		<section id="offer" class="actions">
			<p>
				You find <?php echo $slaves?> slaves with a health of <?php echo $health?>% for <?php echo $cost?> dbl! Do you wan't to buy?
			</p>
			
			<a class="ajaxJSON nopic positive" href="market/slaves_post/yes" title="Yes, give me these find looking slaves!">Yes</a>
			<a class="ajaxJSON nopic negative" href="market/slaves_post/no" title="No thank you">No</a>
		</section>
	<? endif; ?>
<? endif; ?>