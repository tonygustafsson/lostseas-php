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
			Browse
		</a>
		<a class="ajaxHTML button big-icon" title="Heal your crew"
			href="<?=base_url('market/healer')?>">
			<svg width="32" height="32" alt="Healer">
				<use xlink:href="#healer"></use>
			</svg>
			Healer
		</a>
	</div>

	<?php if (count($game['event']['market']['items']) > 0 || isset($game['event']['market']['slaves'])): ?>
	<p>You browse the market for a while and find a couple of items of interest.</p>

	<div class="button-area">
		<?php foreach ($game['event']['market']['items'] as $item): ?>
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
				<?=$item['cost']?> dbl (<?=$item['cost'] / $item['quantity']?>
				dbl/pc)
			</span>
		</a>
		<?php endforeach; ?>

		<?php if (isset($game['event']['market']['slaves'])): ?>
		<a class="ajaxJSON button big-image"
			href="<?=base_url('market/buy_slaves')?>">
			<svg width="128" height="128" alt="Slaves">
				<use xlink:href="#prisoners">
				</use>
			</svg>
			<?=$game['event']['market']['slaves']['quantity']?>
			slaves<br />
			<span class="text-small">
				<?=$game['event']['market']['slaves']['cost']?>
				dbl (<?=$game['event']['market']['slaves']['cost'] / $game['event']['market']['slaves']['quantity']?>
				dbl/pc)
			</span>
		</a>
		<?php endif; ?>
	</div>
	<?php else: ?>
	<p><em>You browse the market and talk to some citizens, but you don't find anything of value.</em></p>
	<?php endif; ?>
</div>