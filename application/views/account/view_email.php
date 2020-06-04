<header title="Change email">
	<h3>Change email</h3>
</header>

<section class="action-buttons">
	<a class="ajaxHTML" title="Change your account settings, such as name, birthday, presentation" href="<?=base_url('account/settings_account')?>"><img src="<?=base_url('assets/images/icons/settings_account.png')?>" alt="Account" width="32" height="32">Account</a>
	<a class="ajaxHTML" title="Change your email/login adress" href="<?=base_url('account/settings_email')?>"><img src="<?=base_url('assets/images/icons/settings_email.png')?>" alt="Email" width="32" height="32">Email</a>
	<a class="ajaxHTML" title="Change your character name, age and such" href="<?=base_url('account/settings_character')?>"><img src="<?=base_url('assets/images/icons/settings_character.png')?>" alt="Character" width="32" height="32">Character</a>
	<a class="ajaxHTML" title="Change your password for login" href="<?=base_url('account/settings_password')?>"><img src="<?=base_url('assets/images/icons/settings_password.png')?>" alt="Password" width="32" height="32">Password</a>
	<a class="ajaxHTML" title="Unregister from this game" href="<?=base_url('account/unregister')?>"><img src="<?=base_url('assets/images/icons/settings_unregister.png')?>" alt="Unregister" width="32" height="32">Unregister</a>
</section>

<p>
If you changes your email adress, your new mail box will recieve a verification link.
If you click that link, your email will be changed. You have to login with your new
adress to continue playing <?=$this->config->item('site_name')?>!
</p>

<form id="settings" class="ajaxJSON" method="post" action="<?=base_url('account/send_email_verification')?>">

<fieldset>
	<legend>Change email</legend>
	
	<label for="new_email">New email address</label>
	<input type="email" name="new_email" value="<?=$user['email']?>">

	<input type="submit" value="Save">	
</fieldset>

</form>
