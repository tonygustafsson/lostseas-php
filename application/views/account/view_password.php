<header class="area-header" class="area-header" title="Change email">
	<h3>Change email</h3>
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Change your account settings, such as name, birthday, presentation"
		href="<?=base_url('account/settings_account')?>">
		<svg width="32" height="32" class="Account">
			<use xlink:href="#player"></use>
		</svg>
		Account
	</a>
	<a class="ajaxHTML" title="Change your email/login adress"
		href="<?=base_url('account/settings_email')?>">
		<svg width="32" height="32" class="Email">
			<use xlink:href="#message"></use>
		</svg>
		Email
	</a>
	<a class="ajaxHTML" title="Change your character name, age and such"
		href="<?=base_url('account/settings_character')?>">
		<svg width="32" height="32" class="Character">
			<use xlink:href="#crew-man"></use>
		</svg>
		Character
	</a>
	<a class="ajaxHTML" title="Change your password for login"
		href="<?=base_url('account/settings_password')?>">
		<svg width="32" height="32" class="Password">
			<use xlink:href="#key"></use>
		</svg>
		Password
	</a>
	<a class="ajaxHTML" title="Unregister from this game"
		href="<?=base_url('account/unregister')?>">
		<svg width="32" height="32" class="Unregister">
			<use xlink:href="#trashcan"></use>
		</svg>
		Unregister
	</a>
</section>

<form id="settings" class="ajaxJSON" method="post"
	action="<?=base_url('account/settings_password_post')?>">

	<fieldset>
		<legend>Change password</legend>

		<label for="old_password">Current password</label>
		<input type="password" name="old_password" id="old_password" />

		<label for="new_password">New password</label>
		<input type="password" name="new_password" id="new_password" />

		<label for="repeated_new_password">Repeat new password</label>
		<input type="password" name="repeated_new_password" id="repeated_new_password" />

		<br><input type="submit" value="Save">
	</fieldset>

</form>