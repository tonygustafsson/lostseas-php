<?php if (isset($json)): ?>
	<script type="text/javascript">
		$(document).ready(function () {
			gameManipulateDOM(<?php echo $json?>);
		});
	</script>
<?php endif; ?>

<header title="<?php echo $game['town_human'] . ' ' . $game['place']?>">
	<h2><?php echo $game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?php echo base_url('assets/images/places/governor_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Talk to the governor" href="<?php echo base_url('cityhall/governor')?>"><img src="<?php echo base_url('assets/images/icons/cityhall_governor.png')?>" alt="Governor" width="32" height="32">Governor</a>
	<?php if ($this->user['game']['event_work'] != 'banned'): ?>
		<a class="ajaxHTML" id="actions_work" title="Work to get some money" href="<?php echo base_url('cityhall/work')?>"><img src="<?php echo base_url('assets/images/icons/cityhall_work.png')?>" alt="Work" width="32" height="32">Work</a>
	<?php endif; ?>
	<?php if ($game['prisoners'] > 0 && $game['nation'] == $game['nationality']): ?>
		<a id="action_prisoners" class="ajaxJSON" title="Hand over your prisoner and get a ransom" href="<?php echo base_url('cityhall/prisoners')?>"><img src="<?php echo base_url('assets/images/icons/cityhall_prisoners.png')?>" alt="Prisoners" width="32" height="32">Prisoners</a>
	<?php endif; ?>
</section>

<div id="msg"></div>

<?php if (isset($game['event_change_citizenship']) && $game['event_change_citizenship'] === true): ?>
	<section id="offer">
		<section class="action-buttons">
				<a href="cityhall/citizenship_accept" class="ajaxJSON nopic positive" title="Become a citizen!">Yes</a>
				<a href="cityhall" class="nopic negative" title="Turn the governor down">No</a>
		</section>
	</section>
<?php endif; ?>