<div class="container">
	<p>
		Type in your new password twice to reset your current one.
	</p>

	<form method="post" class="ajaxJSON"
		action="<?=base_url('account/password_reset_post')?>">
		<fieldset>
			<legend>Reset password</legend>

			<input type="hidden" name="verification"
				value="<?=$verification?>">

			<label for="new_password">New password</label>
			<input type="password" name="new_password">

			<label for="repeated_new_password">Verify password</label>
			<input type="password" name="repeated_new_password">

			<button type="submit">Change password</button>
		</fieldset>
	</form>
</div>