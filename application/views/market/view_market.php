<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/market_' . $game['nation'] . '.png')?>"
		class="area-header__img">
</header>

<div class="container">
	<div class="button-area">
		<a class="ajaxHTML button big-icon" title="Browse goods" id="action_goods"
			href="<?=base_url('market')?>">
			<svg width="32" height="32" alt="Goods">
				<use xlink:href="#barrels"></use>
			</svg>
			Goods
		</a>
		<?php if (!isset($game['event']['market_slaves']['banned'])): ?>
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

	<?php if (count($game['event']['market_goods']['items']) > 0): ?>
	<div class="button-area">
		<?php foreach ($game['event']['market_goods']['items'] as $item): ?>
		<a class="ajaxJSON button big-image"
			href="<?=base_url('market/buy/' .$item['item'])?>">
			<svg width="128" height="128"
				alt="<?=$item['item']?>">
				<use
					xlink:href="#<?=$item['item']?>">
				</use>
			</svg>
			<?=$item['quantity']?> <?=$item['item']?><br />
			<span class="text-small">
				<?=$item['cost']?> dbl (<?=$item['item_cost']?> dbl/pc)
			</span>
		</a>
		<?php endforeach; ?>
	</div>
	<?php else: ?>
	<p><em>You browse the market and talk to some citizens, but you don't find anything of value.</em></p>
	<?php endif; ?>
</div>