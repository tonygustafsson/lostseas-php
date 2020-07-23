<header class="area-header" class="area-header" title="Presentation">
	<img class="area-header__img"
		src="<?=base_url('assets/images/design/game_start.jpg')?>"
		alt="Front image">
	<h2 class="area-header__heading">Welcome!</h2>

	<?php include(__DIR__ . '/../partials/register_form.php'); ?>
</header>

<div class="container">
	<div class="button-area">
		<?php if (!$logged_in): ?>
		<a class="ajaxHTML button big-icon" title="Presentation about the game"
			href="<?=base_url('about/presentation')?>">
			<svg width="32" height="32" class="Start">
				<use xlink:href="#icon-swords"></use>
			</svg>
			Start
		</a>
		<?php endif; ?>
		<a class="ajaxHTML button big-icon" title="A complete guide for this game"
			href="<?=base_url('about')?>">
			<svg width="32" height="32" class="Guide">
				<use xlink:href="#icon-logbook"></use>
			</svg>
			Guide
		</a>
	</div>

	<h3>About Lost Seas</h3>

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
		Please read the <a class="ajaxHTML"
			href="<?=base_url('about')?>">guide</a>
		if you want to know more before you start playing!
	</p>

	<h4>Browser support</h4>

	<p>
		To play this game you'll need a modern browser. Meaning an updated version of Chrome, Firefox, Safari or Edge.
		It works on mobile phones using Safari or Chrome. If you are using Internet Explorer or Edge before version 80
		you are out of luck. Feel free to try though.
	</p>

	<div id="js-start-avatar-selector-dialog" class="dialog" tabindex="-1" role="dialog"
		data-base-url="<?=base_url('settings/avatar_selector/')?>"
		data-img-base-url="<?=base_url('assets/images/avatars')?>">
		<h3 class="dialog-title">Choose an avatar</h3>
		<div class="avatar-selector-wrapper"></div>
	</div>
</div>