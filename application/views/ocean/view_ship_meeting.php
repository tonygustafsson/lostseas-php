<? if (! empty($this->user['game']['event_ship'])) { list($nation, $type, $crew, $cannons) = explode('###', $this->user['game']['event_ship']); } ?>

<? if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?php echo $json?>);
	</script>
<? endif; ?>

<header title="Ship Meeting">
	<h2>Caribbean Sea</h2>
	<img src="<?echo base_url()?>assets/images/places/ship_meeting_<?php echo $nation?>.jpg" class="header">
</header>

<? if (isset($game['msg'])): ?>
	<div class="success"><p><?php echo $game['msg']?></p></div>
<? endif; ?>

<? if (! empty($this->user['game']['event_ship'])): ?>
	<? if ($nation == 'pirate'): ?>
		<p>You meet a pirate <?php echo $type?>!
		It has a <?php echo $crew?> crew members and <?php echo $cannons?> cannons. What do you wan't to do?</p>

	<? elseif ($nation == $game['enemy']): ?>
		<p>You meet a <?php echo $type?> from your enemy <?php echo ucfirst($nation)?>!
		It has <?php echo $crew?> crew members and <?php echo $cannons?> cannons. What do you wan't to do?</p>

	<? elseif ($nation == $game['nationality']): ?>
		<p>You meet a <?php echo $type?> from your allies <?php echo ucfirst($nation)?>!
		It has <?php echo $crew?> crew members and <?php echo $cannons?> cannons. What do you wan't to do?</p>
		
	<? else: ?>
		<p>You meet a <?php echo $type?> from <?php echo ucfirst($nation)?>!
		It has <?php echo $crew?> crew members and <?php echo $cannons?> cannons. What do you wan't to do?</p>
	<? endif; ?>
<? endif; ?>