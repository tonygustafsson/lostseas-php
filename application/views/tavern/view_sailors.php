<?php
    $sailors_disabled = $game['event_sailors'] === 'banned' ? 'disabled' : '';
?>

<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/sailors_' . $game['nation'] . '.jpg')?>"
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

	<?php if (! empty($game['event_sailors']) && is_numeric($game['event_sailors'])): ?>
	<section id="offer">
		<p>You talk to <?=$game['event_sailors']?>
			sailors. After a while they decides to join your crew. Do you want to take them in?</p>

		<div class="button-area">
			<a href="tavern/sailors_post/yes" class="ajaxJSON button big primary" title="Take these sailors in!">Yes</a>
			<a href="tavern/sailors_post/no" class="ajaxJSON button big"
				title="Tell them to mind their own business">No</a>
		</div>
	</section>
	<?php endif; ?>

	<?php if (!empty($msg)): ?>
	<p><em><?=$msg?></em></p>
	<?php endif; ?>
</div>