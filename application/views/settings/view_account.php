<div class="container">
	<h3>Account Settings</h3>

	<div class="button-area">
		<a class="ajaxHTML button big-icon" title="Change your account settings, such as name, birthday, presentation"
			href="<?=base_url('settings/account')?>">
			<svg width="32" height="32" class="Account">
				<use xlink:href="#player"></use>
			</svg>
			Account
		</a>
		<a class="ajaxHTML button big-icon" title="Change your character name, age and such"
			href="<?=base_url('settings/character')?>">
			<svg width="32" height="32" class="Character">
				<use xlink:href="#crew-man"></use>
			</svg>
			Character
		</a>
	</div>

	<form id="settings" class="ajaxJSON" method="post"
		action="<?=base_url('settings/account_post')?>">

		<fieldset>
			<legend>Account settings</legend>

			<label for="name">Full name</label>

			<input type="text" id="name" name="name"
				value="<?=$user['name']?>" />

			<label for="gender">Gender</label>

			<?php if ($user['gender'] == 'M'): ?>
			<input type="radio" name="gender" value="M" id="male" checked /> <label for="male">Male</label><br />
			<input type="radio" name="gender" value="F" id="female" /> <label for="female">Female</label>
			<?php else: ?>
			<input type="radio" name="gender" value="M" id="male" /> <label for="male">Male</label><br />
			<input type="radio" name="gender" value="F" id="female" checked /> <label for="female">Female</label>
			<?php endif; ?>

			<br />

			<input type="checkbox" id="show_gender" name="show_gender" <?=($user['show_gender'] == 1) ? 'checked' : '' ?>>
			<label for="show_gender">Show my gender</label><br />

			<label for="day, month, year">Birthday</label>
			<select name="day" class="mr-1">
				<?php for ($x = 1; $x <= 31; $x++): ?>
				<option value="<?=$x?>" <?=(date("j", strtotime($user['birthday'])) == $x) ? 'selected' : '' ?>><?=$x?>
				</option>
				<?php endfor; ?>
			</select>

			<select name="month" class="mr-1">
				<?php foreach ($months as $number => $month): ?>
				<option value="<?=$number?>" <?=(date("n", strtotime($user['birthday'])) == $number) ? 'selected' : '' ?>><?=$month?>
				</option>
				<?php endforeach; ?>
			</select>

			<select name="year">
				<?php for ($x = 1930; $x <= 2015; $x++): ?>
				<option value="<?=$x?>" <?=(date("Y", strtotime($user['birthday'])) == $x) ? 'selected' : '' ?>><?=$x?>
				</option>
				<?php endfor; ?>
			</select>

			<br />

			<input type="checkbox" id="show_age" name="show_age" <?=($user['show_age'] == 1) ? 'checked' : '' ?>>
			<label for="show_age">Show my age</label><br />

			<label for="presentation">Presentation</label>
			<textarea name="presentation"
				id="presentation"><?=$user['presentation']?></textarea>

			<br />
			<button type="submit" class="primary">Save</button>
		</fieldset>
	</form>

	<hr />

	<form id="profile_picture_form"
		action="<?=base_url('settings/upload_profile_picture')?>"
		method="POST" enctype="multipart/form-data">
		<fieldset>
			<legend>Profile picture</legend>

			<div>
				<img
					src="<?=$viewdata['profile_picture']?>">
			</div>

			<input type="file" id="profile_picture_select" name="profile_picture_select[]" />

			<button type="submit">Upload</button>
		</fieldset>
	</form>

	<hr />

	<form id="settings" class="ajaxJSON" method="post"
		action="<?=base_url('settings/password_post')?>">

		<fieldset>
			<legend>Change password</legend>

			<p>You might be logged out if you change the password. Just login again with the new password.</p>

			<label for="old_password">Current password</label>
			<input type="password" name="old_password" id="old_password" />

			<label for="new_password">New password</label>
			<input type="password" name="new_password" id="new_password" />

			<label for="repeated_new_password">Repeat new password</label>
			<input type="password" name="repeated_new_password" id="repeated_new_password" />

			<br><button type="submit" class="primary">Save</button>
		</fieldset>
	</form>

	<hr />

	<form id="settings" class="ajaxJSON" method="post"
		action="<?=base_url('settings/send_email_verification')?>">

		<fieldset>
			<legend>Change email</legend>

			<p>
				If you changes your email adress, your new mail box will recieve a verification link.
				If you click that link, your email will be changed. You have to login with your new
				adress to continue playing <?=$this->config->item('site_name')?>!
			</p>

			<label for="new_email">New email address</label>
			<input type="email" name="new_email" id="new_email"
				value="<?=$user['email']?>"
				required />

			<button type="submit" class="primary">Save</button>
		</fieldset>
	</form>

	<hr />

	<form id="settings" class="ajaxJSON" method="post"
		action="<?=base_url('settings/unregister_post')?>">

		<fieldset>
			<legend>Unregister</legend>

			<p>
				Please write your password and click the Unregister button to delete your account and everything that is
				associated with it.
			</p>

			<label for="password">Password</label>
			<input type="password" name="password" id="password" required />

			<button type="submit" class="primary">Unregister</button>
		</fieldset>

	</form>
</div>