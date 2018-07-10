<? if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?php echo $json?>);
	</script>
<? endif; ?>

<header title="Account settings">
	<h3>Account Settings</h3>
</header>

<section class="actions">
	<a class="ajaxHTML" title="Change your account settings, such as name, birthday, presentation" href="<?php echo base_url('account/settings_account')?>"><img src="<?php echo base_url('assets/images/icons/settings_account.png')?>" alt="Account" width="32" height="32">Account</a>
	<a class="ajaxHTML" title="Change your email/login adress" href="<?php echo base_url('account/settings_email')?>"><img src="<?php echo base_url('assets/images/icons/settings_email.png')?>" alt="Email" width="32" height="32">Email</a>
	<a class="ajaxHTML" title="Change your character name, age and such" href="<?php echo base_url('account/settings_character')?>"><img src="<?php echo base_url('assets/images/icons/settings_character.png')?>" alt="Character" width="32" height="32">Character</a>
	<a class="ajaxHTML" title="Change your password for login" href="<?php echo base_url('account/settings_password')?>"><img src="<?php echo base_url('assets/images/icons/settings_password.png')?>" alt="Password" width="32" height="32">Password</a>
	<a class="ajaxHTML" title="Unregister from this game" href="<?php echo base_url('account/unregister')?>"><img src="<?php echo base_url('assets/images/icons/settings_unregister.png')?>" alt="Unregister" width="32" height="32">Unregister</a>
</section>

<div id="msg"></div>

<form id="profile_picture_form" action="<?php echo base_url('account/upload_profile_picture')?>" method="POST" enctype="multipart/form-data">
	<fieldset>
		<legend>Profile picture</legend>

		<div style="width: 100px; height: 100px; padding: 1em;" id="image_preview">
			<? if (file_exists(APPPATH . '../assets/images/profile_pictures/' . $user['id'] . '.jpg')): ?>
				<img style="border-radius: 4px" src="<?php echo APPPATH . '../assets/images/profile_pictures/' . $user['id'] . '.jpg'?>">
			<? endif; ?>
		</div>
	
		<input type="file" id="profile_picture_select" name="profile_picture_select[]">
		
		<input type="submit" value="Upload">
	</fieldset>
</form>

<form id="settings" class="ajaxJSON" method="post" action="<?php echo base_url('account/settings_account_post')?>">

	<fieldset>
		<legend>Account settings</legend>
		
		<label for="name">Full name</label>
		<input type="text" name="name" value="<?php echo $user['name']?>">
		
		<label for="gender">Gender</label>
		<p>
			<? if ($user['gender'] == 'M'): ?>
				Male: <input type="radio" name="gender" value="M" checked>
				Female: <input type="radio" name="gender" value="F">
			<? else: ?>
				Male: <input type="radio" name="gender" value="M">
				Female: <input type="radio" name="gender" value="F" checked>
			<? endif; ?>
		</p>
		
		<label for="day, month, year">Birthday</label>
		<select name="day">
			<? for ($x = 1; $x <= 31; $x++): ?>
				<option value="<?php echo $x?>"<? echo (date("j", strtotime($user['birthday'])) == $x) ? 'selected' : '' ?>><?php echo $x?></option>
			<? endfor; ?>
		</select>
		
		<select name="month">
			<? foreach ($months as $number => $month): ?>
				<option value="<?php echo $number?>"<? echo (date("n", strtotime($user['birthday'])) == $number) ? 'selected' : '' ?>><?php echo $month?></option>
			<? endforeach; ?>
		</select>
		
		<select name="year">
			<? for ($x = 1930; $x <= 2010; $x++): ?>
				<option value="<?php echo $x?>"<? echo (date("Y", strtotime($user['birthday'])) == $x) ? 'selected' : '' ?>><?php echo $x?></option>
			<? endfor; ?>
		</select>
		
		<label for="presentation">Presentation</label>
		<textarea name="presentation"><?php echo $user['presentation']?></textarea>
		
		<label for="notify_new_messages">Email me messages from other players</label>
		<input type="checkbox" name="notify_new_messages"<?echo ($user['notify_new_messages'] == 1) ? 'checked' : '' ?>>
		
		<p><strong>Privacy settings</strong></p>
		
		<label for="show_email">Show my email address</label>
		<input type="checkbox" name="show_email"<?echo ($user['show_email'] == 1) ? 'checked' : '' ?>>
		
		<label for="show_gender">Show my gender</label>
		<input type="checkbox" name="show_gender"<?echo ($user['show_gender'] == 1) ? 'checked' : '' ?>>
		
		<label for="show_age">Show my age</label>
		<input type="checkbox" name="show_age"<?echo ($user['show_age'] == 1) ? 'checked' : '' ?>>
		
		<label for="show_history">Show my log book and history data</label>
		<input type="checkbox" name="show_history"<?echo ($user['show_history'] == 1) ? 'checked' : '' ?>>
		
		<br><input type="submit" value="Save">
	</fieldset>

</form>