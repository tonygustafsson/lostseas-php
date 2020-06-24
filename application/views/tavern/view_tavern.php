<?php
    $sailors_disabled = $game['event_sailors'] === 'banned' ? 'disabled' : '';
?>

<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/tavern_' . $game['nation'] . '.png')?>"
		class="area-header__img">
</header>

<div class="container">
	<div class="button-area">
		<a class="ajaxHTML button big-icon" title="Buy something to eat or drink" href="tavern">
			<svg width="32" height="32" alt="Buy">
				<use xlink:href="#rum"></use>
			</svg>
			Buy
		</a>
		<a id="actions_sailors" <?=$sailors_disabled?>
			class="ajaxHTML
			button big-icon" title="Talk to the sailors at the bar"
			href="<?=base_url('tavern/sailors')?>">
			<svg width="32" height="32" alt="Sailors">
				<use xlink:href="#pirate"></use>
			</svg>
			Sailors
		</a>
		<a class="ajaxHTML button big-icon" title="Gamble for gold!" href="tavern/gamble">
			<svg width="32" height="32" alt="Gamble">
				<use xlink:href="#dices"></use>
			</svg>
			Gamble
		</a>
	</div>

	<p>
		<?=$game['greeting']?>
	</p>

	<p>
		These items are bought for you and <em>all</em> your crew members. Therefore, the price will depend on
		the number of crew members.
	</p>

	<div class="button-area">
		<?php foreach ($viewdata['items'] as $item): ?>
		<a class="ajaxJSON button big-image tooltip-bottom-center"
			data-tooltip="<?=$item['description']?>"
			href="<?=$item['link']?>">
			<img src="<?=$item['image']?>">
			<?=$item['name']?>
			<br />
			<?=$item['price_buy']?>
			dbl
		</a>
		<?php endforeach; ?>
	</div>
</div>