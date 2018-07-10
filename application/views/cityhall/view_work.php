<header title="<?php echo $game['town_human'] . ' ' . $game['place']?>">
	<h2><?php echo $game['town_human'] . ' ' . $game['place']?></h2>
	<img src="<?php echo base_url('assets/images/places/work_' . $game['nation'] . '.jpg')?>" class="header">
</header>

<section class="actions">
	<a class="ajaxHTML" title="Talk to the governor" href="<?php echo base_url('cityhall/governor')?>"><img src="<?php echo base_url('assets/images/icons/cityhall_governor.png')?>" alt="Governor" width="32" height="32">Governor</a>
	<? if ($this->user['game']['event_work'] != 'banned'): ?>
		<a class="ajaxHTML" id="actions_work" title="Work to get some money" href="<?php echo base_url('cityhall/work')?>"><img src="<?php echo base_url('assets/images/icons/cityhall_work.png')?>" alt="Work" width="32" height="32">Work</a>
	<? endif; ?>
	<? if ($game['prisoners'] > 0 && $game['nation'] == $game['nationality']): ?>
		<a id="action_prisoners" class="ajaxJSON" title="Hand over your prisoner and get a ransom" href="<?php echo base_url('cityhall/prisoners')?>"><img src="<?php echo base_url('assets/images/icons/cityhall_prisoners.png')?>" alt="Prisoners" width="32" height="32">Prisoners</a>
	<? endif; ?>
</section>

<p>
	You can only work once per town visit. The crew mood will be lowered by 1! The salary depends on the
	occupation (chance), the number of crew members and their health.
</p>

<div id="msg"></div>

<? if (! empty($this->user['game']['event_work']) && $this->user['game']['event_work'] != 'banned'): ?>
	<section id="offer" class="actions">
		<p>You and your crew gets a job offer as <?php echo $occupation?> for <strong><?php echo $salary?> dbl</strong>. Take the offer?</p>
	
		<a class="ajaxJSON nopic positive" href="cityhall/work_accept" title="Get to work!">Yes</a>
		<a class="ajaxHTML nopic negative" href="cityhall" title="I'm too lazy to work">No</a>
	</section>

<? endif; ?>