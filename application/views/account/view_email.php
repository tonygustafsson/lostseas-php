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

<p>
	If you changes your email adress, your new mail box will recieve a verification link.
	If you click that link, your email will be changed. You have to login with your new
	adress to continue playing <?=$this->config->item('site_name')?>!
</p>

<form id="settings" class="ajaxJSON" method="post"
	action="<?=base_url('account/send_email_verification')?>">

	<fieldset>
		<legend>Change email</legend>

		<label for="new_email">New email address</label>
		<input type="email" name="new_email" id="new_email"
			value="<?=$user['email']?>" />

		<input type="submit" value="Save">
	</fieldset>

</form>