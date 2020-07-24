<div class="container">
	<h2>Forgotten password</h2>

	<p>
		Type your email address in the field below to recieve a reset link. Once you click on that link, you will
		get the change to retype your password.
	</p>

	<form id="forgotten_password_form" class="ajaxJSON" style="margin: 1em;" method="post"
		action="<?=base_url('account/password_forgotten_post')?>">
		<fieldset>
			<legend>Reset password</legend>

			<label for="email">Email address</label>
			<input id="email" type="email" name="email" />
			<input id="name" type="text" name="name" />

			<br />
			<button type="submit">Reset password</button>
		</fieldset>
	</form>
</div>