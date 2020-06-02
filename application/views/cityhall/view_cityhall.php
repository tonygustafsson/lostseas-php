<header title="<?php echo $game['town_human'] . ' ' . $game['place']?>">
	<h2><?php echo $game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?php echo base_url('assets/images/places/cityhall_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Talk to the governor" href="<?php echo base_url('cityhall/governor')?>"><img src="<?php echo base_url('assets/images/icons/cityhall_governor.png')?>" alt="Governor" width="32" height="32">Governor</a>
	<?php if ($this->data['game']['event_work'] != 'banned'): ?>
		<a class="ajaxHTML" id="actions_work" title="Work to get some money" href="<?php echo base_url('cityhall/work')?>"><img src="<?php echo base_url('assets/images/icons/cityhall_work.png')?>" alt="Work" width="32" height="32">Work</a>
	<?php endif; ?>
	<?php if ($game['prisoners'] > 0 && $game['nation'] == $game['nationality']): ?>
		<a id="action_prisoners" class="ajaxJSON" title="Hand over your prisoner and get a ransom" href="<?php echo base_url('cityhall/prisoners')?>"><img src="<?php echo base_url('assets/images/icons/cityhall_prisoners.png')?>" alt="Prisoners" width="32" height="32">Prisoners</a>
	<?php endif; ?>
</section>

<p>
	<?php echo $game['greeting']?>
</p>