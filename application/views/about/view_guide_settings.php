<header title="Guide: Settings">
	<?php if (! $logged_in): ?>
	<img class="header"
		src="<?=base_url('assets/images/design/game_start.jpg')?>"
		alt="Front image">
	<h2>Guide: Settings</h2>

	<?php include(__DIR__ . '/../partials/register_form.php'); ?>

	<?php else: ?>
	<h3>Guide: Settings</h3>
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

<h3>Change user settings</h3>

<p>You can change your name, gender, birthday and presentation as you wish by clicking Settings at the top menu.</p>

<p>You can also chose what other players will be able to see about you.</p>

<h3>Changing your password</h3>

<p>You can change your password with Settings > Password, and it will change directly. If you forgot your password
	though,
	you can reset it by trying to login, click "Forgot my password". You can there type in your email address you
	registered with, and
	you will receive an email with a reset verification. Click it and choose your new password.</p>

<p style="text-align: center;">
	<img src="<?=base_url()?>assets/images/design/about_password.jpg"
		alt="Password" style="margin-top: 10px; margin-bottom: 10px; border: 3px solid rgb(163, 162, 126);">
</p>

<p>Your password will <strong>always</strong> be encrypted, and no one (including admins) can see your password.</p>

<h3>Changing your email address</h3>

<p>It's possible to change your login / email address too. Click Settings > Email, and type in your new email address.
	You will receive a
	verification link to your new email address, and if you click it, the address will change. You will then have to
	relogin with your new user ID.</p>

<h3>Unregister</h3>

<p>Yes, yes, you can unregister. And no, nothing will be saved (chat entries will not be erased),
	and you will not be contacted again. Promise!</p>

<div id="js-start-avatar-selector-dialog" class="dialog" tabindex="-1" role="dialog"
	data-url="<?=base_url('account/avatar_selector/')?>/<?=$character['character_gender_long']?>">
	<h3 class="dialog-title">Choose an avatar</h3>
	<div class="avatar-selector-wrapper"></div>
</div>