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
		<a class="ajaxHTML button big-icon" title="Unregister from this game"
			href="<?=base_url('settings/unregister')?>">
			<svg width="32" height="32" class="Unregister">
				<use xlink:href="#trashcan"></use>
			</svg>
			Unregister
		</a>
	</div>

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
</div>