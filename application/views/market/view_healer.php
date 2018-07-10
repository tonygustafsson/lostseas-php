<h2><?echo $game['town_human'] . ' ' . $game['place']?></h2>

<header title="<?php echo $game['town_human'] . ' ' . $game['place']?>">
	<h2><?php echo $game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?php echo base_url('assets/images/places/healer_' . $game['nation'] . '.jpg')?>" class="header">
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

<? if ($game['doubloons'] < $cost): ?>
	<p>
		<?php echo $injured_crew?> of your crew is injured, but you do not have <?php echo $cost?> dbl.
	</p>
<? elseif ($injured_crew < 1): ?>
	<p>
		Your crew seems kind of healthy too me... you don't need me!
	</p>
<? else: ?>
	<section id="offer" class="actions">
		<p>
			I can heal your <?php echo $injured_crew?> injured crew members. It will cost you <?php echo $cost?> dbl.
		</p>
		
		<a class="ajaxJSON nopic positive" href="market/healer_post/yes" title="Please heal us!">Yes</a>
		<a class="ajaxJSON nopic negative" href="market/healer_post/no" title="No hokus pokus today please">No</a>
	</section>
<? endif; ?>