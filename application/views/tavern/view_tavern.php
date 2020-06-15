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
		<a class="ajaxJSON button big-image" title="Buy dinners for you and your crew members"
			href="<?=base_url('tavern/buy_post/dinners')?>">
			<img src="<?=base_url('assets/images/tavern/tavern_dinner.jpg')?>"
				title="Increases your crew members health by +25 and their mood by +3">
			Dinners<br><?=floor($prices['tavern_dinners']['buy'] * ($game['crew_members'] + 1))?>
			dbl
		</a>

		<a class="ajaxJSON button big-image" title="Buy wenches for you and your crew members"
			href="<?=base_url('tavern/buy_post/wenches')?>">
			<img src="<?=base_url('assets/images/tavern/tavern_wench.jpg')?>"
				title="Increases your crew members health by +10 and their mood by +5.">
			Wenches<br><?=floor($prices['tavern_wenches']['buy'] * ($game['crew_members'] + 1))?>
			dbl
		</a>

		<a class="ajaxJSON button big-image" title="Buy wine for you and your crew members"
			href="<?=base_url('tavern/buy_post/wine')?>">
			<img src="<?=base_url('assets/images/tavern/tavern_wine.jpg')?>"
				title="Increases your crew members mood by +7.">
			Wine<br><?=floor($prices['tavern_wine']['buy'] * ($game['crew_members'] + 1))?>
			dbl
		</a>

		<a class="ajaxJSON button big-image" title="Buy rum for you and your crew members"
			href="<?=base_url('tavern/buy_post/rum')?>">
			<img src="<?=base_url('assets/images/tavern/tavern_rum.jpg')?>"
				title="Increases your crew members mood by +10.">
			Rum<br><?=floor($prices['tavern_rum']['buy'] * ($game['crew_members'] + 1))?>
			dbl
		</a>
	</div>
</div>