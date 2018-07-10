﻿<? if (isset($json)): ?>
	<script type="text/javascript">
		gameManipulateDOM(<?php echo $json?>);
	</script>
<? endif; ?>

<header title="Character settings">
	<h3>Character Settings</h3>
</header>

<section class="actions">
	<a class="ajaxHTML" title="Change your account settings, such as name, birthday, presentation" href="<?php echo base_url('account/settings_account')?>"><img src="<?php echo base_url('assets/images/icons/settings_account.png')?>" alt="Account" width="32" height="32">Account</a>
	<a class="ajaxHTML" title="Change your email/login adress" href="<?php echo base_url('account/settings_email')?>"><img src="<?php echo base_url('assets/images/icons/settings_email.png')?>" alt="Email" width="32" height="32">Email</a>
	<a class="ajaxHTML" title="Change your character name, age and such" href="<?php echo base_url('account/settings_character')?>"><img src="<?php echo base_url('assets/images/icons/settings_character.png')?>" alt="Character" width="32" height="32">Character</a>
	<a class="ajaxHTML" title="Change your password for login" href="<?php echo base_url('account/settings_password')?>"><img src="<?php echo base_url('assets/images/icons/settings_password.png')?>" alt="Password" width="32" height="32">Password</a>
	<a class="ajaxHTML" title="Unregister from this game" href="<?php echo base_url('account/unregister')?>"><img src="<?php echo base_url('assets/images/icons/settings_unregister.png')?>" alt="Unregister" width="32" height="32">Unregister</a>
</section>

<form id="settings" class="ajaxJSON" method="post" action="<?php echo base_url('account/settings_character_post')?>">

<fieldset>
	<div id="msg"></div>
	
	<legend>Your character</legend>
	
	<div style="float: left; padding: 0.5em 0.5em 0.5em 1em">
		<input type="hidden" id="character_avatar" name="character_avatar" value="<?php echo $game['character_gender_long'] . '###' . $game['character_avatar']?>">
		<input type="hidden" id="character_gender" name="character_gender" value="<?php echo $game['character_gender']?>">

		<div id="avatar_selector_div" title="Avatar selector" data-url="<?php echo base_url('account/avatar_selector/')?>/<?php echo $game['character_gender_long']?>"></div>

		<img id="current_avatar_img" style="border-radius: 4px; border: 1px black solid;" src="<?php echo $game['character_avatar_path']?>" alt="Avatar"><br>
		<button type="button" id="change_avatar_button">Change</button>
	</div>
	
	<div style="float: left;">
		<label for="character_name">Name</label>
		<input id="character_name" type="text" name="character_name" value="<?php echo $game['character_name']?>">
		<a class="ajaxJSON" href="<?php echo base_url('account/generate_character')?>" title="Generate random character"><img src="<?php echo base_url('assets/images/icons/tavern_gamble.png')?>" alt="Random"></a><br>

		<label for="character_age">Age</label>
		<input id="character_age" type="number" name="character_age" placeholder="Character age" value="<?php echo $game['character_age']?>"><br>

		<label for="character_description">Description</label>
		<textarea name="character_description"><?php echo $game['character_description']?></textarea>
			
		<label for="reset_game" title="You will get 4 crew members, 1 ship and 300 dbl">Reset the game</label>
		<input type="checkbox" name="reset_game" onchange="alert('Warning! Your character will be replaced by a new one. You will lose all your possessions and start of again with 1 ship, 4 crew members. 2 cannons and 300 dbl.');">

		<br><input type="submit" value="Save">
	</div>
</fieldset>

</form>