<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/healer_' . $game['nation'] . '.png')?>"
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

	<?php if ($game['doubloons'] < $cost): ?>
	<p>
		<?=$injured_crew?> of your crew is injured, but you do not
		have
		<?=$cost?> dbl.
	</p>
	<?php elseif ($injured_crew < 1): ?>
	<p>
		Your crew seems kind of healthy too me... you don't need me!
	</p>
	<?php else: ?>
	<div id="offer">
		<p>
			I can heal your <?=$injured_crew?> injured crew members.
			It
			will cost you <?=$cost?> dbl.
		</p>

		<div class="button-area">
			<a class="ajaxJSON button big primary" href="market/healer_post/yes" title="Please heal us!">Yes</a>
			<a class="ajaxJSON button big" href="market/healer_post/no" title="No hokus pokus today please">No</a>
		</div>
	</div>
	<?php endif; ?>
</div>