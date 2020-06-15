<?php if (! empty($this->data['game']['event_ship'])) {
    list($nation, $type, $crew, $cannons) = explode('###', $this->data['game']['event_ship']);
} ?>

<header class="area-header" class="area-header" title="Ship Meeting">
	<h2 class="area-header__heading">Caribbean Sea</h2>
	<img src="<?=base_url('assets/images/places/ship_meeting_' . $nation . '.png')?>"
		class="area-header__img">
</header>

<div class="container">
	<?php if (isset($game['msg'])): ?>
	<div class="success">
		<p><?=$game['msg']?>
		</p>
	</div>
	<?php endif; ?>

	<?php if (! empty($this->data['game']['event_ship'])): ?>
	<?php if ($nation == 'pirate'): ?>
	<p>You meet a pirate <?=$type?>!
		It has a <?=$crew?> crew members and <?=$cannons?> cannons. What do you wan't to do?</p>

	<?php elseif ($nation == $game['enemy']): ?>
	<p>You meet a <?=$type?> from your enemy <?=ucfirst($nation)?>!
		It has <?=$crew?> crew members and <?=$cannons?> cannons. What do you wan't to do?</p>

	<?php elseif ($nation == $game['nationality']): ?>
	<p>You meet a <?=$type?> from your allies <?=ucfirst($nation)?>!
		It has <?=$crew?> crew members and <?=$cannons?> cannons. What do you wan't to do?</p>

	<?php else: ?>
	<p>You meet a <?=$type?> from <?=ucfirst($nation)?>!
		It has <?=$crew?> crew members and <?=$cannons?> cannons. What do you wan't to do?</p>
	<?php endif; ?>
	<?php endif; ?>
</div>