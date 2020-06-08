<header title="Forgotten password">
	<img class="header"
		src="<?=base_url('assets/images/design/game_start.jpg')?>">
	<h2>Forgotten password</h2>

	<?php include(__DIR__ . '/../partials/register_form.php'); ?>
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Presentation about the game"
		href="<?=base_url('about/presentation')?>"><img
			src="<?=base_url('assets/images/icons/presentation.png')?>"
			alt="Start" width="32" height="32">Start</a>
	<a class="ajaxHTML" title="A complete guide for this game"
		href="<?=base_url('about/guide_supplies')?>"><img
			src="<?=base_url('assets/images/icons/guide.png')?>"
			alt="Guide" width="32" height="32">Guide</a>
	<a class="ajaxHTML" title="What's new in here?"
		href="<?=base_url('about/news')?>"><img
			src="<?=base_url('assets/images/icons/about_news.png')?>"
			alt="News" width="32" height="32">News</a>
</section>

<p>
	Type your email address in the field below to recieve a reset link. Once you click on that link, you will
	get the change to retype your password.
</p>

<form class="ajaxJSON" style="margin: 1em;" method="post"
	action="<?=base_url('account/password_send_reset_link')?>">
	<fieldset>
		<legend>Reset password</legend>

		<label for="email">Email address</label>
		<input id="name" type="text" name="name">
		<input id="email" type="email" name="email">

		<br><input type="submit" value="Reset password">
	</fieldset>
</form>

<div id="js-start-avatar-selector-dialog" class="dialog" tabindex="-1" role="dialog"
	data-url="<?=base_url('account/avatar_selector/')?>/<?=$character['character_gender_long']?>">
	<h3 class="dialog-title">Choose an avatar</h3>
	<div class="avatar-selector-wrapper"></div>
</div>