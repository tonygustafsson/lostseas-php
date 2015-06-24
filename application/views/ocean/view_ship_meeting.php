<? if (! empty($this->user['game']['event_ship'])) { list($nation, $type, $crew, $cannons) = explode('###', $this->user['game']['event_ship']); } ?>

<? if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?=$json?>);
	</script>
<? endif; ?>

<header title="Ship Meeting">
	<h2>Caribbean Sea</h2>
	<img src="<?echo base_url()?>assets/images/places/ship_meeting_<?=$nation?>.jpg" class="header">
</header>

<? if (isset($game['msg'])): ?>
	<div class="success"><p><?=$game['msg']?></p></div>
<? endif; ?>

<? if (! empty($this->user['game']['event_ship'])): ?>
	<? if ($nation == 'pirate'): ?>
		<p>You meet a pirate <?=$type?>!
		It has a <?=$crew?> crew members and <?=$cannons?> cannons. What do you wan't to do?</p>

	<? elseif ($nation == $game['enemy']): ?>
		<p>You meet a <?=$type?> from your enemy <?=ucfirst($nation)?>!
		It has <?=$crew?> crew members and <?=$cannons?> cannons. What do you wan't to do?</p>

	<? elseif ($nation == $game['nationality']): ?>
		<p>You meet a <?=$type?> from your allies <?=ucfirst($nation)?>!
		It has <?=$crew?> crew members and <?=$cannons?> cannons. What do you wan't to do?</p>
		
	<? else: ?>
		<p>You meet a <?=$type?> from <?=ucfirst($nation)?>!
		It has <?=$crew?> crew members and <?=$cannons?> cannons. What do you wan't to do?</p>
	<? endif; ?>
<? endif; ?>