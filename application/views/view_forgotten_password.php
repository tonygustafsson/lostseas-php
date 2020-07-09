<header class="area-header" class="area-header" title="Forgotten password">
	<img class="area-header__img"
		src="<?=base_url('assets/images/design/game_start.jpg')?>">
	<h2 class="area-header__heading">Forgotten password</h2>

	<?php include(__DIR__ . '/partials/register_form.php'); ?>
</header>

<div class="container">
	<div class="button-area">
		<a class="ajaxHTML button big-icon" title="Presentation about the game"
			href="<?=base_url('about/presentation')?>">
			<svg width="32" height="32" class="Start">
				<use xlink:href="#swords"></use>
			</svg>
			Start
		</a>
		<a class="ajaxHTML button big-icon" title="A complete guide for this game"
			href="<?=base_url('about/guide_supplies')?>">
			<svg width="32" height="32" class="Guide">
				<use xlink:href="#logbook"></use>
			</svg>
			Guide
		</a>
	</div>

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

			<br />
			<button type="submit">Reset password</button>
		</fieldset>
	</form>
</div>

<div id="js-start-avatar-selector-dialog" class="dialog" tabindex="-1" role="dialog"
	data-base-url="<?=base_url('account/avatar_selector/')?>"
	data-img-base-url="<?=base_url('assets/images/avatars')?>">
	<h3 class="dialog-title">Choose an avatar</h3>
	<div class="avatar-selector-wrapper"></div>
</div>