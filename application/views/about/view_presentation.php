<header title="Presentation">
	<img class="header"
		src="<?=base_url('assets/images/design/game_start.jpg')?>"
		alt="Front image">
	<h2>Welcome!</h2>

	<?php include(__DIR__ . '/../partials/register_form.php'); ?>
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

<h3>Presentation</h3>

<p>
	This is a pirate-influenced, web based game in beta stage. No registration is neccessary - just press Play!
</p>

<p>
	You will travel from town to town, and encounter many ships on the Caribbean Sea. Some are friendly, and some
	will attack you at sight. The main goal of the game is to get higher ranks. From a simple pirate, to ensign, to
	duke.
</p>

<p>
	There are 16 different towns to visit with a lot of different places in them to explore. You will have a crew
	and one or more ships. Every crew member has a name, an age, a health and a mood. You have to please your crew,
	or they will leave you.
</p>

<p>
	Please read the <a
		href="<?=base_url('about/guide_supplies')?>">guide</a>
	if you want to know more before you start playing!
</p>

<div id="js-start-avatar-selector-dialog" class="dialog" tabindex="-1" role="dialog"
	data-url="<?=base_url('account/avatar_selector/')?>/<?=$character['character_gender_long']?>">
	<h3 class="dialog-title">Choose an avatar</h3>
	<div class="avatar-selector-wrapper"></div>
</div>