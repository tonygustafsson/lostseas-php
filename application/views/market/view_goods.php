<?php if (! empty($this->user['game']['event_market_goods']) && $this->user['game']['event_market_goods'] != 'banned') {
    list($item, $quantity, $cost, $total_cost) = explode('###', $this->user['game']['event_market_goods']);
} ?>

<header title="<?php echo $game['town_human'] . ' ' . $game['place']?>">
	<h2><?php echo $game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?php echo base_url('assets/images/places/market_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<section class="action-buttons">
	<?php if ($game['event_market_goods'] != 'banned'): ?>
		<a class="ajaxHTML" title="Browse goods" id="action_goods" href="market/goods"><img src="<?php echo base_url()?>assets/images/icons/market_browse.png" alt="Goods" width="32" height="32">Goods</a>
	<?php endif; ?>
	<?php if ($game['event_market_slaves'] != 'banned'): ?>
		<a class="ajaxHTML" title="Look for slaves" id="action_slaves" href="market/slaves"><img src="<?php echo base_url()?>assets/images/icons/market_slaves.png" alt="Slaves" width="32" height="32">Slaves</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="Heal your crew" href="market/healer"><img src="<?php echo base_url()?>assets/images/icons/market_healer.png" alt="Healer" width="32" height="32">Healer</a>
</section>

<div id="msg"></div>

<?php if (! empty($this->user['game']['event_market_goods']) && $this->user['game']['event_market_goods'] != 'banned'): ?>
	<?php if ($game['doubloons'] < $total_cost): ?>
		<p id="offer">
			You find <?php echo $quantity?> cartons of <?php echo $item?> for <?php echo $total_cost?> dbl! (<?php echo $cost?> dbl/pcs) You don't have enough money though.
		</p>
	<?php else: ?>
		<section id="offer" class="action-buttons">
			<p>
				You find <?php echo $quantity?> cartons of <?php echo $item?> for <?php echo $total_cost?> dbl! (<?php echo $cost?> dbl/pcs) Do you wan't to buy?
			</p>

			<a class="ajaxJSON nopic positive" href="market/goods_post/yes" title="Yes please!">Yes</a>
			<a class="ajaxJSON nopic negative" href="market/goods_post/no" title="I don't want your junk">No</a>
		</section>
	<?php endif; ?>
<?php endif; ?>