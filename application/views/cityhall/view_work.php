<header
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/work_' . $game['nation'] . '.jpg')?>"
		class="header">
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Talk to the governor"
		href="<?=base_url('cityhall/governor')?>">
		<svg width="32" height="32" alt="Governor">
			<use xlink:href="#governor"></use>
		</svg>
		Governor
	</a>
	<?php if ($this->data['game']['event_work'] != 'banned'): ?>
	<a class="ajaxHTML" id="actions_work" title="Work to get some money"
		href="<?=base_url('cityhall/work')?>">
		<svg width="32" height="32" alt="Work">
			<use xlink:href="#pickaxe"></use>
		</svg>
		Work
	</a>
	<?php endif; ?>
	<?php if ($game['prisoners'] > 0 && $game['nation'] == $game['nationality']): ?>
	<a id="action_prisoners" class="ajaxJSON" title="Hand over your prisoner and get a ransom"
		href="<?=base_url('cityhall/prisoners')?>">
		<svg width="32" height="32" alt="Prisoners">
			<use xlink:href="#prisoners"></use>
		</svg>
		Prisoners
	</a>
	<?php endif; ?>
</section>

<p>
	You can only work once per town visit. The crew mood will be lowered by 1! The salary depends on the
	occupation (chance), the number of crew members and their health.
</p>

<?php if (! empty($this->data['game']['event_work']) && $this->data['game']['event_work'] != 'banned'): ?>
<section id="offer" class="action-buttons">
	<p>You and your crew gets a job offer as <?=$occupation?> for
		<strong><?=$salary?> dbl</strong>. Take the offer?</p>

	<a class="ajaxJSON nopic positive" href="cityhall/work_accept" title="Get to work!">Yes</a>
	<a class="ajaxHTML nopic negative" href="cityhall" title="I'm too lazy to work">No</a>
</section>

<?php endif;
