<header title="Change email">
	<h3>Change email</h3>
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Change your account settings, such as name, birthday, presentation" href="<?php echo base_url('account/settings_account')?>"><img src="<?php echo base_url('assets/images/icons/settings_account.png')?>" alt="Account" width="32" height="32">Account</a>
	<a class="ajaxHTML" title="Change your email/login adress" href="<?php echo base_url('account/settings_email')?>"><img src="<?php echo base_url('assets/images/icons/settings_email.png')?>" alt="Email" width="32" height="32">Email</a>
	<a class="ajaxHTML" title="Change your character name, age and such" href="<?php echo base_url('account/settings_character')?>"><img src="<?php echo base_url('assets/images/icons/settings_character.png')?>" alt="Character" width="32" height="32">Character</a>
	<a class="ajaxHTML" title="Change your password for login" href="<?php echo base_url('account/settings_password')?>"><img src="<?php echo base_url('assets/images/icons/settings_password.png')?>" alt="Password" width="32" height="32">Password</a>
	<a class="ajaxHTML" title="Unregister from this game" href="<?php echo base_url('account/unregister')?>"><img src="<?php echo base_url('assets/images/icons/settings_unregister.png')?>" alt="Unregister" width="32" height="32">Unregister</a>
</section>

<form id="settings" class="ajaxJSON" method="post" action="<?php echo base_url('account/settings_password_post')?>">

<fieldset>
	<div id="msg"></div>
	
	<legend>Change password</legend>
	
	<label for="old_password">Current password</label>
	<input type="password" name="old_password">
	
	<label for="new_password">New password</label>
	<input type="password" name="new_password">
	
	<label for="repeated_new_password">Repeat new password</label>
	<input type="password" name="repeated_new_password">

	<br><input type="submit" value="Save">
</fieldset>

</form>
