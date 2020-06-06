<header
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/healer_' . $game['nation'] . '.jpg')?>"
		class="header">
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

<?php if ($game['doubloons'] < $cost): ?>
<p>
	<?=$injured_crew?> of your crew is injured, but you do not have
	<?=$cost?> dbl.
</p>
<?php elseif ($injured_crew < 1): ?>
<p>
	Your crew seems kind of healthy too me... you don't need me!
</p>
<?php else: ?>
<section id="offer" class="action-buttons">
	<p>
		I can heal your <?=$injured_crew?> injured crew members. It
		will cost you <?=$cost?> dbl.
	</p>

	<a class="ajaxJSON nopic positive" href="market/healer_post/yes" title="Please heal us!">Yes</a>
	<a class="ajaxJSON nopic negative" href="market/healer_post/no" title="No hokus pokus today please">No</a>
</section>
<?php endif;
