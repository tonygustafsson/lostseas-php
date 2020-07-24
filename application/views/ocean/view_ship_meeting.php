<header class="area-header" class="area-header" title="Ship Meeting">
	<h2 class="area-header__heading">Caribbean Sea</h2>
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
		It has a <?=$game['event']['ship_meeting']['crew']?>
		crew members and <?=$game['event']['ship_meeting']['cannons']?>
		cannons. What do you wan't to do?</p>

	<?php elseif ($game['event']['ship_meeting']['nation'] == $game['enemy']): ?>
	<p>You meet a <?=$game['event']['ship_meeting']['type']?>
		from your enemy <?=ucfirst($game['event']['ship_meeting']['nation'])?>!
		It has <?=$game['event']['ship_meeting']['crew']?>
		crew members and <?=$game['event']['ship_meeting']['cannons']?>
		cannons. What do you wan't to do?</p>

	<?php elseif ($game['event']['ship_meeting']['nation'] == $game['nationality']): ?>
	<p>You meet a <?=$game['event']['ship_meeting']['type']?>
		from your allies <?=ucfirst($game['event']['ship_meeting']['nation'])?>!
		It has <?=$game['event']['ship_meeting']['crew']?>
		crew members and <?=$game['event']['ship_meeting']['cannons']?>
		cannons. What do you wan't to do?</p>

	<?php else: ?>
	<p>You meet a <?=$game['event']['ship_meeting']['type']?>
		from <?=ucfirst($game['event']['ship_meeting']['nation'])?>!
		It has <?=$game['event']['ship_meeting']['crew']?>
		crew members and <?=$game['event']['ship_meeting']['cannons']?>
		cannons. What do you wan't to do?</p>
	<?php endif; ?>
</div>