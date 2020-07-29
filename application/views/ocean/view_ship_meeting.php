<header class="area-header" class="area-header" title="Ship Meeting">
	<?php if ($game['event']['ship_meeting']['nation'] === 'pirate'): ?>
	<h2 class="area-header__heading">Pirate <?=$game['event']['ship_meeting']['type']?>
	</h2>
	<?php elseif ($game['event']['ship_meeting']['nation'] == $game['enemy']): ?>
	<h2 class="area-header__heading">Enemy <?=$game['event']['ship_meeting']['type']?>
	</h2>
	<?php elseif ($game['event']['ship_meeting']['nation'] == $game['nationality']): ?>
	<h2 class="area-header__heading">Ally <?=$game['event']['ship_meeting']['type']?>
	</h2>
	<?php else: ?>
	<h2 class="area-header__heading"><?=ucfirst($game['event']['ship_meeting']['type'])?>
		from <?=ucfirst($game['event']['ship_meeting']['nation'])?>

	</h2>
	<?php endif; ?>

	<img src="<?=base_url('assets/images/places/ship_meeting_' . $game['event']['ship_meeting']['nation'] . '.png')?>"
		class="area-header__img">
</header>

<div class="container">
	<?php if (isset($game['msg'])): ?>
	<div class="success">
		<p><?=$game['msg']?>
		</p>
	</div>
	<?php endif; ?>

	<?php if ($game['event']['ship_meeting']['nation'] === 'pirate'): ?>
	<p>You meet a pirate <?=$game['event']['ship_meeting']['type']?>!
		It has a <strong><?=$game['event']['ship_meeting']['crew']?>
			crew members</strong> and <strong><?=$game['event']['ship_meeting']['cannons']?>
			cannons</strong>. What do you wan't to do?</p>

	<?php elseif ($game['event']['ship_meeting']['nation'] == $game['enemy']): ?>
	<p>You meet a <?=$game['event']['ship_meeting']['type']?>
		from your enemy <?=ucfirst($game['event']['ship_meeting']['nation'])?>!
		It has <strong><?=$game['event']['ship_meeting']['crew']?>
			crew members</strong> and <strong><?=$game['event']['ship_meeting']['cannons']?>
			cannons</strong>. What do you wan't to do?</p>

	<?php elseif ($game['event']['ship_meeting']['nation'] == $game['nationality']): ?>
	<p>You meet a <?=$game['event']['ship_meeting']['type']?>
		from your allies <?=ucfirst($game['event']['ship_meeting']['nation'])?>!
		It has <strong><?=$game['event']['ship_meeting']['crew']?>
			crew members</strong> and <strong><?=$game['event']['ship_meeting']['cannons']?>
			cannons</strong>. What do you wan't to do?</p>

	<?php else: ?>
	<p>You meet a <?=$game['event']['ship_meeting']['type']?>
		from <?=ucfirst($game['event']['ship_meeting']['nation'])?>!
		It has <strong><?=$game['event']['ship_meeting']['crew']?>
			crew members</strong> and <strong><?=$game['event']['ship_meeting']['cannons']?>
			cannons</strong>. What do you wan't to do?</p>
	<?php endif; ?>

	<?php if ($game['event']['ship_meeting']['nation'] == $game['nationality']): ?>
	<p>If you attack an ally ship your level will be lowered. Only do so if you plan to change your nationality.</p>
	<?php endif; ?>

	<p class="mobile-only">
		Choose from the Actions menu.
	</p>
</div>