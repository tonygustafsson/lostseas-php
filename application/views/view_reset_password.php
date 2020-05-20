<p>
	Type in your new password twice to reset your current one.
</p>

<div id="msg"></div>

<form method="post" class="ajaxJSON" action="<?php echo base_url('account/password_change')?>">
	<fieldset>
		<legend>Reset password</legend>
	
		<input type="hidden" name="verification" value="<?php echo $verification?>">
	
		<label for="new_password">New password</label>
		<input type="password" name="new_password">
	
		<label for="repeated_new_password">Verify password</label>
		<input type="password" name="repeated_new_password">
	
		<input type="submit" value="Change password">
	</fieldset>
</form>