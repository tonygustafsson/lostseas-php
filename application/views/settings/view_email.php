<div class="container">
	<h3>Change email</h3>

	<div class="button-area">
		<a class="ajaxHTML button big-icon" title="Change your account settings, such as name, birthday, presentation"
			href="<?=base_url('settings/account')?>">
			<svg width="32" height="32" class="Account">
				<use xlink:href="#player"></use>
			</svg>
			Account
		</a>
		<a class="ajaxHTML button big-icon" title="Change your email/login adress"
			href="<?=base_url('settings/email')?>">
			<svg width="32" height="32" class="Email">
				<use xlink:href="#message"></use>
			</svg>
			Email
		</a>
		<a class="ajaxHTML button big-icon" title="Change your character name, age and such"
			href="<?=base_url('settings/character')?>">
			<svg width="32" height="32" class="Character">
				<use xlink:href="#crew-man"></use>
			</svg>
			Character
		</a>
		<a class="ajaxHTML button big-icon" title="Change your password for login"
			href="<?=base_url('settings/password')?>">
			<svg width="32" height="32" class="Password">
				<use xlink:href="#key"></use>
			</svg>
			Password
		</a>
	</div>

	<p>
		If you changes your email adress, your new mail box will recieve a verification link.
		If you click that link, your email will be changed. You have to login with your new
		adress to continue playing <?=$this->config->item('site_name')?>!
	</p>

	<form id="settings" class="ajaxJSON" method="post"
		action="<?=base_url('settings/send_email_verification')?>">

		<fieldset>
			<legend>Change email</legend>

			<label for="new_email">New email address</label>
			<input type="email" name="new_email" id="new_email"
				value="<?=$user['email']?>" />

			<button type="submit" class="primary">Save</button>
		</fieldset>

	</form>
</div>