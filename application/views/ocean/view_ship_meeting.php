<?php if (! empty($this->data['game']['event_ship'])) {
    list($nation, $type, $crew, $cannons) = explode('###', $this->data['game']['event_ship']);
} ?>

<header title="Ship Meeting">
	<h2>Caribbean Sea</h2>
	<img src="<?php echo base_url()?>assets/images/places/ship_meeting_<?php echo $nation?>.jpg" class="header">
</header>

<?php if (isset($game['msg'])): ?>
	<div class="success"><p><?php echo $game['msg']?></p></div>
<?php endif; ?>

<?php if (! empty($this->data['game']['event_ship'])): ?>
	<?php if ($nation == 'pirate'): ?>
		<p>You meet a pirate <?php echo $type?>!
		It has a <?php echo $crew?> crew members and <?php echo $cannons?> cannons. What do you wan't to do?</p>

	<?php elseif ($nation == $game['enemy']): ?>
		<p>You meet a <?php echo $type?> from your enemy <?php echo ucfirst($nation)?>!
		It has <?php echo $crew?> crew members and <?php echo $cannons?> cannons. What do you wan't to do?</p>

	<?php elseif ($nation == $game['nationality']): ?>
		<p>You meet a <?php echo $type?> from your allies <?php echo ucfirst($nation)?>!
		It has <?php echo $crew?> crew members and <?php echo $cannons?> cannons. What do you wan't to do?</p>
		
	<?php else: ?>
		<p>You meet a <?php echo $type?> from <?php echo ucfirst($nation)?>!
		It has <?php echo $crew?> crew members and <?php echo $cannons?> cannons. What do you wan't to do?</p>
	<?php endif; ?>
<?php endif; ?>