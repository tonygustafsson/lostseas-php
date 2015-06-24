<header title="Unregister">
	<h3>Unregister</h3>
</header>

<section class="actions">
	<a class="ajaxHTML" title="Change your account settings, such as name, birthday, presentation" href="<?=base_url('account/settings_account')?>"><img src="<?=base_url('assets/images/icons/settings_account.png')?>" alt="Account" width="32" height="32">Account</a>
	<a class="ajaxHTML" title="Change your email/login adress" href="<?=base_url('account/settings_email')?>"><img src="<?=base_url('assets/images/icons/settings_email.png')?>" alt="Email" width="32" height="32">Email</a>
	<a class="ajaxHTML" title="Change your character name, age and such" href="<?=base_url('account/settings_character')?>"><img src="<?=base_url('assets/images/icons/settings_character.png')?>" alt="Character" width="32" height="32">Character</a>
	<a class="ajaxHTML" title="Change your password for login" href="<?=base_url('account/settings_password')?>"><img src="<?=base_url('assets/images/icons/settings_password.png')?>" alt="Password" width="32" height="32">Password</a>
	<a class="ajaxHTML" title="Unregister from this game" href="<?=base_url('account/unregister')?>"><img src="<?=base_url('assets/images/icons/settings_unregister.png')?>" alt="Unregister" width="32" height="32">Unregister</a>
</section>

<p>
	Please write your password and click the Unregister button to delete your account and everything that is associated with it.
</p>

<form id="settings" class="ajaxJSON" method="post" action="<?=base_url('account/unregister_post')?>">

<fieldset>
	<div id="msg"></div>

	<legend>Unregister</legend>
	
	<label for="password">Password</label>
	<input type="password" name="password">
	
	<input type="submit" value="Unregister">	
</fieldset>

</form>