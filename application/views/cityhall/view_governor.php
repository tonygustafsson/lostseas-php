<header
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/governor_' . $game['nation'] . '.jpg')?>"
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

<?php if (isset($game['event_change_citizenship']) && $game['event_change_citizenship'] === true): ?>
<section id="offer">
	<section class="action-buttons">
		<a href="cityhall/citizenship_accept" class="ajaxJSON nopic positive" title="Become a citizen!">Yes</a>
		<a href="cityhall" class="nopic negative" title="Turn the governor down">No</a>
	</section>
</section>
<?php endif;
