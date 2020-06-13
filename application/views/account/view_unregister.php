<div class="container">
	<h3>Unregister</h3>

	<div class="button-area">
		<a class="ajaxHTML button big-icon" title="Change your account settings, such as name, birthday, presentation"
			href="<?=base_url('account/settings_account')?>">
			<svg width="32" height="32" class="Account">
				<use xlink:href="#player"></use>
			</svg>
			Account
		</a>
		<a class="ajaxHTML button big-icon" title="Change your email/login adress"
			href="<?=base_url('account/settings_email')?>">
			<svg width="32" height="32" class="Email">
				<use xlink:href="#message"></use>
			</svg>
			Email
		</a>
		<a class="ajaxHTML button big-icon" title="Change your character name, age and such"
			href="<?=base_url('account/settings_character')?>">
			<svg width="32" height="32" class="Character">
				<use xlink:href="#crew-man"></use>
			</svg>
			Character
		</a>
		<a class="ajaxHTML button big-icon" title="Change your password for login"
			href="<?=base_url('account/settings_password')?>">
			<svg width="32" height="32" class="Password">
				<use xlink:href="#key"></use>
			</svg>
			Password
		</a>
		<a class="ajaxHTML button big-icon" title="Unregister from this game"
			href="<?=base_url('account/unregister')?>">
			<svg width="32" height="32" class="Unregister">
				<use xlink:href="#trashcan"></use>
			</svg>
			Unregister
		</a>
	</div>

	<p>
		Please write your password and click the Unregister button to delete your account and everything that is
		associated
		with it.
	</p>

	<form id="settings" class="ajaxJSON" method="post"
		action="<?=base_url('account/unregister_post')?>">

		<fieldset>
			<legend>Unregister</legend>

			<label for="password">Password</label>
			<input type="password" name="password" id="password" />

			<button type="submit" class="primary">Unregister</button>
		</fieldset>

	</form>
</div>