<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/sailors_' . $game['nation'] . '.jpg')?>"
		class="area-header__img">
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Buy something to eat or drink" href="tavern">
		<svg width="32" height="32" alt="Buy">
			<use xlink:href="#rum"></use>
		</svg>
		Buy
	</a>
	<?php if ($game['event_sailors'] != 'banned'): ?>
	<a id="actions_sailors" class="ajaxHTML" title="Talk to the sailors at the bar"
		href="<?=base_url('tavern/sailors')?>">
		<svg width="32" height="32" alt="Sailors">
			<use xlink:href="#pirate"></use>
		</svg>
		Sailors
	</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="Gamble for gold!" href="tavern/gamble">
		<svg width="32" height="32" alt="Gamble">
			<use xlink:href="#dices"></use>
		</svg>
		Gamble
	</a>
</section>

<?php if (! empty($game['event_sailors']) && is_numeric($game['event_sailors'])): ?>
<section id="offer">
	<p>You talk to <?=$game['event_sailors']?>
		sailors. After a while they decides to join your crew. Do you want to take them in?</p>

	<section class="action-buttons">
		<a href="tavern/sailors_post/yes" class="ajaxJSON nopic positive" title="Take these sailors in!">Yes</a>
		<a href="tavern/sailors_post/no" class="ajaxJSON nopic negative"
			title="Tell them to mind their own business">No</a>
	</section>
</section>
<?php endif;
