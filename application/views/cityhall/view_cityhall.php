<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/cityhall_' . $game['nation'] . '.jpg')?>"
		class="area-header__img">
</header>

<div class="button-area">
	<a class="ajaxHTML button big-icon" title="Talk to the governor"
		href="<?=base_url('cityhall/governor')?>">
		<svg width="32" height="32" alt="Governor">
			<use xlink:href="#governor"></use>
		</svg>
		Governor
	</a>
	<?php if ($this->data['game']['event_work'] != 'banned'): ?>
	<a class="ajaxHTML button big-icon" id="actions_work" title="Work to get some money"
		href="<?=base_url('cityhall/work')?>">
		<svg width="32" height="32" alt="Work">
			<use xlink:href="#pickaxe"></use>
		</svg>
		Work
	</a>
	<?php endif; ?>
	<?php if ($game['prisoners'] > 0 && $game['nation'] == $game['nationality']): ?>
	<a id="action_prisoners" class="ajaxJSON button big-icon" title="Hand over your prisoner and get a ransom"
		href="<?=base_url('cityhall/prisoners')?>">
		<svg width="32" height="32" alt="Prisoners">
			<use xlink:href="#prisoners"></use>
		</svg>
		Prisoners
	</a>
	<?php endif; ?>
</div>

<p>
	<?=$game['greeting']?>
</p>