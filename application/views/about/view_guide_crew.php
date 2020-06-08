<header title="Guide: Crew">
	<?php if (! $logged_in): ?>
	<img class="header"
		src="<?=base_url('assets/images/design/game_start.jpg')?>"
		alt="Front image">
	<h2>Guide: Crew</h2>

	<?php include(__DIR__ . '/../partials/register_form.php'); ?>
	<?php else: ?>
	<h3>Guide: Crew</h3>
	<?php endif; ?>
</header>

<section class="action-buttons">
	<?php if (!$logged_in): ?>
	<a class="ajaxHTML" title="Presentation about the game"
		href="<?=base_url('about/presentation')?>">
		<svg width="32" height="32" class="Start">
			<use xlink:href="#swords"></use>
		</svg>
		Start
	</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="A complete guide for this game"
		href="<?=base_url('about/guide_supplies')?>">
		<svg width="32" height="32" class="Guide">
			<use xlink:href="#logbook"></use>
		</svg>
		Guide
	</a>
	<a class="ajaxHTML" title="What's new in here?"
		href="<?=base_url('about/news')?>">
		<svg width="32" height="32" class="News">
			<use xlink:href="#magazine"></use>
		</svg>
		News
	</a>
</section>

<div class="divider"></div>

<section class="action-buttons">
	<a class="ajaxHTML" title="About food, water, and other stuff"
		href="<?=base_url('about/guide_supplies')?>">
		<svg width="32" height="32" alt="Food">
			<use xlink:href="#barrels"></use>
		</svg>
		Supplies
	</a>
	<a class="ajaxHTML" title="About ships and gun power"
		href="<?=base_url('about/guide_ships')?>">
		<svg width="32" height="32" alt="Ships">
			<use xlink:href="#ship"></use>
		</svg>
		Ships
	</a>
	<a class="ajaxHTML" title="About crew and how to please them"
		href="<?=base_url('about/guide_crew')?>">
		<svg width="32" height="32" alt="Crew">
			<use xlink:href="#crew-man"></use>
		</svg>
		Crew
	</a>
	<a class="ajaxHTML" title="About titles, levels and ranks"
		href="<?=base_url('about/guide_titles')?>">
		<svg width="32" height="32" alt="Titles">
			<use xlink:href="#governor"></use>
		</svg>
		Titles
	</a>
	<a class="ajaxHTML" title="About money and banking"
		href="<?=base_url('about/guide_economy')?>">
		<svg width="32" height="32" alt="Economy">
			<use xlink:href="#doubloons"></use>
		</svg>
		Economy
	</a>
	<a class="ajaxHTML" title="About travling and sea battles"
		href="<?=base_url('about/guide_traveling')?>">
		<svg width="32" height="32" alt="Traveling">
			<use xlink:href="#compass"></use>
		</svg>
		Traveling
	</a>
	<a class="ajaxHTML" title="About other players and how to interact with them"
		href="<?=base_url('about/guide_players')?>">
		<svg width="32" height="32" alt="Players">
			<use xlink:href="#player"></use>
		</svg>
		Players
	</a>
	<a class="ajaxHTML" title="About settings and anonymity"
		href="<?=base_url('about/guide_settings')?>">
		<svg width="32" height="32" alt="Settings">
			<use xlink:href="#cogs"></use>
		</svg>
		Settings
	</a>
</section>

<div class="divider"></div>

<h3>Purpose of crew members</h3>

<p>The only real reason to have crew members is so that they can fight battles with you. To fire a cannon, you'll need
	two
	crew members.</p>

<p>They demands things in return for their services. They become less happy when they do boring stuff, like working,
	losing battles and
	traveling the great Caribbean Sea. When they are angry they will refuse to work / fight for you.</p>

<p>In order to fix this you have to please them, with food and drinks. You can visit the tavern and buy them some wine
	perhaps, or
	give them rum from your goods if you have any.</p>

<p>You are also responsible for their health. If they lose to much health they will die in battle. You can give them
	medicine after battles,
	or visit the towns healer when you are in land again.</p>

<h3>Getting more crew members</h3>

<p>When you win battles at sea some of their crew will offer to join you. You can then choose how many of them you want
	to accept.
	The other method is to visit the tavern and speak to the sailors there, they often want to offer their services for
	free.
	You could also visit the slave market, but it's expansive!</p>

<h3>Get to know them</h3>

<p>If you check your inventory you will get unnecessary amounts of information about your crew. All of them are separate
	beings, with their own
	name and description. You can also see for how long they have been with you, how much money they have gained of
	being your crew.</p>

<p style="text-align: center;">
	<img src="<?=base_url('assets/images/design/about_crew.jpg')?>"
		alt="Crew" style="margin-top: 10px; margin-bottom: 10px; border: 3px solid rgb(163, 162, 126);">
</p>

<div id="js-start-avatar-selector-dialog" class="dialog" tabindex="-1" role="dialog"
	data-url="<?=base_url('account/avatar_selector/')?>/<?=$character['character_gender_long']?>">
	<h3 class="dialog-title">Choose an avatar</h3>
	<div class="avatar-selector-wrapper"></div>
</div>