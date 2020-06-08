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
	<?php if (! $logged_in): ?>
	<a class="ajaxHTML" title="Presentation about the game"
		href="<?=base_url('about/presentation')?>"><img
			src="<?=base_url('assets/images/icons/presentation.png')?>"
			alt="Start" width="32" height="32">Start</a>
	<?php endif; ?>
	<a class="ajaxHTML" title="A complete guide for this game"
		href="<?=base_url('about/guide_supplies')?>"><img
			src="<?=base_url('assets/images/icons/guide.png')?>"
			alt="Guide" width="32" height="32">Guide</a>
	<a class="ajaxHTML" title="What's new in here?"
		href="<?=base_url('about/news')?>"><img
			src="<?=base_url('assets/images/icons/about_news.png')?>"
			alt="News" width="32" height="32">News</a>
</section>

<div class="divider"></div>

<section class="action-buttons">
	<a class="ajaxHTML" title="About food, water, and other stuff"
		href="<?=base_url('about/guide_supplies')?>"><img
			src="<?=base_url('assets/images/icons/food.png')?>"
			alt="Supplies" width="32" height="32">Supplies</a>
	<a class="ajaxHTML" title="About ships and gun power"
		href="<?=base_url('about/guide_ships')?>"><img
			src="<?=base_url('assets/images/icons/coast.png')?>"
			alt="Ships" width="32" height="32">Ships</a>
	<a class="ajaxHTML" title="About crew and how to please them"
		href="<?=base_url('about/guide_crew')?>"><img
			src="<?=base_url('assets/images/icons/tavern_sailor.png')?>"
			alt="Crew" width="32" height="32">Crew</a>
	<a class="ajaxHTML" title="About titles, levels and ranks"
		href="<?=base_url('about/guide_titles')?>"><img
			src="<?=base_url('assets/images/icons/cityhall_governor.png')?>"
			alt="Titles" width="32" height="32">Titles</a>
	<a class="ajaxHTML" title="About money and banking"
		href="<?=base_url('about/guide_economy')?>"><img
			src="<?=base_url('assets/images/icons/bank.png')?>"
			alt="Economy" width="32" height="32">Economy</a>
	<a class="ajaxHTML" title="About travling and sea battles"
		href="<?=base_url('about/guide_traveling')?>"><img
			src="<?=base_url('assets/images/icons/travel.png')?>"
			alt="Travling" width="32" height="32">Traveling</a>
	<a class="ajaxHTML" title="About other players and how to interact with them"
		href="<?=base_url('about/guide_players')?>"><img
			src="<?=base_url('assets/images/icons/players.png')?>"
			alt="Players" width="32" height="32">Players</a>
	<a class="ajaxHTML" title="About settings and anonymity"
		href="<?=base_url('about/guide_settings')?>"><img
			src="<?=base_url('assets/images/icons/settings_character.png')?>"
			alt="Settings" width="32" height="32">Settings</a>
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