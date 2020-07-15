<header class="area-header"
	title="<?=$game['town_human'] . ' ' . $game['place']?>">
	<h2 class="area-header__heading"><?=$game['town_human'] . ' ' . $game['place']?>
	</h2>
	<img src="<?=base_url('assets/images/places/work_' . $game['nation'] . '.png')?>"
		class="area-header__img">
</header>

<div class="container">
	<div class="button-area">
		<a class="ajaxHTML button big-icon" title="Talk to the governor"
			href="<?=base_url('cityhall/governor')?>">
			<svg width="32" height="32" alt="Governor">
				<use xlink:href="#icon-governor"></use>
			</svg>
			Governor
		</a>
		<?php if (!isset($game['event']['cityhall_work']['banned'])): ?>
		<a class="ajaxHTML button big-icon" id="actions_work" title="Work to get some money"
			href="<?=base_url('cityhall/work')?>">
			<svg width="32" height="32" alt="Work">
				<use xlink:href="#icon-pickaxe"></use>
			</svg>
			Work
		</a>
		<?php endif; ?>
		<?php if ($game['prisoners'] > 0 && $game['nation'] == $game['nationality']): ?>
		<a id="action_prisoners" class="ajaxJSON button big-icon" title="Hand over your prisoner and get a ransom"
			href="<?=base_url('cityhall/prisoners')?>">
			<svg width="32" height="32" alt="Prisoners">
				<use xlink:href="#icon-prisoners"></use>
			</svg>
			Prisoners
		</a>
		<?php endif; ?>
	</div>

	<p>
		You can only work once per town visit. The crew mood will be lowered by 1! The salary depends on the
		occupation (chance), the number of crew members and their health.
	</p>

	<?php if (!isset($game['event']['cityhall_work']['banned'])): ?>
	<p>
		You and your crew gets a job offer as <?=$viewdata['occupation']?> for
		<strong><?=$viewdata['salary']?>
			dbl</strong>. Take the offer?
	</p>

	<div class="button-area">
		<a class="ajaxJSON button big primary"
			href="<?=base_url('cityhall/work_accept')?>"
			title="Get to work!">Yes</a>
		<a class="ajaxHTML button big"
			href="<?=base_url('cityhall')?>"
			title="I'm too lazy to work">No</a>
	</div>

	<?php endif; ?>
</div>